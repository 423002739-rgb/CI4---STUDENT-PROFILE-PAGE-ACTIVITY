<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::index');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registration');
$routes->get('unauthorized', 'Auth::unauthorized');
$routes->get('blocked', 'Auth::unauthorized');

// Student routes - auth + student role only
$routes->group('', ['filter' => ['auth', 'student']], function($routes) {
    $routes->get('student/dashboard', 'Student::index');
    $routes->get('profile', 'ProfileController::show');
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update');
});

// Teacher routes - auth + teacher or admin role
$routes->group('', ['filter' => ['auth', 'teacher']], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->get('dashboard-v2', 'Home::dashboardV2');
    $routes->get('dashboard-v3', 'Home::dashboardV3');
    $routes->group('students', function($routes) {
        $routes->get('/', 'Student::index');
        $routes->get('create', 'Student::create');
        $routes->post('store', 'Student::store');
        $routes->get('edit/(:num)', 'Student::edit/$1');
        $routes->post('update/(:num)', 'Student::update/$1');
        $routes->match(['GET', 'POST', 'DELETE'], 'delete/(:num)', 'Student::delete/$1');
    });
});

// Admin routes - auth + admin role only
$routes->group('', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->group('users', function($routes) {
        $routes->get('/', 'Settings::users');
        $routes->post('create-role', 'Settings::createRole');
        $routes->post('update-role', 'Settings::updateRole');
        $routes->delete('delete-role/(:num)', 'Settings::deleteRole/$1');
        $routes->get('role-access', 'Settings::roleAccess');
        $routes->post('create-user', 'Settings::createUser');
        $routes->post('update-user', 'Settings::updateUser');
        $routes->delete('delete-user/(:num)', 'Settings::deleteUser/$1');
        $routes->post('change-menu-permission', 'Settings::changeMenuPermission');
        $routes->post('change-menu-category-permission', 'Settings::changeMenuCategoryPermission');
        $routes->post('change-submenu-permission', 'Settings::changeSubMenuPermission');
    });
    $routes->group('menu-management', function($routes) {
        $routes->get('/', 'Settings::menuManagement');
        $routes->post('create-menu-category', 'Settings::createMenuCategory');
        $routes->post('create-menu', 'Settings::createMenu');
        $routes->post('create-submenu', 'Settings::createSubMenu');
    });
    $routes->get('menu', 'Menu::index');
});