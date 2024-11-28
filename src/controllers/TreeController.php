<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class TreeController
{
    private EmployeeModel $model;

    public function __construct()
    {
        $this->model = new EmployeeModel();
    }

    public function handleRequest(): void
    {
        $employeesTree = $this->model->buildTree();
        $tree = $this->renderTree($employeesTree);  // Генерация HTML
        require_once __DIR__ . '/../views/tree/index.php';
    }

    public function renderTree($tree): string
    {
        // Начало списка
        $html = '<ul>';

        foreach ($tree as $employee) {
            $html .= '<li>';

            // Проверяем, есть ли подчинённые у сотрудника
            $hasSubordinates = !empty($employee['subordinates']);
            $toggleSymbol = $hasSubordinates ? '+' : '';

            // Добавляем имя сотрудника с символом
            $html .= '<strong class="employee-name" style="cursor: pointer;">' . $toggleSymbol . ' ' . htmlspecialchars($employee['first_name']) . ' ' . htmlspecialchars($employee['last_name']) . '</strong><br>';
            $html .= '<em>' . htmlspecialchars($employee['position']) . '</em><br>';
            $html .= '<small>' . htmlspecialchars($employee['email']) . '</small><br>';

            if ($hasSubordinates) {
                $html .= '<ul class="subordinates" style="display: none;">';
                $html .= $this->renderTree($employee['subordinates']);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        // Закрытие списка
        $html .= '</ul>';

        return $html;
    }
}
