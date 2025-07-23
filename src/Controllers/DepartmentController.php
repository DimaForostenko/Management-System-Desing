<?php

namespace Controllers;

use Models\User;
use Models\Department;

class DepartmentController extends BaseController
{
    private Department $departmentModel;
    private User $userModel; 

    public function __construct()
    {
        $this->userModel = new User();
        $this->departmentModel = new Department();
    }

    public function index(): void
    {
        try {
            $departments = $this->departmentModel->getWithUsersCount();
            
            // Отладка
            error_log("Departments loaded: " . count($departments));
            foreach ($departments as $dept) {
                error_log("Department: {$dept['name']}, Users count: {$dept['users_count']}");
            }
            
            $data = [
                'title' => 'Управление отделами',
                'departments' => $departments,
                'flashMessage' => $this->getFlashMessage()
            ];
            
            $this->view('departments/index', $data);
        } catch (\Exception $e) {
            error_log("Error loading departments: " . $e->getMessage());
            $this->redirectWithMessage('/dashboard', 'Ошибка при загрузке отделов', 'error');
        }
    }



    public function create(): void
    {
        $data = [
            'title' => 'Добавить отдел',
            'flashMessage' => $this->getFlashMessage(),
            'errors' => $this->getValidationErrors(),
            'oldInput' => $this->getOldInput()
        ];
        
        $this->view('/departments/create', $data);
    }

    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/departments/create');
            return;
        }

        $postData = $this->sanitizeArray($this->getPostData());
        
        // Валидация данных
        $errors = $this->departmentModel->validate($postData);
        
        if (empty($errors)) {
            try {
                $this->departmentModel->create($postData);
                $this->redirectWithMessage('/departments', 'Отдел успешно создан', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage('/departments/create', 'Ошибка при создании отдела: ' . $e->getMessage(), 'error');
            }
        } else {
            // Сохраняем ошибки в сессию для отображения
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old_input'] = $postData;
            $this->redirect('/departments/create');
        }
    }

    public function show(int $id): void
    {
        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            $this->redirectWithMessage('/departments', 'Отдел не найден', 'error');
            return;
        }
        
        // Получаем пользователей отдела
        $users = $this->userModel->getByDepartment($id);
        
        // Отладка
        error_log("Department ID: $id, Users found: " . count($users));
        
        $data = [
            'title' => 'Информация об отделе',
            'department' => $department,
            'users' => $users,
            'usersCount' => count($users),
            'flashMessage' => $this->getFlashMessage()
        ];
        
        $this->view('/departments/show', $data);
    }

    public function edit(int $id): void
    {
        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            $this->redirectWithMessage('/departments', 'Отдел не найден', 'error');
            return;
        }
        
        $data = [
            'title' => 'Редактировать отдел',
            'department' => $department,
            'flashMessage' => $this->getFlashMessage(),
            'errors' => $this->getValidationErrors(),
            'oldInput' => $this->getOldInput()
        ];
        
        $this->view('departments/edit', $data);
    }

    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect("/departments/{$id}/edit");
            return;
        }

        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            $this->redirectWithMessage('/departments', 'Отдел не найден', 'error');
            return;
        }

        $postData = $this->sanitizeArray($this->getPostData());
        $errors = $this->departmentModel->validate($postData, $id);
        
        if (empty($errors)) {
            try {
                $this->departmentModel->update($id, $postData);
                $this->redirectWithMessage('/departments', 'Отдел успешно обновлен', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage("/departments/{$id}/edit", 'Ошибка при обновлении отдела: ' . $e->getMessage(), 'error');
            }
        } else {
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old_input'] = $postData;
            $this->redirect("/departments/{$id}/edit");
        }
    }

    public function delete(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/departments');
            return;
        }

        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            $this->redirectWithMessage('/departments', 'Отдел не найден', 'error');
            return;
        }

        // Проверяем, можно ли удалить отдел (нет связанных пользователей)
        if (!$this->departmentModel->canDelete($id)) {
            $this->redirectWithMessage('/departments', 'Нельзя удалить отдел, в котором есть сотрудники', 'error');
            return;
        }

        try {
            $this->departmentModel->delete($id);
            $this->redirectWithMessage('/departments', 'Отдел успешно удален', 'success');
        } catch (\Exception $e) {
            $this->redirectWithMessage('/departments', 'Ошибка при удалении отдела: ' . $e->getMessage(), 'error');
        }
    }

    private function getValidationErrors(): array
    {
        $errors = $_SESSION['validation_errors'] ?? [];
        unset($_SESSION['validation_errors']);
        return $errors;
    }

    private function getOldInput(): array
    {
        $oldInput = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);
        return $oldInput;
    }
}