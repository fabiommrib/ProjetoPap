<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Crud::index');
$routes->get('/create', 'Crud::create');
$routes->post('/create', 'Crud::createSave');
$routes->get('/edit/(:num)', 'Crud::edit/$1');
$routes->post('/update/(:num)', 'Crud::update/$1');
$routes->get('/delete/(:num)', 'Crud::delete/$1');
$routes->get('/view', 'Crud::view');


$routes->get('/news', 'News::index');
$routes->get('/news/create', 'News::create');
$routes->post('/news/create', 'News::createSave');
$routes->get('/news/edit/(:num)', 'News::edit/$1');
$routes->post('/news/update/(:num)', 'News::update/$1');
$routes->get('/news/delete/(:num)', 'News::delete/$1');
$routes->get('/news/view/', 'News::view');

$routes->get('/tournament', 'Tournament::index');
$routes->get('/tournament/create', 'Tournament::create');
$routes->post('/tournament/create', 'Tournament::createSave');
$routes->get('/tournament/edit/(:num)', 'Tournament::edit/$1');
$routes->post('/tournament/update/(:num)', 'Tournament::update/$1');
$routes->get('/tournament/delete/(:num)', 'Tournament::delete/$1');
$routes->get('/tournament/view/', 'Tournament::view');

$routes->get('/team', 'Team::index');
$routes->get('/team/create', 'Team::create');
$routes->post('/team/create', 'Team::createSave');
$routes->get('/team/edit/(:num)', 'Team::edit/$1');
$routes->post('/team/update/(:num)', 'Team::update/$1');
$routes->get('/team/delete/(:num)', 'Team::delete/$1');
$routes->get('/team/view/', 'Team::view');

$routes->get('/auth', 'AuthController::index');
$routes->post('/auth/login_process', 'AuthController::login_process');
$routes->get('/auth/logout', 'AuthController::logout');
