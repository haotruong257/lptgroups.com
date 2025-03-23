<?php

namespace Config;

$routes = Services::routes();
// $routes->get('rating', 'EvaluationController::index', ['namespace' => 'Rating\Controllers']);
// $routes->get('category', 'EvaluationController::categoryView', ['namespace' => 'Rating\Controllers']);  
$routes->group('', ['namespace' => 'Rating\Controllers'], function ($routes) {
    $routes->get('rating', 'EvaluationController::index');
    $routes->get('category', 'EvaluationController::categoryView');
    // $routes->get('category/createCategory', 'EvaluationController::createCategory'); // Route để hiển thị form tạo tiêu chí
    $routes->post('category/createCategory', 'EvaluationController::createCategory'); // Route để xử lý form gửi dữ liệu
});
