<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('registro', 'AuthController::registrar');
$routes->post('registro', 'AuthController::guardarRegistro');
$routes->get('activar/(:segment)', 'AuthController::activarCuenta/$1');
$routes->get('login', 'AuthController::iniciarSesion');
$routes->post('login', 'AuthController::comprobarAcceso');
$routes->get('panel', 'PanelController::inicio', [
    'filter' => 'acceso'
]);
$routes->get('tareas', 'PanelController::tareas', ['filter' => 'acceso']);
$routes->post('salir', 'AuthController::cerrarSesion', ['filter' => 'acceso']);
$routes->post('tareas/guardar', 'TareaController::guardar', ['filter' => 'acceso']);
$routes->get('tareas/editar/(:num)', 'TareaController::editar/$1', ['filter' => 'acceso']);
$routes->post('tareas/actualizar/(:num)', 'TareaController::actualizar/$1', ['filter' => 'acceso']);
$routes->post('tareas/eliminar/(:num)', 'TareaController::eliminar/$1', ['filter' => 'acceso']);
$routes->get('recuperar', 'AuthController::pedirRecuperacion');
$routes->post('recuperar', 'AuthController::enviarRecuperacion');
$routes->get('restablecer/(:segment)', 'AuthController::mostrarNuevaClave/$1');
$routes->post('restablecer', 'AuthController::guardarNuevaClave');
$routes->get('perfil', 'PerfilController::mostrar', ['filter' => 'acceso']);
$routes->post('perfil/guardar', 'PerfilController::guardarCambios', ['filter' => 'acceso']);
$routes->post('perfil/foto', 'PerfilController::guardarFoto', ['filter' => 'acceso']);
$routes->get('admin/usuarios', 'AdminController::usuarios', [
    'filter' => 'acceso'
]);
$routes->post('perfil/eliminar-foto', 'PerfilController::eliminarFoto', ['filter' => 'acceso']);
$routes->post('admin/crear', 'AdminController::crearUsuario', ['filter' => 'acceso']);
$routes->get('admin/crear', 'AdminController::mostrarCrearUsuario', ['filter' => 'acceso']);
$routes->get('admin/usuarios/(:num)', 'AdminController::userDetails/$1', ['filter' => 'acceso']);

$routes->get('admin/usuarios/(:num)/editar', 'AdminController::editUser/$1', ['filter' => 'acceso']);

$routes->post('admin/usuarios/(:num)/actualizar', 'AdminController::updateUser/$1', ['filter' => 'acceso']);

$routes->post('admin/usuarios/(:num)/eliminar', 'AdminController::deleteUser/$1', ['filter' => 'acceso']);
$routes->get('tareas/nueva', 'TareaController::createTask', ['filter' => 'acceso']);

$routes->get('tareas/detalles/(:num)', 'TareaController::taskDetails/$1', ['filter' => 'acceso']);