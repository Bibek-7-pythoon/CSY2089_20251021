<h2>Admin Login</h2>

<?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form action="index.php?action=login" method="post" style="padding: 40px">
    <label>Username</label>
    <input type="text" name="username" required />

    <label>Password</label>
    <input type="password" name="password" required />

    <input type="submit" name="submit" value="Log In" />
</form>
