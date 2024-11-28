<?php

require_once __DIR__ . '/../seeders/EmployeeSeeder.php';

class SeederController
{
    public function runSeeder(): void
    {
        // Проверяем окружение (например, запускаем только на локальной машине)
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
