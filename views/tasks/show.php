<?php
$uid=current_user()['id'];
$id=(int)($_GET['id']??0);
$st=db()->prepare('SELECT * FROM tasks WHERE id=? AND user_id=?');
$st->execute([$id,$uid]); $t=$st->fetch();
if(!$t){ echo '<p>Task not found.</p>'; return; }
?>
<h3>Task #<?= $t['id'] ?></h3>
<p><strong>Title:</strong> <?= e($t['title']) ?></p>
<p><strong>Status:</strong> <?= e($t['status']) ?></p>
<p><strong>Due:</strong> <?= e($t['due_date']) ?></p>
<p><strong>Description:</strong><br><?= nl2br(e($t['description'])) ?></p>
<a class="btn btn-secondary" href="<?= BASE_URL ?>index.php?page=task_form&id=<?= $t['id'] ?>">Edit</a>
