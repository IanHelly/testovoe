<?php

namespace App\Controllers;

class IndexController extends BaseController
{
    public function Index(): void {
        $csrf = $this->getCsrfToken();
        // TODO Нужно настроить шаблонизатор
        require_once __DIR__ . '/../views/index.php';
    }
}
