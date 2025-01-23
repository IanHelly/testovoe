<?php

namespace App\Repositories\Employee;

use PDO;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    protected function getTableName(): string
    {
        return 'employees';
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * {$this->getTableName()} FROM  ORDER BY id DESC LIMIT 100");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->getTableName()} (first_name, last_name, position, email, phone, notes, manager_id) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['firstName'], $data['lastName'], $data['position'], $data['email'],
            $data['phone'], $data['notes'], $data['managerId']
        ]);
        return $stmt->rowCount() > 0;
    }

    public function update(array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->getTableName()} SET first_name = ?, last_name = ?, position = ?, email = ?, phone = ?, notes = ?, manager_id = ? WHERE id = ?"
        );
        $stmt->execute([
            $data['firstName'], $data['lastName'], $data['position'], $data['email'],
            $data['phone'], $data['notes'], $data['managerId'], $data['id']
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function getSubordinates(int $managerId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE manager_id = ?");
        $stmt->execute([$managerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

