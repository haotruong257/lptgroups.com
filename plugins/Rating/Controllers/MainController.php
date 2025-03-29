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

    // // Danh sách tiêu chí kèm danh mục
    // public function index(): string
    // {

    //     $model = new PhieuChamCongModel();
    //     $loginUserID =  $this->login_user->is_admin ? 0 : $this->login_user->id;     
    //     // Lấy thông tin từ query string
    // $searchName = $this->request->getGet('search') ?? '';
    // $searchDate = $this->request->getGet('date') ?? '';
    // $trangThai = $this->request->getGet('trang_thai') ?? '';
    // // Số lượng bản ghi mỗi trang
    // $perPage = 10;
    // $page = max(1, (int) $this->request->getGet('page')); // Không cho phép page < 1
    // $totalRecords = $model->countPhieuChamCong($loginUserID);
    // $offset = ($page - 1) * $perPage;
    // // Lấy dữ liệu với phân trang
    // $data['phieu_cham_cong'] = $model->searchPhieuChamCong($perPage, $offset, $searchName, $searchDate, $trangThai, $loginUserID);
    // // Tính tổng số bản ghi để phân trang

    
    // //Tạo dữ liệu phân trang
    // $data['pager'] = [
    //     'total' => $totalRecords,
    //     'perPage' => $perPage,
    //     'currentPage' => $page,
    //     'totalPages' => ceil($totalRecords / $perPage),
    // ];
    // echo "<pre>";
    // print_r($data['pager']);
    // echo "</pre>";
    // die();
    // return $this->template->rander('Rating\Views\phieu_cham_cong\index', $data);
    // }
}