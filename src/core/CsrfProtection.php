<?php

namespace App\Middleware;

class CsrfProtection
{
    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function checkCsrfToken($token): bool
    {
        return isset($token) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function handleRequest(): void
    {
        // Проверяем только для POST, DELETE и PUT запросов
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'PUT') {

            // Получаем CSRF токен из заголовков
            $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''; // Заголовок CSRF токена

            // Проверяем, если токен пустой или некорректный
            if (empty($csrfToken) || !self::checkCsrfToken($csrfToken)) {
                header('HTTP/1.1 403 Forbidden');
                echo json_encode(['error' => 'CSRF token missing or invalid']);
                exit;
            }
        }
    }
}
