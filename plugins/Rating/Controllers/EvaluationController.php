<?php
namespace Rating\Controllers;
use App\Controllers\Security_Controller;

class EvaluationController extends Security_Controller {
    function __construct() {
        parent::__construct();
    }

    public function index(): string {
        return $this->template->rander('Rating\Views\evaluation\index');
        // $model = new  EvaluationModel();
        // $data['criteria'] = $model->findAll();
        // return view(name: 'evaluation/index', data: $data);
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
