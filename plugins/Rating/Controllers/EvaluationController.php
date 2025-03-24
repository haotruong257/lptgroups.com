<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\EvaluationCriteriaModel;
use Rating\Models\EvaluationModel;

class EvaluationController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách tiêu chí kèm danh mục
    public function index(): string
    {
        $model = new EvaluationModel();
        $data['criteria'] = $model->get_all_criteria_with_category();
        echo '<pre>';
        print_r($data['criteria']);
        echo '</pre>';
        exit;

        return $this->template->rander('Rating\Views\evaluation\index', $data);
    }
    // public function index2(): string
    // {
    //     $model = new EvaluationCriteriaModel();
    //     $data['criteria'] = $model->get_all_criteria_with_category();
    //     return $this->template->rander('Rating\Views\evaluation_criteria\index', $data);
    // }

    // Thêm tiêu chí mới
    public function create()
    {
        $model = new EvaluationModel();

        $data = [
            'category' => $this->request->getPost('category'),
            'noi_dung' => $this->request->getPost('noi_dung'),
            'diem' => $this->request->getPost('diem'),
            'chi_tiet' => $this->request->getPost('chi_tiet') ?? ''
        ];

        $model->add_criteria($data);
        return redirect()->to('/evaluation')->with('success', 'Thêm tiêu chí thành công!');
    }

    // Chỉnh sửa tiêu chí
    public function edit($id)
    {
        $model = new EvaluationModel();
        $data['criteria'] = $model->find($id);
        return $this->template->rander('Rating\Views\evaluation\edit', $data);
    }

    public function update($id)
    {
        $model = new EvaluationModel();

        $data = [
            'category' => $this->request->getPost('category'),
            'noi_dung' => $this->request->getPost('noi_dung'),
            'diem' => $this->request->getPost('diem'),
            'chi_tiet' => $this->request->getPost('chi_tiet') ?? ''
        ];

        $model->update_criteria($data, $id);
        return redirect()->to('/evaluation')->with('success', 'Cập nhật thành công!');
    }

    // Xóa tiêu chí
    public function delete($id)
    {
        $model = new EvaluationModel();
        $model->delete_criteria($id);
        return redirect()->to('/evaluation')->with('success', 'Xóa tiêu chí thành công!');
    }
}
