<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\ChiTietPhieuChamCongModel;
use Rating\Models\PhieuChamCongModel;
use Rating\Models\EvaluationCriteriaModel;

class PhieuChamCongController extends Security_Controller
{
    protected $db;
    function __construct()
    {
        parent::__construct();
        $this->db = db_connect('default');
    }

    // Danh sách phiếu chấm công
    public function index(): string
    {
        $loginUserID =  $this->login_user->is_admin ? 0 : $this->login_user->id;
        $model = new PhieuChamCongModel();

        // Số lượng bản ghi mỗi trang
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $searchName = $this->request->getGet("search") ?? '';
        $searchDate = $this->request->getGet("date") ?? '';
        $trangThai = $this->request->getGet("trang_thai") ?? '';

        if (!empty($searchName) || !empty($searchDate) || !empty($trangThai)) {
            $data['search'] = $searchName;
            $data['date'] = $searchDate;
            $data['trang_thai'] = $trangThai;
            // Tính tổng số bản ghi để phân trang
            $totalRecords = $model->countPhieuChamCong($searchName, $searchDate, $trangThai, $loginUserID);
            $data['pager'] = [
                'total' => $totalRecords,
                'perPage' => $perPage,
                'currentPage' => $page,
                'totalPages' => ceil($totalRecords / $perPage),
            ];
            $data['phieu_cham_cong'] = $model->searchPhieuChamCong($searchName, $searchDate, $trangThai, $loginUserID, $perPage, $offset);
        } else {
            // Tính tổng số bản ghi để phân trang
            $totalRecords = $model->countPhieuChamCong($searchName, $searchDate, $trangThai, $loginUserID);
            $data['pager'] = [
                'total' => $totalRecords,
                'perPage' => $perPage,
                'currentPage' => $page,
                'totalPages' => ceil($totalRecords / $perPage),
            ];
            //$data['phieu_cham_cong'] = $model->searchPhieuChamCong($searchName, $searchDate, $trangThai, $loginUserID,$perPage, $offset);
            $data['phieu_cham_cong'] = $model->getPhieuChamCong($loginUserID, $perPage, $offset);
        }

        return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
    }

    // Thêm phiếu chấm công mới
    public function create()
    {
        $model = new PhieuChamCongModel();
        $currentUserId = $this->Users_model->login_user_id();

        $latestPhieu = $model->where('created_id', $currentUserId)
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($latestPhieu) {
            $latestMonth = date('Y-m', strtotime($latestPhieu['created_at']));
            $currentMonth = date('Y-m');
            if ($latestMonth === $currentMonth && $latestPhieu['trang_thai'] != 3) {
                $this->session->setFlashdata('popup', [
                    'type' => 'warning',
                    'title' => 'Nhắc nhở',
                    'message' => 'Bạn đã tạo phiếu chấm công cho tháng ' . $currentMonth . ' rồi!',
                    'duration' => 5000
                ]);
                return redirect()->to('/phieu_cham_cong');
            }
        }

        // Lấy điểm số từ form trước
        $scores = $this->request->getPost('score');
        if (empty($scores) || !is_array($scores)) {
            $this->session->setFlashdata('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Vui lòng chấm điểm ít nhất một tiêu chí.',
                'duration' => 5000
            ]);
            return redirect()->to('/evaluation_criteria');
        }

        // Dữ liệu cho bảng phieu_cham_cong
        $phieuData = [
            'created_id' => $currentUserId,
            'created_at' => date('Y-m-d H:i:s'),
            // 'approve_id' => $this->request->getPost('approve_id'),
            // 'approve_at' => $this->request->getPost('approve_at'),
            'trang_thai' => 1, // Trạng thái 1: Chờ duyệt
            'tong_diem' => 0
        ];

        // Lưu bản ghi vào bảng phieu_cham_cong
        $idPhieuChamCong = $model->add_phieu_cham_cong($phieuData);
        if (!$idPhieuChamCong) {
            $this->session->setFlashdata('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Không thể tạo phiếu chấm công.',
                'duration' => 5000
            ]);
            return redirect()->to('/phieu_cham_cong');
        }

        // Lưu chi tiết vào bảng chi_tiet_phieu_cham_cong
        $chiTietModel = new ChiTietPhieuChamCongModel();
        $tongDiem = 0;
        foreach ($scores as $idNoiDung => $diemSo) {
            if (!is_numeric($diemSo) || $diemSo < 1 || $diemSo > 5) {
                continue;
            }

            $chiTietData = [
                'id_phieu_cham_cong' => $idPhieuChamCong,
                'id_noi_dung_danh_gia' => $idNoiDung,
                'diem_so' => $diemSo
            ];

            if (!$chiTietModel->add_chi_tiet_phieu_cham_cong($chiTietData)) {
                return redirect()->to('/phieu_cham_cong')->with('error', 'Có lỗi khi lưu chi tiết phiếu chấm công.');
            }
        }

        $tongDiem = $chiTietModel->calculate_total_score($idPhieuChamCong);
        $model->update_phieu_cham_cong(['tong_diem' => $tongDiem], $idPhieuChamCong);

        $this->session->setFlashdata('popup', [
            'type' => 'success',
            'title' => 'Thành công',
            'icon' => "success",
            'message' => 'Thêm phiếu chấm công thành công!',
            'duration' => 5000
        ]);
        return redirect()->to('/phieu_cham_cong');
    }

    // Chỉnh sửa phiếu chấm công
    public function edit($id)
    {
        try {
            // Kiểm tra login_user
            if (!isset($this->login_user) || !isset($this->login_user->id)) {
                throw new \Exception("Debug - Người dùng chưa đăng nhập!");
            }

            $model = new PhieuChamCongModel();
            // Lấy thông tin phiếu chấm công
            $phieu = $model->getPhieuChamCongById($id);


            if (!$phieu || $phieu['created_id'] != $this->login_user->id || $phieu['trang_thai'] != 1) {
                return redirect()->to('/phieu_cham_cong')->with('popup', [
                    'type' => 'error',
                    'title' => 'Lỗi',
                    'message' => 'Bạn không có quyền chỉnh sửa phiếu này hoặc phiếu không thể chỉnh sửa!',
                    'duration' => 3000
                ]);
            }

            // Lấy điểm số hiện tại
            $scores = $model->getChiTietByPhieuId($id);

            // Lấy danh sách tiêu chí đánh giá
            $criteriaModel = new EvaluationCriteriaModel();
            $criteria = $criteriaModel->get_all_criteria_with_category();



            $data = [
                'phieu' => $phieu,
                'scores' => $scores,
                'criteria' => $criteria
            ];
            return $this->template->rander('Rating\Views\phieu_cham_cong\edit', $data);
        } catch (\Exception $e) {
            echo "Lỗi: " . $e->getMessage() . "<br>";
            echo "Dòng: " . $e->getLine() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            die();
        }
    }

    public function update($id)
    {
        $model = new PhieuChamCongModel();

        // Kiểm tra quyền chỉnh sửa
        $phieu = $model->getPhieuChamCongById($id);
        if (!$phieu || $phieu['created_id'] != $this->login_user->id || $phieu['trang_thai'] != 1) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Bạn không có quyền chỉnh sửa phiếu này hoặc phiếu không thể chỉnh sửa!',
                'duration' => 3000
            ]);
        }

        // Lấy điểm số từ form
        $scores = $this->request->getPost('score');
        if (empty($scores) || !is_array($scores)) {
            return redirect()->to('/phieu_cham_cong/edit/' . $id)->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Vui lòng chấm điểm ít nhất một tiêu chí.',
                'duration' => 3000
            ]);
        }

        // Cập nhật chi tiết và tổng điểm
        if ($model->updateChiTietPhieu($id, $scores)) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'success',
                'title' => 'Thành công',
                'message' => 'Cập nhật phiếu chấm công thành công!',
                'duration' => 3000
            ]);
        } else {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Không thể cập nhật phiếu chấm công!',
                'duration' => 3000
            ]);
        }
    }

    public function approve($id)
    {
        if (!$this->login_user->is_admin) {
            // Chỉ admin mới được duyệt
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Bạn không có quyền duyệt phiếu chấm công!',
                'duration' => 3000
            ]);
        }

        $model = new PhieuChamCongModel();
        $phieu = $model->find($id);

        if (!$phieu || $phieu['trang_thai'] != 1) {
            // Phiếu không tồn tại hoặc không ở trạng thái Pending
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Phiếu không tồn tại hoặc không thể duyệt!',
                'duration' => 3000
            ]);
        }

        // Cập nhật trạng thái duyệt
        $data = [
            'approve_id' => $this->login_user->id, // ID của admin duyệt
            'approve_at' => date('Y-m-d H:i:s'),   // Thời gian duyệt
            'trang_thai' => 2                      // Đã duyệt
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'success',
                'title' => 'Thành công',
                'message' => 'Phiếu chấm công đã được duyệt!',
                'duration' => 3000
            ]);
        } else {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Không thể duyệt phiếu chấm công!',
                'duration' => 3000
            ]);
        }
    }
    public function reject($id)
    {
        if (!$this->login_user->is_admin) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Bạn không có quyền từ chối phiếu chấm công!',
                'duration' => 3000
            ]);
        }

        $model = new PhieuChamCongModel();
        $phieu = $model->find($id);

        if (!$phieu || $phieu['trang_thai'] != 1) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Phiếu không tồn tại hoặc không thể từ chối!',
                'duration' => 3000
            ]);
        }

        $data = [
            'approve_id' => $this->login_user->id, // ID của admin từ chối
            'approve_at' => date('Y-m-d H:i:s'),  // Thời gian từ chối
            'trang_thai' => 3                     // Từ chối
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'success',
                'title' => 'Thành công',
                'message' => 'Phiếu chấm công đã bị từ chối!',
                'duration' => 3000
            ]);
        } else {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Không thể từ chối phiếu chấm công!',
                'duration' => 3000
            ]);
        }
    }
    // Xóa phiếu chấm công
    public function delete($id)
    {
        $model = new PhieuChamCongModel();

        // Kiểm tra quyền xóa
        $phieu = $model->getPhieuChamCongById(id: $id);
        if (!$phieu || $phieu['trang_thai'] != 1) { // check trang thái và phiếu có tồn tại
            if (!$this->login_user->is_admin && $phieu['created_id'] != $this->login_user->id) { // check quyền xóa
                return redirect()->to('/phieu_cham_cong')->with('popup', [
                    'type' => 'error',
                    'title' => 'Lỗi',
                    'message' => 'Bạn không có quyền xóa phiếu này hoặc phiếu không thể xóa!',
                    'duration' => 3000
                ]);
            }
        }

        // Xóa phiếu
        if ($model->deletePhieuChamCong($id)) {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'success',
                'title' => 'Thành công',
                'message' => 'Xóa phiếu chấm công thành công!',
                'duration' => 2000
            ]);
        } else {
            return redirect()->to('/phieu_cham_cong')->with('popup', [
                'type' => 'error',
                'title' => 'Lỗi',
                'message' => 'Không thể xóa phiếu chấm công!',
                'duration' => 3000
            ]);
        }
    }
}
