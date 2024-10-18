<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('user-management', 
    [
        'namespace' => 'App\Controllers\UserManagement', 
        'filter' => 'auth'
    ], function ($routes) {
        $routes->group('users', 
            [
                'namespace' => 'App\Controllers\UserManagement'
            ], function ($routes) {
                $routes->get('/', 'UserController::index');
                $routes->post('fetchData', 'UserController::fetchData');
                $routes->get('create', 'UserController::create');
                $routes->get('edit/(:segment)', 'UserController::edit/$1');
                $routes->get('destroy/(:segment)', 'UserController::destroy/$1');

                $routes->post('store', 'UserController::store');
                $routes->post('update/(:segment)', 'UserController::update/$1');
            }
        );

        $routes->group('permissions', [
            'filter'    => 'permission',
            'namespace' => 'App\Controllers\UserManagement',
        ], function ($routes) {
            $routes->get('/', 'PermissionController::index');
            $routes->post('fetchData', 'PermissionController::fetchData');
            $routes->get('create', 'PermissionController::create');
            $routes->get('edit/(:segment)', 'PermissionController::edit/$1');
            $routes->get('destroy/(:segment)', 'PermissionController::destroy/$1');
            
            $routes->post('store', 'PermissionController::store');
            $routes->post('update/(:segment)', 'PermissionController::update/$1');
        });

        $routes->group('roles', [
            'filter'    => 'permission',
            'namespace' => 'App\Controllers\UserManagement',
        ], function ($routes) {
            $routes->get('/', 'RoleController::index');
            $routes->post('fetchData', 'RoleController::fetchData');
            $routes->get('create', 'RoleController::create');
            $routes->get('edit/(:segment)', 'RoleController::edit/$1');
            $routes->get('destroy/(:segment)', 'RoleController::destroy/$1');
            
            $routes->post('store', 'RoleController::store');
            $routes->post('update/(:segment)', 'RoleController::update/$1');
        });
    }
);

$routes->get('access-denied', function() {
    return view('layouts/403');
});