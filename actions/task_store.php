<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\actions\task_store.php
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

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    // Sanitize input
    $title = htmlspecialchars($title);
    $description = htmlspecialchars($description);

    if (empty($title)) {
        set_flash('danger', 'Title is required.');
        redirect('index.php?page=task_form');
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $description]);

        set_flash('success', 'Task created successfully.');
        redirect('index.php?page=tasks');
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        set_flash('danger', 'An error occurred. Please try again later.');
        redirect('index.php?page=task_form');
    }
} else {
    redirect('index.php');
}