<?php

namespace App\Router;

class Router
{
    private array $routes = [];
    private string $basePath = '';

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, callable $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, callable $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler): void
    {
        $path = $this->basePath . $path;
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'pattern' => $this->convertToRegex($path)
        ];
    }

    private function convertToRegex(string $path): string
    {
        // Конвертируем пути вида /users/{id} в регулярные выражения
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestPath = rtrim($requestPath, '/');
        
        if ($requestPath === '') {
            $requestPath = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $requestPath, $matches)) {
                // Убираем полное совпадение из массива параметров
                array_shift($matches);
                
                // Вызываем обработчик с параметрами
                call_user_func($route['handler'], ...$matches);
                return;
            }
        }

        // Если маршрут не найден
        $this->handleNotFound();
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }

    public function redirect(string $path, int $statusCode = 302): void
    {
        header("Location: $path", true, $statusCode);
        exit;
    }
}