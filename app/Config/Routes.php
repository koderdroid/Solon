<?php

namespace Config;

$routes = Services::routes();

$routes->get('/', 'Indicadores::index', ['filter' => 'auth']);
$routes->get('indicadores', 'Indicadores::index', ['filter' => 'auth']);
$routes->get('indicadores/crear', 'Indicadores::crear', ['filter' => 'auth']);
$routes->post('indicadores/crear', 'Indicadores::crear', ['filter' => 'auth']);
$routes->get('indicadores/ver/(:num)', 'Indicadores::ver/$1', ['filter' => 'auth']);

$routes->get('poa-tareas', 'PoaTareas::index', ['filter' => 'auth']);
$routes->get('poa-tareas/crear', 'PoaTareas::crear', ['filter' => 'auth']);
$routes->post('poa-tareas/crear', 'PoaTareas::crear', ['filter' => 'auth']);
$routes->get('poa-tareas/ver/(:num)', 'PoaTareas::ver/$1', ['filter' => 'auth']);
$routes->get('poa-tareas/editar/(:num)', 'PoaTareas::editar/$1', ['filter' => 'auth']);
$routes->post('poa-tareas/editar/(:num)', 'PoaTareas::editar/$1', ['filter' => 'auth']);
$routes->get('poa-tareas/eliminar/(:num)', 'PoaTareas::eliminar/$1', ['filter' => 'auth']);

$routes->post('avance-tarea/crear/(:num)', 'AvanceTarea::crear/$1', ['filter' => 'auth']);
$routes->get('avance-tarea/editar/(:num)', 'AvanceTarea::editar/$1', ['filter' => 'auth']);
$routes->post('avance-tarea/editar/(:num)', 'AvanceTarea::editar/$1', ['filter' => 'auth']);
$routes->get('avance-tarea/eliminar/(:num)', 'AvanceTarea::eliminar/$1', ['filter' => 'auth']);

// Autenticación
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');