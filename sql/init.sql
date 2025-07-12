-- Создание базы данных
CREATE DATABASE IF NOT EXISTS employee_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE employee_db;

-- Таблица отделов
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    comments TEXT,
    department_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

-- Вставка тестовых данных
INSERT INTO departments (name) VALUES 
('ІТ відділ'),
('Відділ кадрів'),
('Бухгалтерія'),
('Маркетинг'),
('Продажі');

INSERT INTO users (email, name, address, phone, comments, department_id) VALUES
('john.doe@example.com', 'Іван Іванов', 'вул. Пушкіна, буд. 10, кв. 5', '+3 (999) 123-45-67', 'Провідний розробник', 1),
('jane.smith@example.com', 'Марія Петрова', 'вул. Лермонтова, буд. 15, кв. 8', '+3 (999) 234-56-78', 'HR-менеджер', 2),
('bob.johnson@example.com', 'Олексій Сидоров', 'вул. Гоголя, буд. 20, кв. 12', '+3 (999) 345-67-89', 'Головний бухгалтер', 3);
