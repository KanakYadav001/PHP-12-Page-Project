<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_project_db');      // <-- Aapke naye database ka naam
define('DB_USER', 'root');               // <-- XAMPP ka default username 'root' hota hai
define('DB_PASS', '');                   // <-- XAMPP ka default password khaali (empty) hota hai

// Application URL
define('BASE_URL', 'http://localhost/PHP-PROJECT-12Page/public/');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);