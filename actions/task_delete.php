<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\actions\task_delete.php
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

    $task_id = $_POST['task_id'] ?? '';

    // Sanitize input
    $task_id = filter_var($task_id, FILTER_SANITIZE_NUMBER_INT);

    // Basic validation
    if (empty($task_id)) {
        die("Task ID is required.");
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$task_id, $_SESSION['user_id']]);

        header('Location: ../public/index.php?page=tasks');
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
} else {
    die("Invalid request method.");
}