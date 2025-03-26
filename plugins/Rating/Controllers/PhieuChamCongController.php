<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\ChiTietPhieuChamCongModel;
use Rating\Models\PhieuChamCongModel;

class PhieuChamCongController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách phiếu chấm công
    public function index(): string
    {
        $loginUserID =  $this->login_user->is_admin ? 0 : $this->login_user->id;
        $model = new PhieuChamCongModel();
        $data['phieu_cham_cong'] = $model->getPhieuChamCong($loginUserID);;
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
            if ($latestMonth === $currentMonth) {
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
            'approve_id' => $this->request->getPost('approve_id'),
            'approve_at' => $this->request->getPost('approve_at'),
            'trang_thai' => 'pending',
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
        $model = new PhieuChamCongModel();
        $data['phieu_cham_cong'] = $model->get_phieu_cham_cong($id);
        return $this->template->rander('Rating\Views\phieu_cham_cong\edit', $data);
    }

    public function update($id)
    {
        $model = new PhieuChamCongModel();

        $data = [
            'created_id' => $this->request->getPost('created_id'),
            'approve_id' => $this->request->getPost('approve_id'),
            'approve_at' => $this->request->getPost('approve_at'),
            'trang_thai' => $this->request->getPost('trang_thai'),
            'tong_diem' => $this->request->getPost('tong_diem')
        ];

        $model->update_phieu_cham_cong($data, $id);
        return redirect()->to('/phieu_cham_cong')->with('success', 'Cập nhật phiếu chấm công thành công!');
    }

    // Xóa phiếu chấm công
    public function delete($id)
    {
        $model = new PhieuChamCongModel();
        $model->delete_phieu_cham_cong($id);
        return redirect()->to('/phieu_cham_cong')->with('success', 'Xóa phiếu chấm công thành công!');
    }
}
