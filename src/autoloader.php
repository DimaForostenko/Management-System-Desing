<?php

spl_autoload_register(function ($class) {
    // Преобразуем namespace в путь к файлу
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    // Проверяем, использует ли класс наш namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Получаем относительное имя класса
    $relative_class = substr($class, $len);

    // Заменяем обратные слеши на прямые, добавляем .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Если файл существует, подключаем его
    if (file_exists($file)) {
        require $file;
    }
});