<?php
require_once __DIR__ . '/../../includes/helpers.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>My App</title>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php $u = current_user(); ?>
  <nav class="navbar navbar-expand-lg bg-light mb-3">
    <div class="container">
      <a class="navbar-brand" href="<?= BASE_URL ?>index.php">SimpleApp</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <?php if ($u): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php?page=tasks">Tasks</a></li>
          <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
          <?php if ($u): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php?page=profile"><?= e($u['name']) ?></a>
            </li>
            <li class="nav-item">
              <form method="post" action="<?= BASE_URL ?>../actions/auth_logout.php"><button
                  class="btn btn-link nav-link">Logout</button></form>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php?page=login">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php?page=register">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php foreach (get_flash_all() as $t => $m): ?>
      <div class="alert alert-<?= e($t) ?>"><?= e($m) ?></div>
    <?php endforeach; ?>