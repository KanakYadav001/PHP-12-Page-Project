<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\actions\auth_register.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Sanitize input
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    // Basic validation
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);

        header('Location: ../public/index.php?page=login');
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
} else {
    die("Invalid request method.");
}
