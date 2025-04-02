<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\ChiTietPhieuChamCongModel;

class ChiTietPhieuChamCongController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách chi tiết phiếu chấm công
    public function index($id_phieu_cham_cong = null): string
    {
        $model = new ChiTietPhieuChamCongModel();
        if ($id_phieu_cham_cong) {
            $data['details'] = $model->get_details_with_criteria($id_phieu_cham_cong);
            $data['id_phieu_cham_cong'] = $id_phieu_cham_cong;
            $data['tong_diem'] = $model->calculate_total_score($id_phieu_cham_cong);
            $data["trang_thai"] = $model -> get_status_phieu_cham_cong($id_phieu_cham_cong);
        } else {
            $data['details'] = $model->get_all_chi_tiet_phieu_cham_cong(10, $this->request->getGet('page') ? ($this->request->getGet('page') - 1) * 10 : 0);
            echo "<pre> ID Phieu Cham Cong : <br/>";
            print_r($data['details']);
            echo "</pre>";
            die();
        }
        return $this->template->rander('Rating\Views\chi_tiet_phieu_cham_cong\index', $data);
    }
    public function test()
    {
        echo "test";
    }
    // Thêm chi tiết phiếu chấm công mới
    public function create()
    {

        $model = new ChiTietPhieuChamCongModel();
        $id_phieu_cham_cong = $this->request->getPost('id_phieu_cham_cong');
        $scores = $this->request->getPost('score'); // Mảng score[id_tieu_chi] => diem_so
        echo "<pre> ID Phieu Cham Cong : <br/>";
        print_r($id_phieu_cham_cong);
        echo "</pre>";

        echo "<pre> Scores : <br/>";
        print_r($scores);
        echo "</pre>";
        if ($scores && $id_phieu_cham_cong) {
            foreach ($scores as $id_noi_dung_danh_gia => $diem_so) {
                $data = [
                    'id_noi_dung_danh_gia' => $id_noi_dung_danh_gia,
                    'diem_so' => $diem_so,
                    'id_phieu_cham_cong' => $id_phieu_cham_cong
                ];
                $model->add_chi_tiet_phieu_cham_cong($data);
            }
        }

        return redirect()->to('/evaluation_criteria')->with('success', 'Thêm chi tiết phiếu chấm công thành công!');
    }
    // Chỉnh sửa chi tiết phiếu chấm công
    public function edit($id)
    {
        $model = new ChiTietPhieuChamCongModel();
        $data['detail'] = $model->get_chi_tiet_phieu_cham_cong($id);
        return $this->template->rander('Rating\Views\chi_tiet_phieu_cham_cong\edit', $data);
    }

    public function update($id)
    {
        $model = new ChiTietPhieuChamCongModel();

        $data = [
            'id_noi_dung_danh_gia' => $this->request->getPost('id_noi_dung_danh_gia'),
            'diem_so' => $this->request->getPost('diem_so'),
            'id_phieu_cham_cong' => $this->request->getPost('id_phieu_cham_cong')
        ];

        $model->update_chi_tiet_phieu_cham_cong($data, $id);
        return redirect()->to('/chi_tiet_phieu_cham_cong')->with('success', 'Cập nhật chi tiết phiếu chấm công thành công!');
    }

    // Xóa chi tiết phiếu chấm công
    public function delete($id)
    {
        $model = new ChiTietPhieuChamCongModel();
        $model->delete_chi_tiet_phieu_cham_cong($id);
        return redirect()->to('/chi_tiet_phieu_cham_cong')->with('success', 'Xóa chi tiết phiếu chấm công thành công!');
    }
}
