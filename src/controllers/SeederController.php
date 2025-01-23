<?php

namespace App\Controllers;

use App\Seeders\EmployeeSeeder;

class SeederController
{
    private EmployeeSeeder $employeeSeeder;

    public function __construct(EmployeeSeeder $employeeSeeder)
    {
        $this->employeeSeeder = $employeeSeeder;
    }

    public function runSeeder(): void
    {
        // Запускаем сидер для заполнения таблицы employees
        $this->employeeSeeder->run(10000);

        echo json_encode(['success' => true, 'message' => 'Seeder executed successfully']);
    }
}
