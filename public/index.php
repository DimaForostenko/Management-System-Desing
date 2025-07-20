<?php
spl_autoload_register(function ($class) {
    // Преобразуем namespace в путь к файлу
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    
    // Проверяем существование файла и подключаем его
    if (file_exists($file)) {
        require_once $file;
        return true;
    }else {
    echo "Файл не найден: $file";}
    
    echo "<script>console.log(" . json_encode($file) . ");</script>"; ;
    echo "<script>console.log(" . json_encode($class) . ");</script>";;
});
// Подключаем автозагрузчик
#require_once __DIR__ . './../autoloader.php';

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

$router->post('/departments/create', function() {
    $controller = new DepartmentController();
    $controller->store();
});

$router->post('/departments/{id}/delete', function($id) {
    $controller = new DepartmentController();
    $controller->delete($id);
});

// Запускаем роутер
$router->dispatch();