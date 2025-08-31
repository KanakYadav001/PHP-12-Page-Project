<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\actions\auth_register.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        set_flash('danger', 'CSRF token validation failed.');
        redirect('index.php?page=register');
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);

    if (empty($name) || empty($email) || empty($password)) {
        set_flash('danger', 'All fields are required.');
        redirect('index.php?page=register');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);

        set_flash('success', 'You have been registered successfully. Please login.');
        redirect('index.php?page=login');
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        if ($e->errorInfo[1] == 1062) { // Duplicate entry
            set_flash('danger', 'This email is already registered.');
        } else {
            set_flash('danger', 'An error occurred. Please try again later.');
        }
        redirect('index.php?page=register');
    }
} else {
    redirect('index.php?page=register');
}