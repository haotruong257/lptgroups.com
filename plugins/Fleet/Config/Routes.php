<?php

namespace Config;

$routes = Services::routes();

$routes->get('fleet', 'Fleet::index', ['namespace' => 'Fleet\Controllers']);
$routes->get('fleet/(:any)', 'Fleet::$1', ['namespace' => 'Fleet\Controllers']);

$routes->post('fleet/(:any)', 'Fleet::$1', ['namespace' => 'Fleet\Controllers']);

$routes->get('fleet_client', 'Fleet_client::index', ['namespace' => 'Fleet\Controllers']);
$routes->get('fleet_client/(:any)', 'Fleet_client::$1', ['namespace' => 'Fleet\Controllers']);
$routes->post('fleet_client/(:any)', 'Fleet_client::$1', ['namespace' => 'Fleet\Controllers']);
