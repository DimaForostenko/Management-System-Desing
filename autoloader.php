<?php
session_start();
// Подключаем автозагрузчик
spl_autoload_register(function ($class) {
    // Преобразуем namespace в путь к файлу
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    
       // Отладочная информация
    error_log("Attempting to load class: $class");
    error_log("Looking for file: $file");
    // Проверяем существование файла и подключаем его
    if (file_exists($file)) {
        require_once $file;
        error_log("Successfully loaded: $file");
        return true;
    }else {
    echo "Файл не найден: $file";}
    return false;
});
// Установка временной зоны (измените на вашу)
date_default_timezone_set('Europe/Kiev');