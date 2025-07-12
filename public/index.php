<?php

session_start();

require_once __DIR__ . '/../src/autoload.php';

use src\Router\Router;
use src\Controllers\HomeController;
use src\Controllers\UserController;
use src\Controllers\DepartmentController;

// Создаем роутер
$router = new Router();

// Определяем маршруты
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

// Маршруты для пользователей
$router->get('/users', function() {
    $controller = new UserController();
    $controller->index();
});

$router->get('/users/add', function() {
    $controller = new UserController();
    $controller->create();
});

$router->post('/users/add', function() {
    $controller = new UserController();
    $controller->store();
});

$router->get('/users/{id}', function($id) {
    $controller = new UserController();
    $controller->show($id);
});

$router->get('/users/{id}/edit', function($id) {
    $controller = new UserController();
    $controller->edit($id);
});

$router->post('/users/{id}/edit', function($id) {
    $controller = new UserController();
    $controller->update($id);
});

$router->post('/users/{id}/delete', function($id) {
    $controller = new UserController();
    $controller->delete($id);
});

// Маршруты для отделов
$router->get('/departments', function() {
    $controller = new DepartmentController();
    $controller->index();
});

$router->post('/departments/add', function() {
    $controller = new DepartmentController();
    $controller->store();
});

$router->post('/departments/{id}/delete', function($id) {
    $controller = new DepartmentController();
    $controller->delete($id);
});

// Запускаем роутер
$router->dispatch();