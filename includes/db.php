<?php
require_once __DIR__ . '/config.php';

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
