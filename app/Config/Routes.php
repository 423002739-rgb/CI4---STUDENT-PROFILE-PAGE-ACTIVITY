<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Authentication Routes ---
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::index');
$routes->get('logout', 'Auth::logout');
$routes->get('blocked', 'Auth::forbiddenPage');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registration');
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('profile', 'ProfileController::show');
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update');
});

// --- Dashboard Routes ---
$routes->get('dashboard', 'Home::index', ['filter' => 'auth']);
$routes->get('dashboard-v2', 'Home::dashboardV2', ['filter' => 'auth']);
$routes->get('dashboard-v3', 'Home::dashboardV3', ['filter' => 'auth']);

// --- Setting Routes (Admin Only) ---
$routes->group('users', ['filter' => 'auth'], static function ($routes) {
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

$routes->group('menu-management', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Settings::menuManagement');
    $routes->post('create-menu-category', 'Settings::createMenuCategory');
    $routes->post('create-menu', 'Settings::createMenu');
    $routes->post('create-submenu', 'Settings::createSubMenu');
});

$routes->get('menu', 'Menu::index', ['filter' => 'auth']);

// --- PART 3: STUDENT CRUD ROUTES (KUMPLETO) ---
$routes->group('students', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Student::index');               // List
    $routes->get('create', 'Student::create');         // Add Form
    $routes->post('store', 'Student::store');          // Save New
    $routes->get('edit/(:num)', 'Student::edit/$1');   // Edit Form
    $routes->post('update/(:num)', 'Student::update/$1'); // Save Update
    
    // Gawaing 'match' para tanggapin ang GET (link) o POST (form)
    $routes->match(['GET', 'POST', 'DELETE'], 'delete/(:num)', 'Student::delete/$1');
});
