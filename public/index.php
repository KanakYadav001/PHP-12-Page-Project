<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\public\index.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';


$page = $_GET['page'] ?? 'home';

// Sanitize the page parameter
$page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');

$public = ['home', 'login', 'register'];

$map = [
  'home' => 'home.php',
  'login' => 'auth/login.php',
  'register' => 'auth/register.php',
  'profile' => 'auth/profile.php',
  'tasks' => 'tasks/list.php',
  'task_form' => 'tasks/form.php',
  'task_show' => 'tasks/show.php',
  '404' => '404.php',
];

if (!in_array($page, $public)) {
  require_login();
}

$view = $map[$page] ?? '404.php';


include __DIR__ . '/../views/partials/header.php';
include __DIR__ . '/../views/' . $view;
include __DIR__ . '/../views/partials/footer.php';