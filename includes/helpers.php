<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\includes\helpers.php
session_start();

function redirect(string $path)
{
    header('Location: ' . BASE_URL . ltrim($path, '/'));
    exit;
}

function e(string $v)
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function set_flash($type, $msg)
{
    $_SESSION['flash'][$type] = $msg;
}

function get_flash_all()
{
    $f = $_SESSION['flash'] ?? [];
    $_SESSION['flash'] = [];
    return $f;
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