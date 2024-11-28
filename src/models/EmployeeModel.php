<?php

require_once __DIR__ . '/../core/Database/Database.php';

class EmployeeModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM employees ORDER BY id DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data): bool
    {
        if (!empty($data['id'])) {
            // Обновление
            $stmt = $this->db->prepare(
                "UPDATE employees SET first_name = ?, last_name = ?, position = ?, email = ?, phone = ?, notes = ?, manager_id = ? WHERE id = ?"
            );
            $stmt->execute([
                $data['firstName'], $data['lastName'], $data['position'], $data['email'],
                $data['phone'], $data['notes'], $data['managerId'], $data['id']
            ]);
            return true;
        } else {
            // Добавление
            $stmt = $this->db->prepare(
                "INSERT INTO employees (first_name, last_name, position, email, phone, notes, manager_id) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $data['firstName'], $data['lastName'], $data['position'], $data['email'],
                $data['phone'], $data['notes'], $data['managerId']
            ]);
            return true;
        }
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function buildTree($manager_id = 1): array
    {
        // Используйте оператор =, а не IS
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE manager_id = ?");
        $stmt->execute([$manager_id]);
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tree = [];
        foreach ($employees as $employee) {
            // Рекурсивно строим подчинённых
            $employee['subordinates'] = $this->buildTree($employee['id']);
            $tree[] = $employee;
        }

        return $tree;
    }

    public function getSubordinates($managerId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE manager_id = ?");
        $stmt->execute([$managerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
