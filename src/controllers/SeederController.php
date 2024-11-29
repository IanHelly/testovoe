<?php

namespace App\Controllers;

use App\Seeders\EmployeeSeeder;

class SeederController
{
    public function runSeeder(): void
    {
        // Запускаем сидер
        $seeder = new EmployeeSeeder();
        $seeder->run(10000);

        echo json_encode(['success' => true, 'message' => 'Seeder executed successfully']);
    }
}
