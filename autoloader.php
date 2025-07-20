<?php

spl_autoload_register(function ($class) {
    // Преобразуем namespace в путь к файлу
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    
    // Проверяем существование файла и подключаем его
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    
    echo  'success' ;
});

// Запуск сессии если она еще не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Установка временной зоны (измените на вашу)
date_default_timezone_set('Europe/Dublin');

// Обработка ошибок для development окружения
if (getenv('APP_ENV') === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
