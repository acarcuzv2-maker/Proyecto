<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('registro', 'AuthController::registrar');
$routes->post('registro', 'AuthController::guardarRegistro');
$routes->get('activar/(:segment)', 'AuthController::activarCuenta/$1');
$routes->get('login', 'AuthController::iniciarSesion');
$routes->post('login', 'AuthController::comprobarAcceso');
$routes->get('panel', 'PanelController::inicio');
