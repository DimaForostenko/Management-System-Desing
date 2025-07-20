<?php

namespace Models;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = ['email', 'name', 'address', 'phone', 'comments', 'department_id'];

    public function validate(array $data, ?int $excludeId = null): array
    {
        $errors = [];

        // Проверяем email
        if (empty($data['email'])) {
            $errors['email'] = 'Email обязателен для заполнения';
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Некорректный формат email';
            } elseif ($this->exists('email', $data['email'], $excludeId)) {
                $errors['email'] = 'Пользователь с таким email уже существует';
            }
        }

        // Проверяем имя
        if (empty($data['name'])) {
            $errors['name'] = 'Имя обязательно для заполнения';
        } else {
            if (strlen($data['name']) < 2) {
                $errors['name'] = 'Имя должно содержать минимум 2 символа';
            }
            if (strlen($data['name']) > 255) {
                $errors['name'] = 'Имя не должно превышать 255 символов';
            }
        }

        // Проверяем телефон (необязательное поле)
        if (!empty($data['phone'])) {
            if (strlen($data['phone']) > 20) {
                $errors['phone'] = 'Номер телефона не должен превышать 20 символов';
            }
        }

        // Проверяем адрес (необязательное поле)
        if (!empty($data['address'])) {
            if (strlen($data['address']) > 1000) {
                $errors['address'] = 'Адрес не должен превышать 1000 символов';
            }
        }

        // Проверяем комментарии (необязательное поле)
        if (!empty($data['comments'])) {
            if (strlen($data['comments']) > 1000) {
                $errors['comments'] = 'Комментарии не должны превышать 1000 символов';
            }
        }

        // Проверяем department_id
        if (!empty($data['department_id'])) {
            $departmentModel = new Department();
            if (!$departmentModel->find((int) $data['department_id'])) {
                $errors['department_id'] = 'Выбранный отдел не существует';
            }
        }

        return $errors;
    }

    public function getAllWithDepartments(): array
    {
        $sql = "
            SELECT 
                u.*,
                d.name as department_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            ORDER BY u.created_at DESC
        ";
        return $this->db->fetchAll($sql);
    }

    public function getWithDepartment(int $id): ?array
    {
        $sql = "
            SELECT 
                u.*,
                d.name as department_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.id = ?
        ";
        return $this->db->fetch($sql, [$id]);
    }

    public function search(string $query): array
    {
        $searchQuery = '%' . $query . '%';
        $sql = "
            SELECT 
                u.*,
                d.name as department_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.name LIKE ? 
               OR u.email LIKE ? 
               OR u.phone LIKE ?
               OR d.name LIKE ?
            ORDER BY u.created_at DESC
        ";
        return $this->db->fetchAll($sql, [$searchQuery, $searchQuery, $searchQuery, $searchQuery]);
    }

    public function getByDepartment(int $departmentId): array
    {
        $sql = "
            SELECT 
                u.*,
                d.name as department_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.department_id = ?
            ORDER BY u.name
        ";
        return $this->db->fetchAll($sql, [$departmentId]);
    }
}