<h2><?= $user ? 'Edit Staff Account' : 'Add Staff Account' ?></h2>

<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form action="index.php?action=<?= $user ? 'editUser' : 'addUser' ?>" method="post">
    <?php if ($user): ?>
        <input type="hidden" name="id" value="<?= $user['id'] ?>" />
    <?php endif; ?>

    <label>Username</label>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />

    <label>Password <?= $user ? '(leave blank to keep current password)' : '' ?></label>
    <input type="password" name="password" <?= $user ? '' : 'required' ?> />

    <label>Role</label>
    <select name="role">
        <option value="staff" <?= (($user['role'] ?? '') === 'staff') ? 'selected' : '' ?>>Staff</option>
        <option value="admin" <?= (($user['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
    </select>

    <input type="submit" name="submit" value="Save Account" />
</form>
