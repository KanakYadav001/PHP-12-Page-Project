<?php
require_once __DIR__ . '/../../includes/helpers.php';
?>

<form action="../../actions/task_store.php" method="post">
    <input type="hidden" name="csrf_token" value="<?= h(generate_csrf_token()) ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title"><br><br>
    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea><br><br>
    <input type="submit" value="Create Task">
</form>