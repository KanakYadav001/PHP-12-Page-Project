<?php $u=current_user(); ?>
<h3>Profile</h3>
<ul>
  <li>Name: <?= e($u['name']) ?></li>
  <li>Email: <?= e($u['email']) ?></li>
</ul>
