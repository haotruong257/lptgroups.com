<?php
namespace Rating\Controllers;
use App\Controllers\Security_Controller;
use Rating\Models\EvaluationModel;
use Rating\Models\EvaluationCategoryModel;
class EvaluationController extends Security_Controller {
    function __construct() {
        parent::__construct();
    }

    public function index(): string {
         $model = new  EvaluationModel();
         $data['criteria'] = $model->get_all_criteria_with_category();
        return $this->template->rander('Rating\Views\evaluation\index',$data);
    }

    public function categoryView() {
        $model = new  EvaluationCategoryModel();
        $data['categories'] = $model->get_all_criteriaCategory();
        return $this->template->rander('Rating\Views\evaluation_category\index', $data);
    }

}

// <?php

// namespace Demo\Controllers;

// use App\Controllers\Security_Controller;

// class Demo extends Security_Controller {

//     function __construct() {
//         parent::__construct();
//     }

//     function index() {
//         return $this->template->rander('Demo\Views\demo\index');
//     }

// }
