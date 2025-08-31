<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\views\tasks\form.php
?>
<h3>Create Task</h3>
<form action="<?= BASE_URL ?>actions/task_store.php" method="post" class="mt-3" style="max-width:420px">
    <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
    <div class="mb-3">
      <label for="title" class="form-label">Title:</label>
      <input type="text" id="title" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description:</label>
      <textarea id="description" name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create Task</button>
</form>