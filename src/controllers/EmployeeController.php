<?php

namespace App\Controllers;

use App\Services\EmployeeService;

class EmployeeController extends BaseController
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        parent::__construct();
        $this->employeeService = $employeeService;
    }

    public function handleGet(array $queryParams): void
    {
        if (!empty($queryParams['id'])) {
            if ($queryParams['action'] === 'edit') {
                $employee = $this->employeeService->getEmployeeById($queryParams['id']);
                if ($employee) {
                    $this->respondWithSuccess($employee);
                } else {
                    $this->respondWithError('Employee not found', 404);
                }
            } elseif ($queryParams['action'] === 'subordinates') {
                $subordinates = $this->employeeService->getSubordinates($queryParams['id']);
                $this->respondWithSuccess($subordinates);
            }
        } else {
            // TODO Нужно настроить шаблонизатор
            $employees = $this->employeeService->getAllEmployees();
            require_once __DIR__ . '/../views/employees/list.php';
        }
    }

    public function handlePost(array $data): void
    {
        try {
            $data = $this->sanitizeInputData($data);
            $this->employeeService->saveEmployee($data);
            $this->respondWithSuccess(['message' => 'Employee saved successfully']);
        } catch (\Exception $e) {
            $this->respondWithError($e->getMessage(), 400);
        }
    }

    public function handleDelete(array $queryParams): void
    {
        if (empty($queryParams['id'])) {
            $this->respondWithError('ID is required', 400);
            return;
        }

        $deleted = $this->employeeService->deleteEmployee($queryParams['id']);
        if ($deleted) {
            $this->respondWithSuccess(['message' => 'Employee deleted successfully']);
        } else {
            $this->respondWithError('Failed to delete employee', 500);
        }
    }
}
