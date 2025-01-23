<?php

namespace App\Controllers;

use App\Services\EmployeeTreeBuilderService;

class TreeController
{
    private EmployeeTreeBuilderService $employeeTreeBuilderService;

    public function __construct(EmployeeTreeBuilderService $employeeTreeBuilderService)
    {
        $this->employeeTreeBuilderService = $employeeTreeBuilderService;
    }

    public function handleRequest(): void
    {
        $employeesTree = $this->employeeTreeBuilderService->buildTree();
        $tree = $this->renderTree($employeesTree);  // Генерация HTML
        require_once __DIR__ . '/../views/tree/index.php';
    }

    // TODO: Тут нужно изменить реализацию метода renderTree что бы он работал с шаблонизатором
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
