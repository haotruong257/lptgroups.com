<?php

namespace Config;

$routes = Services::routes();
// $routes->get('rating', 'EvaluationController::index', ['namespace' => 'Rating\Controllers']);
// $routes->get('category', 'EvaluationController::categoryView', ['namespace' => 'Rating\Controllers']);  
$routes->group('', ['namespace' => 'Rating\Controllers'], function ($routes) {
    $routes->get('rating', 'EvaluationController::index');
    $routes->get('category', 'EvaluationController::categoryView');
});


// $routes->get('demo', 'Demo::index', ['namespace' => 'Demo\Controllers']);
// $routes->get('demo/(:any)', 'Demo::$1', ['namespace' => 'Demo\Controllers']);

// $routes->get('demo_settings', 'Demo_settings::index', ['namespace' => 'Demo\Controllers']);
// $routes->get('demo_settings/(:any)', 'Demo_settings::$1', ['namespace' => 'Demo\Controllers']);
// $routes->post('demo_settings/(:any)', 'Demo_settings::$1', ['namespace' => 'Demo\Controllers']);

