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
    public function create() {}
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
