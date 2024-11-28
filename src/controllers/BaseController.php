<?php

namespace App\Controllers;

use App\Middleware\CsrfProtection;

class BaseController
{
    public function __construct()
    {
        CsrfProtection::handleRequest();
    }

    public function getCsrfToken(): string
    {
        return CsrfProtection::generateCsrfToken();
    }
}
