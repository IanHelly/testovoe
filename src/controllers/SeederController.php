<?php

namespace App\Controllers;

use App\Seeders\EmployeeSeeder;

class SeederController
{
    public function runSeeder(): void
    {
        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            http_response_code(403);
            echo json_encode(['error' => 'Seeder can only be run in local environment']);
            return;
        }

        // Запускаем сидер
        $seeder = new EmployeeSeeder();
        $seeder->run(10000);

        echo json_encode(['success' => true, 'message' => 'Seeder executed successfully']);
    }
}
