<?php
require_once __DIR__ . '/db.php';

session_start();

function current_user()
{
  return $_SESSION['user'] ?? null;
}
function require_login()
{
  if (!current_user())
    redirect('index.php?page=login');
}

function login_user($email, $password)
{
  $st = db()->prepare('SELECT id,name,email,password FROM users WHERE email=?');
  $st->execute([$email]);
  $u = $st->fetch();
  if ($u && password_verify($password, $u['password'])) {
    $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'email' => $u['email']];
    return true;
  }
  return false;
}

function register_user($name, $email, $password)
{
  $hash = password_hash($password, PASSWORD_BCRYPT);
  try {
    db()->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)')->execute([$name, $email, $hash]);
    return true;
  } catch (Throwable $e) {
    return false;
  }
}

function logout_user()
{
  $_SESSION = [];
  session_destroy();
}

function is_logged_in()
{
  return isset($_SESSION['user_id']);
}

function login($user_id)
{
  // Regenerate session ID to prevent session fixation
  session_regenerate_id(true);
  $_SESSION['user_id'] = $user_id;
}

function logout()
{
  session_unset();
  session_destroy();
  header('Location: home.php'); // Redirect to home page
  exit;
}
