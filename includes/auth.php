<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\includes\auth.php
require_once __DIR__ . '/db.php';

function current_user()
{
  if (isset($_SESSION['user_id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
  }
  return null;
}

function require_login()
{
  if (!current_user()) {
    set_flash('danger', 'You must be logged in to view this page.');
    redirect('index.php?page=login');
  }
}

function login($user_id)
{
  session_regenerate_id(true);
  $_SESSION['user_id'] = $user_id;
}

function logout()
{
  session_unset();
  session_destroy();
  redirect('index.php?page=login');
}