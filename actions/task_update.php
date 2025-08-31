<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\actions\task_update.php
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
  $title = $_POST['title'] ?? '';
  $description = $_POST['description'] ?? '';

  // Sanitize input
  $task_id = filter_var($task_id, FILTER_SANITIZE_NUMBER_INT);
  $title = htmlspecialchars($title);
  $description = htmlspecialchars($description);

  if (empty($task_id) || empty($title)) {
    set_flash('danger', 'Task ID and title are required.');
    redirect('index.php?page=tasks');
  }

  try {
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $description, $task_id, $_SESSION['user_id']]);

    set_flash('success', 'Task updated successfully.');
    redirect('index.php?page=tasks');
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    set_flash('danger', 'An error occurred. Please try again later.');
    redirect('index.php?page=tasks');
  }
} else {
  redirect('index.php');
}