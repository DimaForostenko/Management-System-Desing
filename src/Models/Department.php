<?php

namespace Models;

class Department extends BaseModel
{
    protected string $table = 'departments';
    protected array $fillable = ['name'];

    public function validate(array $data, ?int $excludeId = null): array
    {
        $errors = [];

        // Проверяем наличие названия
        if (empty($data['name'])) {
            $errors['name'] = 'Название отдела обязательно для заполнения';
        } else {
            // Проверяем длину названия
            if (strlen($data['name']) < 2) {
                $errors['name'] = 'Название отдела должно содержать минимум 2 символа';
            }
            
            if (strlen($data['name']) > 255) {
                $errors['name'] = 'Название отдела не должно превышать 255 символов';
            }
            
            // Проверяем уникальность названия
            if ($this->exists('name', $data['name'], $excludeId)) {
                $errors['name'] = 'Отдел с таким названием уже существует';
            }
        }

        return $errors;
    }

    public function getUsersCount(int $departmentId): int
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE department_id = ?";
        $result = $this->db->fetch($sql, [$departmentId]);
        return (int) $result['count'];
    }

    public function getWithUsersCount(): array
{
    $sql = "
        SELECT 
            d.*,
            COUNT(u.id) as users_count 
        FROM departments d
        LEFT JOIN users u ON d.id = u.department_id
        GROUP BY d.id
        ORDER BY d.name
    ";
    
    // Добавьте это для отладки:
    error_log("SQL Query: " . $sql);
    $result = $this->db->fetchAll($sql);
    error_log("Result count: " . count($result));
    
    return $result;
}

    public function canDelete(int $id): bool
    {
        return $this->getUsersCount($id) === 0;
    }

    public function getAllForSelect(): array
    {
        $sql = "SELECT id, name FROM {$this->table} ORDER BY name ASC";
        return $this->db->fetchAll($sql);
    }
}