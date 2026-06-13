<h2>Client Login</h2>
<?php if (!empty($error)): ?><p><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
<label>Username</label><input type="text" name="username" required>
<label>Password</label><input type="password" name="password" required>
<input type="submit" name="submit" value="Login">
</form>
