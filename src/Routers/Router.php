<?php

namespace Routers;

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
    $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);
    return '#^' . rtrim($pattern, '/') . '/?$#'; // Allow optional trailing slash
}

    public function dispatch(): void
    {
        
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestPath = rtrim($requestPath, '/');
        error_log("Request: $requestMethod $requestPath");

        if ($requestPath === '') {
            $requestPath = '/';
        }

        // Сортируем маршруты: более специфичные сначала
         usort($this->routes, function($a, $b) {
            $aSegments = substr_count($a['path'], '/');
            $bSegments = substr_count($b['path'], '/');
            
            if ($aSegments !== $bSegments) {
                return $bSegments - $aSegments; // Больше сегментов первым
            }
                 // Безопасное получение количества параметров
            $aParamCount = $a['param_count'] ?? substr_count($a['path'], '{');
            $bParamCount = $b['param_count'] ?? substr_count($b['path'], '{');
            
            if ($aParamCount !== $bParamCount) {
                return $aParamCount - $bParamCount; // Меньше параметров первым
            }
            return strlen($b['path']) - strlen($a['path']); // Длиннее первым
        });

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $requestPath, $matches)) {
                // Убираем полное совпадение из массива параметров
                array_shift($matches);
                
                $handler = $route['handler'];
                
                // Поддержка разных типов обработчиков
                if (is_callable($handler)) {
                    // Если это обычная функция или замыкание
                    call_user_func($handler, ...$matches);
                } elseif (is_array($handler) && count($handler) === 2) {
                    // Если это массив [controller, method]
                    [$controller, $method] = $handler;
                    if (is_object($controller) && method_exists($controller, $method)) {
                        $controller->$method(...$matches);
                    } else {
                        throw new \Exception("Method $method not found in controller");
                    }
                } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                    // Если это строка вида "ControllerClass@method"
                    [$controllerClass, $method] = explode('@', $handler);
                    $controller = new $controllerClass();
                    if (method_exists($controller, $method)) {
                        $controller->$method(...$matches);
                    } else {
                        error_log("Checking route: {$route['method']} {$route['path']}");

                        throw new \Exception("Method $method not found in $controllerClass");
                    }
                } else {
                    error_log("Checking route: {$route['method']} {$route['path']}");

                    throw new \Exception("Invalid route handler");
                }
                
                return;
            }
        }

        // Если маршрут не найден
        error_log("No route found for: $requestMethod $requestPath");
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