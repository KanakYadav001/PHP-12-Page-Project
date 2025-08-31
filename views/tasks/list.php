<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/helpers.php';

require_login();

try {
  $stmt = $pdo->prepare("SELECT id, title, description FROM tasks WHERE user_id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $tasks = $stmt->fetchAll();
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
  die("An error occurred. Please try again later.");
}
?>

<h1>Tasks</h1>

<ul>
  <?php foreach ($tasks as $task): ?>
    <li>
      <?= h($task['title']) ?> - <?= h($task['description']) ?>
      <form action="../../actions/task_delete.php" method="post" style="display: inline;">
        <input type="hidden" name="csrf_token" value="<?= h(generate_csrf_token()) ?>">
        <input type="hidden" name="task_id" value="<?= h($task['id']) ?>">
        <button type="submit">Delete</button>
      </form>
    </li>
  <?php endforeach; ?>
</ul>

<a href="index.php?page=task_form">Create New Task</a>