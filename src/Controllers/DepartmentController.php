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
            $this->redirectWithMessage('/dashboard', 'Помилка під час завантаження відділів', 'error');
        }
    }



    public function create(): void
    {
        $data = [
            'title' => 'Додати департаменти',
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
                $this->redirectWithMessage('/departments', 'Департамент успішно створено', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage('/departments/create', 'Помилка під час створення департаменту: ' . $e->getMessage(), 'error');
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
            $this->redirectWithMessage('/departments', 'Департамент не знайдено', 'error');
            return;
        }
        
        // Получаем пользователей отдела
        $users = $this->userModel->getByDepartment($id);
        
        // Отладка
        error_log("Department ID: $id, Users found: " . count($users));
        
        $data = [
            'title' => 'Інформація про департамент',
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
            $this->redirectWithMessage('/departments', 'Департамент не знайдено', 'error');
            return;
        }
        
        $data = [
            'title' => 'Редагувати департамент',
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
            $this->redirectWithMessage('/departments', 'Департамент не знайдено', 'error');
            return;
        }

        $postData = $this->sanitizeArray($this->getPostData());
        $errors = $this->departmentModel->validate($postData, $id);
        
        if (empty($errors)) {
            try {
                $this->departmentModel->update($id, $postData);
                $this->redirectWithMessage('/departments', 'Департамент оновлено', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage("/departments/{$id}/edit", 'Помилка при оновлені департаменту ' . $e->getMessage(), 'error');
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
            $this->redirectWithMessage('/departments', 'Департамент не знайдено', 'error');
            return;
        }

        // Проверяем, можно ли удалить отдел (нет связанных пользователей)
        if (!$this->departmentModel->canDelete($id)) {
            $this->redirectWithMessage('/departments', 'Не можна видалити департамент зі співробітниками', 'error');
            return;
        }

        try {
            $this->departmentModel->delete($id);
            $this->redirectWithMessage('/departments', 'Департамент видалено', 'success');
        } catch (\Exception $e) {
            $this->redirectWithMessage('/departments', 'Помилка при видалені департаменту ' . $e->getMessage(), 'error');
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