<?php

namespace Controllers;

use Models\User;
use Models\Department;

class HomeController extends BaseController
{
    public function index(): void
    {
        $userModel = new User();
        $departmentModel = new Department();
        
        // Получаем статистику
        $totalUsers = count($userModel->all());
        $totalDepartments = count($departmentModel->all());
        $recentUsers = array_slice($userModel->getAllWithDepartments(), 0, 5);
        $recentDepartments = array_slice($departmentModel->getWithUsersCount(), 0, 5);
        $departmentsWithCounts = $departmentModel->getWithUsersCount();
        
        // Подготавливаем данные для передачи в представление
        $data = [
            'title' => 'Головна сторінка',
            'totalUsers' => $totalUsers,
            'totalDepartments' => $totalDepartments,
            'recentUsers' => $recentUsers,
            'recentDepartments'=>$recentDepartments ,
            'departmentsWithCounts' => $departmentsWithCounts,
            'flashMessage' => $this->getFlashMessage()
        ];
        
        $this->view('home/index', $data);
    }
}