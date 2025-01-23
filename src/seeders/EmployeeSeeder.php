<?php

namespace App\Seeders;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use Faker\Factory;

class EmployeeSeeder
{
    private EmployeeRepositoryInterface $repository;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $count = 10000): void
    {
        $this->clearTable();
        $this->seed($count);
        echo "Database successfully seeded with $count employees." . PHP_EOL;
    }

    private function clearTable(): void
    {
        $this->repository->db-exec("DELETE FROM {$this->repository->getTableName()}");
        $this->repository->db-exec("ALTER TABLE {$this->repository->getTableName()} AUTO_INCREMENT = 1");
        echo "Table cleared and auto-increment reset." . PHP_EOL;
    }

    private function seed(int $count): void
    {
        $stmt = $this->repository->db->execprepare(
            "INSERT INTO {$this->repository->getTableName()} (first_name, last_name, position, email, phone, notes, manager_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        // TODO: нужно перенести это в ENUM или константы
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
