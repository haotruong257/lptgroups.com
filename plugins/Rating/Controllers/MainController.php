<?php

namespace Rating\Controllers;

use App\Controllers\Security_Controller;
use Rating\Models\EvaluationCriteriaModel;
use Rating\Models\PhieuChamCongModel;

class MainController extends Security_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Danh sách tiêu chí kèm danh mục
    public function index(): string
    {

        $model = new PhieuChamCongModel();     
        // $model = new EvaluationCriteriaModel();
        // $data['criteria'] = $model->get_all_criteria_with_category();
        if ($this->login_user->is_admin) {
            $data['phieu_cham_cong'] = $model->getPhieuChamCong();
            return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
        } else {
            $user_id = $this->login_user->id;
            $data['phieu_cham_cong'] = $model->getPhieuChamCong($user_id);
            return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
        }
    }
}