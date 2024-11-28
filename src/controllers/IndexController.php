<?php

require_once __DIR__ . '/../models/EmployeeModel.php';

class IndexController
{
    public function Index(): void {
        require_once __DIR__ . '/../views/index.php';
    }
}
