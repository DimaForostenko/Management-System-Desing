<?php

namespace Models;

use \PDOException;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = ['email', 'name', 'address', 'phone', 'position', 'department_id'];

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
        if (!empty($data['position'])) {
            if (strlen($data['position']) > 100) {
                $errors['position'] = 'Должность не должны превышать 100 символов';
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

public function getFiltered(string $search = '', string $department = '', string $status = '', string $sort = 'created_at_desc'): array
{
    $sql = "
        SELECT 
            u.*,
            d.name as department_name
        FROM users u
        LEFT JOIN departments d ON u.department_id = d.id
        WHERE 1=1
    ";
    
    $params = [];
    
    // Добавляем условие поиска
    if (!empty($search)) {
        $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ? OR u.position LIKE ?)";
        $searchQuery = '%' . $search . '%';
        $params = array_merge($params, [$searchQuery, $searchQuery, $searchQuery, $searchQuery]);
    }
    
    // Добавляем фильтр по отделу
    if (!empty($department)) {
        $sql .= " AND u.department_id = ?";
        $params[] = $department;
    }
    
    // Добавляем фильтр по статусу
    if ($status !== '') {
        $sql .= " AND u.is_active = ?";
        $params[] = (int)$status;
    }
    
    // Добавляем сортировку
    $sql .= $this->buildOrderBy($sort);
    
    // Отладка
    error_log("SQL: " . $sql);
    error_log("Params: " . print_r($params, true));
    
    try {
        return $this->db->fetchAll($sql, $params);
    } catch (PDOException $e) {
        error_log("Error in getFiltered: " . $e->getMessage());
        return [];
    }
}
  public function getByDepartment(int $departmentId): array
{
    
        $sql = "
            SELECT 
                u.*,
                d.name as department_name
            FROM users u
            INNER JOIN departments d ON u.department_id = d.id
            WHERE u.department_id = ?
            ORDER BY u.name ASC
        ";
        return $this->db->fetchAll($sql, [$departmentId]);
    
}
private function buildOrderBy(string $sort): string
{
    $allowedSorts = [
        'id_asc' => ' ORDER BY u.id ASC',
        'id_desc' => ' ORDER BY u.id DESC',
        'name_asc' => ' ORDER BY u.name ASC',
        'name_desc' => ' ORDER BY u.name DESC',
        'email_asc' => ' ORDER BY u.email ASC',
        'email_desc' => ' ORDER BY u.email DESC',
        'department_asc' => ' ORDER BY d.name ASC, u.name ASC',
        'department_desc' => ' ORDER BY d.name DESC, u.name ASC',
        'created_at_asc' => ' ORDER BY u.created_at ASC',
        'created_at_desc' => ' ORDER BY u.created_at DESC',
        'updated_at_asc' => ' ORDER BY u.updated_at ASC',
        'updated_at_desc' => ' ORDER BY u.updated_at DESC'
    ];
    
    return $allowedSorts[$sort] ?? $allowedSorts['created_at_desc'];
}
}