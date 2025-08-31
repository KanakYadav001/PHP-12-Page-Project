
<h3>Login</h3>
<form method="post" action="<?= BASE_URL ?>actions/auth_login.php" class="mt-3" style="max-width:420px">
  <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input class="form-control" type="password" name="password" required>
  </div>
  <button class="btn btn-primary">Login</button>
</form>
<p class="mt-2"><a href="<?= BASE_URL ?>index.php?page=register">Create account</a></p>