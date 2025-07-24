<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../autoloader.php';

use Routers\Router;
use Controllers\HomeController;
use Controllers\UserController;
use Controllers\DepartmentController;

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

$router->get('/users/create', function() {
    $controller = new UserController();
    $controller->create();
});

$router->post('/users/create', function() {
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
$router->get('/departments/create', function() {
    $controller = new DepartmentController();
    $controller->create();
});
$router->post('/departments/create', function() {
    $controller = new DepartmentController();
    $controller->store();
});

$router->get('/departments/{id}', function($id) {
    $controller = new DepartmentController();
    $controller->show((int)$id);
});

$router->get('/departments/{id}/edit', function($id) {
    $controller = new DepartmentController();
    $controller->edit((int)$id);
});

$router->post('/departments/{id}/edit', function($id) {
    $controller = new DepartmentController();
    $controller->update((int)$id);
});


$router->post('/departments/{id}/delete', function($id) {
    $controller = new DepartmentController();
    $controller->delete((int)$id);
});



// Запускаем роутер
$router->dispatch();