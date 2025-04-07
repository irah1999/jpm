<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login', ['as' => 'login']);
$routes->post('/login', 'AuthController::doLogin', ['as' => 'login.attempt']);
$routes->get('/signup', 'AuthController::signup', ['as' => 'signup']);
$routes->post('/signup', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout', ['as' => 'logout']);

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('products', 'ProductController::index', ['as' => 'products.index']);
    $routes->get('products/create', 'ProductController::create', ['as' => 'products.create']);
    $routes->post('products/store', 'ProductController::store', ['as' => 'products.store']);
    $routes->get('products/edit/(:any)', 'ProductController::edit/$1', ['as' => 'products.edit']);
    $routes->post('products/update', 'ProductController::update', ['as' => 'products.update']);
    $routes->post('products/delete', 'ProductController::delete', ['as' => 'products.delete']);
    $routes->get('products/datatables', 'ProductController::datatables', ['as' => 'products.datatables']);
});
