<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\IDService;
/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'IDService::index', ['filter' => 'session']);
$routes->get('requests', 'IDService::index', ['filter' => 'session']);
$routes->get('requests/create', 'IDService::create', ['filter' => 'session']);
$routes->get('user/create', 'IDService::create', ['filter' => 'session']);

$routes->get('admin/login', 'AdminLogin::loginView', ['as' => 'login']);
$routes->post('admin/login', 'AdminLogin::loginAction');
$routes->get('user/login', 'GoogleAuth::login');
$routes->get('google-auth', 'GoogleAuth::auth');
$routes->get('google-callback', 'GoogleAuth::callback');

service('auth')->routes($routes);
$routes->post('user/store', 'IDService::store', ['filter' => 'session']);
$routes->post('requests/process', 'IDService::addToProcessing', ['filter' => 'session']);
$routes->get('requests/process', 'IDService::showProcess', ['filter' => 'session']);
$routes->post('user/generate-pdf', 'IDService::generatePdf', ['filter' => 'session']);