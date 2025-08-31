<?php
// filepath: C:\Users\kanka\PHP-PROJECT-12Page\views\auth\register.php
?>
<h3>Register</h3>
<form method="post" action="<?= BASE_URL ?>actions/auth_register.php" class="mt-3" style="max-width:420px">
  <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input class="form-control" type="text" name="name" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input class="form-control" type="password" name="password" required>
  </div>
  <button class="btn btn-primary">Register</button>
</form>
<p class="mt-2"><a href="<?= BASE_URL ?>index.php?page=login">Already have an account?</a></p>