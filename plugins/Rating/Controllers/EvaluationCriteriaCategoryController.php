<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\EvaluationCategoryModel;

class EvaluationCriteriaCategoryController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách danh mục tiêu chí
    public function index(): string
    {
        $model = new EvaluationCategoryModel();
        $data['categories'] = $model->get_all_criteriaCategory();
        return $this->template->rander('Rating\Views\evaluation_criteria_category\index', $data);
    }

    // Thêm danh mục tiêu chí mới
    public function create()
    {
        $model = new EvaluationCategoryModel();

        $data = [
            'name' => $this->request->getPost('name')
        ];

        $model->add_criteriaCategory($data);
        return redirect()->to('/evaluation_criteria_category')->with('success', 'Thêm danh mục tiêu chí thành công!');
    }

    // Chỉnh sửa danh mục tiêu chí
    public function edit($id)
    {
        $model = new EvaluationCategoryModel();
        $data['category'] = $model->get_criteriaCategory($id);
        return $this->template->rander('Rating\Views\evaluation_criteria_category\edit', $data);
    }

    public function update($id)
    {
        $model = new EvaluationCategoryModel();

        $data = [
            'name' => $this->request->getPost('name')
        ];

        $model->update_criteriaCategory($data, $id);
        return redirect()->to('/evaluation_criteria_category')->with('success', 'Cập nhật danh mục tiêu chí thành công!');
    }

    // Xóa danh mục tiêu chí
    public function delete($id)
    {
        $model = new EvaluationCategoryModel();
        $model->delete_criteriaCategory($id);
        return redirect()->to('/evaluation_criteria_category')->with('success', 'Xóa danh mục tiêu chí thành công!');
    }
}
