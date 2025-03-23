<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\EvaluationModel;
use Rating\Models\EvaluationCategoryModel;

class EvaluationController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index(): string
    {
        $model = new  EvaluationModel();
        $data['criteria'] = $model->get_all_criteria_with_category();
        return $this->template->rander('Rating\Views\evaluation\index', $data);
    }

    public function create()
    {
        $model = new  EvaluationModel();

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'noi_dung' => $this->request->getPost('noi_dung'),
            'diem' => $this->request->getPost('diem'),
        ];
        $model->insert($data);
        return redirect()->to('/evaluation');
    }

    public function createCategory()
    {
        $categoryModel = new EvaluationCategoryModel();

        // Nhận dữ liệu từ form
        // $data = [
        //     'name' => $this->request->getPost('name'),
        // ];
        $data = $this->request->getPost();

        // Thêm danh mục vào database
        $insert_id = $categoryModel->add_criteriaCategory($data);

        if ($insert_id) {
            return redirect()->to('/category')->with('success', 'Thêm danh mục thành công!');
        } else {
            return redirect()->to('/category')->with('error', 'Thêm danh mục thất bại!');
        }
    }


    public function categoryView()
    {
        $model = new  EvaluationCategoryModel();
        $data['categories'] = $model->get_all_criteriaCategory();
        return $this->template->rander('Rating\Views\evaluation_category\index', $data);
    }
}
