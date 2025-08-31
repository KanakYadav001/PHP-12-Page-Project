<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\public\index.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';

$page = $_GET['page'] ?? 'home';

// Sanitize the page parameter
$page = filter_var($page, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

// Validate the page parameter against a whitelist
if (!isset($map[$page])) {
  $page = '404'; // Default to 404 if the page is not in the map
  error_log("Invalid page requested: " . htmlspecialchars($_GET['page'])); // Log the invalid request
}

$view = $map[$page];

if (!in_array($page, $public)) {
  require_login();
}

include __DIR__ . '/../views/partials/header.php';
include __DIR__ . '/../views/' . $view;
include __DIR__ . '/../views/partials/footer.php';
?>
<h3>Login</h3>
<form method="post" action="<?= BASE_URL ?>../actions/auth_login.php" class="mt-3" style="max-width:420px">
  <div class="mb-3"><label>Email</label><input class="form-control" type="email" name="email" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-primary">Login</button>
</form>
<p class="mt-2"><a href="<?= BASE_URL ?>index.php?page=register">Create account</a></p>
<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\includes\db.php

$db_host = DB_HOST;
$db_name = DB_NAME;
$db_user = DB_USER;
$db_pass = DB_PASS;

try {
  $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}
?>

<?php
// filepath: c:\Users\kanka\PHP-PROJECT-12Page\includes\helpers.php

function h(string $string): string
{
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function generate_csrf_token(): string
{
  if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function validate_csrf_token(string $token): bool
{
  return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
<?php require_once __DIR__ . '/../../includes/helpers.php'; ?>

<form action="../../actions/auth_login.php" method="post">
  <input type="hidden" name="csrf_token" value="<?= h(generate_csrf_token()) ?>">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username"><br><br>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password"><br><br>
  <input type="submit" value="Login">
</form>