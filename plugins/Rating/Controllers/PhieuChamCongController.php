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
        $model = new PhieuChamCongModel();
        $data['phieu_cham_cong'] = $model->get_all_phieu_cham_cong_with_users();
        return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
    }

    // Thêm phiếu chấm công mới
    // Thêm phiếu chấm công mới
    public function create()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        // if (!session()->get('isLoggedIn') || !session()->get('user_id')) {
        //     return redirect()->to('/login')->with('error', 'Vui lòng đăng nhập để thực hiện hành động này.');
        // }

        $model = new PhieuChamCongModel();

        // Lấy user_id của người dùng hiện tại từ session
        $currentUserId = $this->Users_model->login_user_id();

        // Dữ liệu cho bảng phieu_cham_cong
        $phieuData = [
            'created_id' => $currentUserId,
            'created_at' => date('Y-m-d H:i:s'),
            'approve_id' => $this->request->getPost('approve_id'),
            'approve_at' => $this->request->getPost('approve_at'),
            'trang_thai' => 'pending', // Luôn là pending khi nhân viên gửi
            'tong_diem' => 0 // Sẽ cập nhật sau khi lưu chi tiết
        ];
        echo "<pre> ID Phieu Cham Cong : <br/>";
        print_r($phieuData);
        echo "</pre>";
        // Lưu bản ghi vào bảng phieu_cham_cong
        $idPhieuChamCong = $model->add_phieu_cham_cong($phieuData);
        if (!$idPhieuChamCong) {
            return redirect()->to('/phieu_cham_cong')->with('error', 'Không thể tạo phiếu chấm công.');
        }
        // // Lấy điểm số từ form
        $scores = $this->request->getPost('score');
        if (empty($scores)) {
            return redirect()->to('/phieu_cham_cong')->with('error', 'Vui lòng chấm điểm ít nhất một tiêu chí.');
        }

        // Lưu chi tiết vào bảng chi_tiet_phieu_cham_cong
        $chiTietModel = new ChiTietPhieuChamCongModel();
        $tongDiem = 0;
        foreach ($scores as $idNoiDung => $diemSo) {
            if (!is_numeric($diemSo) || $diemSo < 1 || $diemSo > 5) {
                continue; // Bỏ qua nếu điểm không hợp lệ
            }

            $chiTietData = [
                'id_phieu_cham_cong' => $idPhieuChamCong,
                'id_noi_dung_danh_gia' => $idNoiDung,
                'diem_so' => $diemSo
            ];

            if (!$chiTietModel->add_chi_tiet_phieu_cham_cong($chiTietData)) {
                // Xử lý lỗi nếu có
                return redirect()->to('/phieu_cham_cong')->with('error', 'Có lỗi khi lưu chi tiết phiếu chấm công.');
            }
        }
        $tongDiem = $chiTietModel->calculate_total_score($idPhieuChamCong);
        // Cập nhật tổng điểm vào bảng phieu_cham_cong

        $model->update_phieu_cham_cong(['tong_diem' => $tongDiem], $idPhieuChamCong);

        // return redirect()->to('/phieu_cham_cong')->with('success', 'Thêm phiếu chấm công thành công!');
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
