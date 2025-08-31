<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\views\tasks\list.php
$tasks = [];
try {
  $stmt = $pdo->prepare("SELECT id, title, description FROM tasks WHERE user_id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $tasks = $stmt->fetchAll();
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
  set_flash('danger', 'An error occurred while fetching tasks.');
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Tasks</h1>
  <a href="<?= BASE_URL ?>index.php?page=task_form" class="btn btn-primary">Create New Task</a>
</div>

<?php if (empty($tasks)): ?>
  <p>You have no tasks yet. Create one!</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($tasks as $task): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= e($task['title']) ?></strong><br>
          <small><?= e($task['description']) ?></small>
        </div>
        <form action="<?= BASE_URL ?>actions/task_delete.php" method="post" class="d-inline">
          <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
          <input type="hidden" name="task_id" value="<?= e($task['id']) ?>">
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>