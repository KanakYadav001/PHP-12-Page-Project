<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\actions\task_delete.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        set_flash('danger', 'CSRF token validation failed.');
        redirect('index.php?page=tasks');
    }

    $task_id = $_POST['task_id'] ?? '';
    $task_id = filter_var($task_id, FILTER_SANITIZE_NUMBER_INT);

    if (empty($task_id)) {
        set_flash('danger', 'Task ID is required.');
        redirect('index.php?page=tasks');
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$task_id, $_SESSION['user_id']]);

        set_flash('success', 'Task deleted successfully.');
        redirect('index.php?page=tasks');
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        set_flash('danger', 'An error occurred. Please try again later.');
        redirect('index.php?page=tasks');
    }
} else {
    redirect('index.php');
}