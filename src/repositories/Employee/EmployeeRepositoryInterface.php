<?php

namespace App\Repositories\Employee;

interface EmployeeRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?array;
    public function save(array $data): bool;
    public function update(array $data): bool;
    public function delete(int $id): bool;
    public function getSubordinates(int $managerId): array;
    public function getTableName(): string;
}
