<?php

namespace Config;

$routes = Services::routes();

$routes->group('', ['namespace' => 'Rating\Controllers'], function ($routes) {
    // Routes cho EvaluationController (giữ nguyên từ file gốc)
    // $routes->get('rating', 'EvaluationController::index');
    $routes->get('category', 'EvaluationController::categoryView');
    $routes->get('rating', 'MainController::index'); 

    // $routes->post('category/createCategory', 'EvaluationController::createCategory');

    // Routes cho EvaluationCriteriaCategoryController
    $routes->get('evaluation_criteria_category', 'EvaluationCriteriaCategoryController::index'); // Hiển thị danh sách danh mục tiêu chí
    $routes->post('evaluation_criteria_category/create', 'EvaluationCriteriaCategoryController::create'); // Thêm danh mục tiêu chí mới
    $routes->get('evaluation_criteria_category/edit/(:num)', 'EvaluationCriteriaCategoryController::edit/$1'); // Hiển thị form chỉnh sửa danh mục
    $routes->post('evaluation_criteria_category/update/(:num)', 'EvaluationCriteriaCategoryController::update/$1'); // Cập nhật danh mục
    $routes->get('evaluation_criteria_category/delete/(:num)', 'EvaluationCriteriaCategoryController::delete/$1'); // Xóa danh mục

    // Routes cho EvaluationCriteriaController
    $routes->get('evaluation_criteria', 'EvaluationCriteriaController::index'); // Hiển thị danh sách tiêu chí
    $routes->post('evaluation_criteria/create', 'EvaluationCriteriaController::create'); // Thêm tiêu chí mới
    $routes->get('evaluation_criteria/edit/(:num)', 'EvaluationCriteriaController::edit/$1'); // Hiển thị form chỉnh sửa tiêu chí
    $routes->post('evaluation_criteria/update/(:num)', 'EvaluationCriteriaController::update/$1'); // Cập nhật tiêu chí
    $routes->get('evaluation_criteria/delete/(:num)', 'EvaluationCriteriaController::delete/$1'); // Xóa tiêu chí

    // Routes cho PhieuChamCongController
    $routes->get('phieu_cham_cong', 'PhieuChamCongController::index'); // Hiển thị danh sách phiếu chấm công
    $routes->post('phieu_cham_cong/create', 'PhieuChamCongController::create'); // Thêm phiếu chấm công mới
    $routes->get('phieu_cham_cong/edit/(:num)', 'PhieuChamCongController::edit/$1'); // Hiển thị form chỉnh sửa phiếu
    $routes->post('phieu_cham_cong/update/(:num)', 'PhieuChamCongController::update/$1'); // Cập nhật phiếu
    $routes->get('phieu_cham_cong/delete/(:num)', 'PhieuChamCongController::delete/$1'); // Xóa phiếu

    // Routes cho ChiTietPhieuChamCongController
    $routes->get('chi_tiet_phieu_cham_cong', 'ChiTietPhieuChamCongController::index'); // Hiển thị danh sách chi tiết phiếu chấm công
    $routes->get('chi_tiet_phieu_cham_cong/(:num)', 'ChiTietPhieuChamCongController::index/$1'); // Hiển thị chi tiết theo id_phieu_cham_cong
    $routes->post('chi_tiet_phieu_cham_cong/create', 'ChiTietPhieuChamCongController::create'); // Thêm chi tiết phiếu chấm công mới
    $routes->get('chi_tiet_phieu_cham_cong/edit/(:num)', 'ChiTietPhieuChamCongController::edit/$1'); // Hiển thị form chỉnh sửa chi tiết
    $routes->post('chi_tiet_phieu_cham_cong/update/(:num)', 'ChiTietPhieuChamCongController::update/$1'); // Cập nhật chi tiết
    $routes->get('chi_tiet_phieu_cham_cong/delete/(:num)', 'ChiTietPhieuChamCongController::delete/$1'); // Xóa chi tiết
});
