<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\views\tasks\show.php
$task = null;
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $_SESSION['user_id']]);
        $task = $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        set_flash('danger', 'An error occurred while fetching the task.');
        redirect('index.php?page=tasks');
    }
}

if (!$task) {
    set_flash('danger', 'Task not found.');
    redirect('index.php?page=tasks');
}
?>

<div class="card">
  <div class="card-header">
    <h3>Task #<?= e($task['id']) ?></h3>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?= e($task['title']) ?></h5>
    <p class="card-text"><?= nl2br(e($task['description'])) ?></p>
    <ul class="list-unstyled">
      <li><strong>Status:</strong> <?= e($task['status'] ?? 'N/A') ?></li>
      <li><strong>Due:</strong> <?= e($task['due_date'] ?? 'N/A') ?></li>
    </ul>
    <a class="btn btn-secondary" href="<?= BASE_URL ?>index.php?page=task_form&id=<?= e($task['id']) ?>">Edit</a>
    <a class="btn btn-light" href="<?= BASE_URL ?>index.php?page=tasks">Back to Tasks</a>
  </div>
</div>