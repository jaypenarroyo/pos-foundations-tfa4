<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::home');
$routes->get('about', 'Pages::about');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');

$routes->group('', ['filter' => 'auth'], static function ($routes): void {
    $routes->post('logout', 'Auth::logout');
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::new');
    $routes->post('customers', 'Customers::create');
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)', 'Customers::update/$1');
    $routes->post('customers/(:num)/delete', 'Customers::delete/$1');
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users', 'Users::create');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)', 'Users::update/$1');
    $routes->post('users/(:num)/delete', 'Users::delete/$1');
});
