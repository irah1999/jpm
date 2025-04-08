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

$routes->group('categories', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'CategoryController::index', ['as' => 'categories.index']);
    $routes->get('create', 'CategoryController::create', ['as' => 'categories.create']);
    $routes->post('store', 'CategoryController::store', ['as' => 'categories.store']);
    $routes->get('edit/(:any)', 'CategoryController::edit/$1', ['as' => 'categories.edit']);
    $routes->post('update/(:num)', 'CategoryController::update/$1', ['as' => 'categories.update']);
    $routes->post('delete', 'CategoryController::delete', ['as' => 'categories.delete']);
    $routes->get('datatables', 'CategoryController::datatables', ['as' => 'categories.datatables']);
});
