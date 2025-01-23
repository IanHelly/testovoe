<?php

namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use Exception;

class EmployeeService
{
    private EmployeeRepositoryInterface $repository;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllEmployees(): array
    {
        return $this->repository->getAll();
    }

    public function getEmployeeById(int $id): ?array
    {
        return $this->repository->getById($id);
    }

    public function saveEmployee(array $data): bool
    {
        if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email'])) {
            throw new Exception('Missing required fields: firstName, lastName, email');
        }

        // Заменяем пустой managerId на null, если он не передан
        $data['managerId'] = empty($data['managerId']) ? null : $data['managerId'];

        return $this->repository->save($data);
    }

    public function updateEmployee(array $data): bool
    {
        return $this->repository->update($data);
    }

    public function deleteEmployee(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getSubordinates(int $managerId): array
    {
        return $this->repository->getSubordinates($managerId);
    }
}
