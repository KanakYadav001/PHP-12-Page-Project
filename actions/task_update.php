<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\actions\task_update.php
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
  $title = $_POST['title'] ?? '';
  $description = $_POST['description'] ?? '';

  // Sanitize input
  $task_id = filter_var($task_id, FILTER_SANITIZE_NUMBER_INT);
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $description = filter_var($description, FILTER_SANITIZE_STRING);

  // Basic validation
  if (empty($task_id) || empty($title)) {
    die("Task ID and title are required.");
  }

  try {
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $description, $task_id, $_SESSION['user_id']]);

    header('Location: ../public/index.php?page=tasks');
    exit;
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("An error occurred. Please try again later.");
  }
} else {
  die("Invalid request method.");
}
