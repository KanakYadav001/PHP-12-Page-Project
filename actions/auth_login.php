<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\actions\auth_login.php
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

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            login($user['id']);
            header('Location: ../public/index.php?page=profile');
            exit;
        } else {
            die("Invalid username or password.");
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
} else {
    die("Invalid request method.");
}
