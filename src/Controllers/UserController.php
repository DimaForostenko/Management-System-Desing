<?php

namespace Controllers;

use Models\User;
use Models\Department;

class UserController extends BaseController
{
    private User $userModel;
    private Department $departmentModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->departmentModel = new Department();
    }

  public function index(): void
{      
    // Получаем параметры фильтрации из GET
    $search = $_GET['search'] ?? '';
    $department = $_GET['department'] ?? '';
    $status = $_GET['status'] ?? '';
    $sort = $_GET['sort'] ?? 'created_at_desc';
    
    // Получаем список всех отделов для фильтра
    $departments = $this->departmentModel->getAllForSelect();

    // Получаем пользователей с учетом фильтров
    if (!empty($search) || !empty($department) || $status !== '') {
        // Есть фильтры - используем фильтрованный поиск
        $users = $this->userModel->getFiltered($search, $department, $status, $sort);
        error_log("Filtered search - Search: '$search', Department: '$department', Status: '$status', Sort: '$sort'");
    } else {
        // Нет фильтров - показываем всех пользователей
        $users = $this->userModel->getAllWithDepartments();
        error_log("No filters - showing all users");
    }
    
    // Отладка
    error_log("Departments loaded: " . count($departments));
    error_log("Users loaded: " . count($users));

    // УБИРАЕМ ЭТУ СТРОКУ - она перезаписывает отфильтрованные данные!
    // $users = $this->userModel->getAllWithDepartments();
    
    $data = [
        'title' => 'Все пользователи',
        'users' => $users,
        'departments' => $departments,
        'flashMessage' => $this->getFlashMessage()
    ];
    
    $this->view('users/index', $data);
}



    public function create(): void
    {
        $departments = $this->departmentModel->getAllForSelect();
        
        $data = [
            'title' => 'Добавить пользователя',
            'departments' => $departments,
            'flashMessage' => $this->getFlashMessage(),
            'errors' => $this->getValidationErrors(),
            'oldInput' => $this->getOldInput()
        ];
        
        $this->view('users/create', $data);
    }

    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/users/create');
            return;
        }

        $postData = $this->sanitizeArray($this->getPostData());
        
        // Валидация данных
        $errors = $this->userModel->validate($postData);
        
        if (empty($errors)) {
            try {
                $userId = $this->userModel->create($postData);
                $this->redirectWithMessage('/users/index', 'Пользователь успешно создан', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage('/users/create', 'Ошибка при создании пользователя: ' . $e->getMessage(), 'error');
            }
        } else {
            // Сохраняем ошибки в сессию для отображения
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old_input'] = $postData;
            $this->redirect('/users/create');
        }
    }

    public function show(int $id): void
    {
        $user = $this->userModel->getWithDepartment($id);
        
        if (!$user) {
            $this->redirectWithMessage('/users', 'Пользователь не найден', 'error');
            return;
        }
        
        $data = [
            'title' => 'Информация о пользователе',
            'user' => $user,
            'flashMessage' => $this->getFlashMessage()
        ];
        
        $this->view('users/show', $data);
    }

    public function edit(int $id): void
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->redirectWithMessage('/users', 'Пользователь не найден', 'error');
            return;
        }
        
        $departments = $this->departmentModel->getAllForSelect();
        
        $data = [
            'title' => 'Редактировать пользователя',
            'user' => $user,
            'departments' => $departments,
            'flashMessage' => $this->getFlashMessage(),
            'errors' => $this->getValidationErrors(),
            'oldInput' => $this->getOldInput()
        ];
        
        $this->view('users/edit', $data);
    }

    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect("/users/{$id}/edit");
            return;
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->redirectWithMessage('/users', 'Пользователь не найден', 'error');
            return;
        }

        $postData = $this->sanitizeArray($this->getPostData());
        
        // Валидация данных с исключением текущего пользователя при проверке уникальности
        $errors = $this->userModel->validate($postData, $id);
        
        if (empty($errors)) {
            try {
                $this->userModel->update($id, $postData);
                $this->redirectWithMessage('/users', 'Пользователь успешно обновлен', 'success');
            } catch (\Exception $e) {
                $this->redirectWithMessage("/users/{$id}/edit", 'Ошибка при обновлении пользователя: ' . $e->getMessage(), 'error');
            }
        } else {
            // Сохраняем ошибки в сессию для отображения
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old_input'] = $postData;
            $this->redirect("/users/{$id}/edit");
        }
    }

    public function delete(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/users');
            return;
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->redirectWithMessage('/users', 'Пользователь не найден', 'error');
            return;
        }

        try {
            $this->userModel->delete($id);
            $this->redirectWithMessage('/users', 'Пользователь успешно удален', 'success');
        } catch (\Exception $e) {
            $this->redirectWithMessage('/users', 'Ошибка при удалении пользователя: ' . $e->getMessage(), 'error');
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