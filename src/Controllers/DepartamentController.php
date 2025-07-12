<?php

namespace src\Controllers;

use src\Models\Department;

class DepartmentController extends BaseController
{
    private Department $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new Department();
    }

    public function index(): void
    {
        $departments = $this->departmentModel->getWithUsersCount();
        
        $data = [
            'title' => 'Управление отделами',
            'departments' => $departments,
            'flashMessage' => $this->getFlashMessage()
        ];
        
        $this->view('departments/index', $data);
    }

    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/departments');
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
                $this->redirectWithMessage('/departments', 'Ошибка при создании отдела: ' . $e->getMessage(), 'error');
            }
        } else {
            // Сохраняем ошибки в сессию для отображения
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old_input'] = $postData;
            $this->redirectWithMessage('/departments', 'Исправьте ошибки в форме', 'error');
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

    public function getValidationErrors(): array
    {
        $errors = $_SESSION['validation_errors'] ?? [];
        unset($_SESSION['validation_errors']);
        return $errors;
    }

    public function getOldInput(): array
    {
        $oldInput = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);
        return $oldInput;
    }
}