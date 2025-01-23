<?php

namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;

class EmployeeTreeBuilderService
{
    private EmployeeRepositoryInterface $repository;
 
    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function buildTree($manager_id = 1): array
    {
        // Получаем всех подчинённых для менеджера
        $employees = $this->repository->getSubordinates($manager_id);

        $tree = [];
        foreach ($employees as $employee) {
            // Рекурсивно строим подчинённых
            $employee['subordinates'] = $this->buildTree($employee['id']);
            $tree[] = $employee;
        }

        return $tree;
    }
}
