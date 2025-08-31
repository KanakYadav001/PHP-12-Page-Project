<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\actions\auth_login.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        set_flash('danger', 'CSRF token validation failed.');
        redirect('index.php?page=login');
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $email = htmlspecialchars($email);

    if (empty($email) || empty($password)) {
        set_flash('danger', 'Email and password are required.');
        redirect('index.php?page=login');
    }

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            login($user['id']);
            set_flash('success', 'You have been logged in successfully.');
            redirect('index.php?page=profile');
        } else {
            set_flash('danger', 'Invalid email or password.');
            redirect('index.php?page=login');
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        set_flash('danger', 'An error occurred. Please try again later.');
        redirect('index.php?page=login');
    }
} else {
    redirect('index.php?page=login');
}