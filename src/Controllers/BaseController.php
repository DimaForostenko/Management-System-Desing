<?php

namespace Controllers;

abstract class BaseController
{
    protected string $layout = 'layouts/main';
    protected function view(string $view, array $data = []): void
    {

        $data['flashMessage'] = $this->getFlashMessage();
        // Извлекаем переменные из массива данных
        extract($data);
        
        // Подключаем шаблон
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            // Начинаем буферизацию для захвата контента страницы
            ob_start();
            require $viewPath;
            echo "<script>console.log(" . json_encode($viewPath) . ");</script>"; 
            // Получаем контент страницы
            $content = ob_get_clean();
            
            // Подключаем макет
            $this->loadLayout($content, $data);
        } else {
            
            throw new \Exception("View {$view} not found");
        }
    }

     /**
     * Загружает макет с контентом
     */
    protected function loadLayout(string $content, array $data = []): void
    {
        // Извлекаем переменные для макета
        extract($data);
        
        // Подключаем макет
        $layoutPath = __DIR__ . '/../../views/' . $this->layout . '.php';
        
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            throw new \Exception("Layout {$this->layout} not found at path: {$layoutPath}");
        }
    }
    
    /**
     * Установка пользовательского макета
     */
    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
    
    /**
     * Рендеринг представления без макета (для AJAX)
     */
    protected function renderView(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \Exception("View {$view} not found at path: {$viewPath}");
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function redirectWithMessage(string $url, string $message, string $type = 'success'): void
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
        $this->redirect($url);
    }

    protected function getFlashMessage(): ?array
    {
        if (isset($_SESSION['flash_message'])) {
            $message = [
                'text' => $_SESSION['flash_message'],
                'type' => $_SESSION['flash_type'] ?? 'success'
            ];
            
            unset($_SESSION['flash_message'], $_SESSION['flash_type']);
            return $message;
        }
        
        return null;
    }

    protected function getPostData(): array
    {
        return $_POST ?? [];
    }

    protected function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    protected function isPost(): bool
    {
        return $this->getRequestMethod() === 'POST';
    }

    protected function sanitizeString(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    protected function sanitizeArray(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $sanitized[$key] = $this->sanitizeString($value);
            } else {
                $sanitized[$key] = $value;
            }
        }
        return $sanitized;
    }

    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validateRequired(array $data, array $required): array
    {
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Поле {$field} обязательно для заполнения";
            }
        }
        
        return $errors;
    }
}