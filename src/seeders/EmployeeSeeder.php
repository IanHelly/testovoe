<?php

require_once __DIR__ . '/../core/Database/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Faker\Factory;

class EmployeeSeeder
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function run(int $count = 10000): void
    {
        $this->clearTable();
        $this->seed($count);
        echo "Database successfully seeded with $count employees." . PHP_EOL;
    }

    private function clearTable(): void
    {
        $this->db->exec("DELETE FROM employees");
        $this->db->exec("ALTER TABLE employees AUTO_INCREMENT = 1");
        echo "Table cleared and auto-increment reset." . PHP_EOL;
    }

    private function seed(int $count): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO employees (first_name, last_name, position, email, phone, notes, manager_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $positions = ['Manager', 'Developer', 'Designer', 'QA', 'HR', 'Support'];

        $faker = Factory::create();

        for ($i = 1; $i <= $count; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $position = $positions[array_rand($positions)];
            $email = $faker->unique()->email();
            $phone = $faker->unique()->phoneNumber();
            $notes = $faker->sentence();
            $managerId = $i > 1 ? rand(1, $i - 1) : null; // У менеджера может быть начальник, но не у первого.

            $stmt->execute([$firstName, $lastName, $position, $email, $phone, $notes, $managerId]);

            if ($i % 1000 === 0) {
                echo "Inserted $i/$count employees..." . PHP_EOL;
            }
        }
    }
}
