<?php

namespace App\Controllers;

use App\Middleware\CsrfProtection;
use App\Core\traits\InputValidator;
use App\Core\Logger;

class BaseController
{
    use InputValidator;

    public function __construct()
    {
        CsrfProtection::handleRequest();
    }

    public function getCsrfToken(): string
    {
        return CsrfProtection::generateCsrfToken();
    }

    protected function respondWithSuccess($data): void
    {
        http_response_code(200);
        echo json_encode($data);
    }

    protected function respondWithError($message, $statusCode): void
    {
        Logger::log("Error in handle: " . $message);
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
    }
}
