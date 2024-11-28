<?php

namespace App\Controllers;

use App\Core\Traits\InputValidator;
use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    use InputValidator;

    private EmployeeModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new EmployeeModel();
    }

    public function handleRequest($method, $data, $queryParams): void
    {
        try {
            switch ($method) {
                case 'GET':
                    $this->handleGet($queryParams);
                    break;

                case 'POST':
                    // Санитизация всех переданных данных. Так же можно использовать DTO но не успел сделать
                    $data = $this->sanitizeInputData($data);
                    $this->handlePost($data);
                    break;

                case 'DELETE':
                    $this->handleDelete($queryParams);
                    break;

                default:
                    $this->respondWithError('Method not allowed', 405);
                    break;
            }
        } catch (\Exception $e) {
            $this->respondWithError($e->getMessage(), 500);
        }
    }

    private function handleGet(array $queryParams): void
    {
        if (!empty($queryParams['id']) && $queryParams['action'] === 'edit') {
            $employee = $this->model->getById($queryParams['id']);
            if ($employee) {
                $this->respondWithSuccess($employee);
            } else {
                $this->respondWithError('Employee not found', 404);
            }
        } else if (!empty($queryParams['id']) && $queryParams['action'] === 'subordinates') {
            $subordinates = $this->model->getSubordinates($queryParams['id']);
            $this->respondWithSuccess($subordinates);
        } else {
            $employees = $this->model->getAll();
            require_once __DIR__ . '/../views/employees/list.php';
        }
    }

    private function handlePost(array $data): void
    {
        // Проверяем, что обязательные поля присутствуют
        if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email'])) {
            $this->respondWithError('Missing required fields: firstName, lastName, email', 400);
            return;
        }

        // Заменяем пустой managerId на null, если он не передан
        $data['managerId'] = empty($data['managerId']) ? null : $data['managerId'];

        // Сохраняем данные
        $result = $this->model->save($data);
        if ($result) {
            $this->respondWithSuccess(['message' => 'Employee saved successfully']);
        } else {
            $this->respondWithError('Failed to save employee', 500);
        }
    }

    private function handleDelete(array $queryParams): void
    {
        if (empty($queryParams['id'])) {
            $this->respondWithError('ID is required', 400);
            return;
        }

        $deleted = $this->model->delete($queryParams['id']);
        if ($deleted) {
            $this->respondWithSuccess(['message' => 'Employee deleted successfully']);
        } else {
            $this->respondWithError('Failed to delete employee', 500);
        }
    }

    private function respondWithSuccess($data): void
    {
        http_response_code(200);
        echo json_encode($data);
    }

    private function respondWithError($message, $statusCode): void
    {
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
    }
}
