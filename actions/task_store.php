<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\actions\task_store.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    // Sanitize input
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    // Basic validation
    if (empty($title)) {
        die("Title is required.");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $description]);

        header('Location: ../public/index.php?page=tasks');
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
} else {
    die("Invalid request method.");
}
