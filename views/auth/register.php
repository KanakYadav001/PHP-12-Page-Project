<?php
require_once __DIR__ . '/../../includes/helpers.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<form action="../../actions/auth_register.php" method="post">
    <input type="hidden" name="csrf_token" value="<?= h(generate_csrf_token()) ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Register">
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?= h($_GET['error']) ?></p>
    <?php endif; ?>
</form>

</body>
</html>
