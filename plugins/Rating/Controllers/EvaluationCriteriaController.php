<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\EvaluationCriteriaModel;
use Rating\Models\PhieuChamCongModel;

class EvaluationCriteriaController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách tiêu chí kèm danh mục
    public function index(): string
    {
        $model = new EvaluationCriteriaModel();
        $data['criteria'] = $model->get_all_criteria_with_category();
        return $this->template->rander('Rating\Views\evaluation_criteria\index', $data);
        // $model = new PhieuChamCongModel();
        // $data['phieu_cham_cong'] = $model->getPhieuChamCong();
        // $model = new EvaluationCriteriaModel();
        // $data['criteria'] = $model->get_all_criteria_with_category();
        // if ($this->login_user->is_admin) {
        //     return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
        // } else {
        //     return $this->template->rander('Rating\Views\evaluation_criteria\index', $data);
        // }
    }

    // Thêm tiêu chí mới
    public function create()
    {
        $model = new EvaluationCriteriaModel();

        $data = [
            'id_tieu_chi' => $this->request->getPost('id_tieu_chi'),
            'noi_dung' => $this->request->getPost('noi_dung'),
            'thu_tu_sap_xep' => $this->request->getPost('thu_tu_sap_xep')
        ];

        $model->add_criteria($data);
        return redirect()->to('/evaluation_criteria')->with('success', 'Thêm tiêu chí thành công!');
    }

    // Chỉnh sửa tiêu chí
    public function edit($id)
    {
        $model = new EvaluationCriteriaModel();
        $data['criteria'] = $model->get_criteria($id);
        return $this->template->rander('Rating\Views\evaluation_criteria\edit', $data);
    }

    public function update($id)
    {
        $model = new EvaluationCriteriaModel();

        $data = [
            'id_tieu_chi' => $this->request->getPost('id_tieu_chi'),
            'noi_dung' => $this->request->getPost('noi_dung'),
            'thu_tu_sap_xep' => $this->request->getPost('thu_tu_sap_xep')
        ];

        $model->update_criteria($data, $id);
        return redirect()->to('/evaluation_criteria')->with('success', 'Cập nhật tiêu chí thành công!');
    }

    // Xóa tiêu chí
    public function delete($id)
    {
        $model = new EvaluationCriteriaModel();
        $model->delete_criteria($id);
        return redirect()->to('/evaluation_criteria')->with('success', 'Xóa tiêu chí thành công!');
    }
}
