<h2><?= isset($client) && $client ? 'Edit Client' : 'Add Client' ?></h2>
<?php if (!empty($message)): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post">
<input type="hidden" name="id" value="<?= htmlspecialchars($client['id'] ?? '') ?>">
<label>Company name</label>
<input type="text" name="companyName" value="<?= htmlspecialchars($client['companyName'] ?? '') ?>" required>
<label>Username</label>
<input type="text" name="username" value="<?= htmlspecialchars($client['username'] ?? '') ?>" required>
<label>Password <?= isset($client) && $client ? '(leave blank to keep current)' : '' ?></label>
<input type="password" name="password">
<input type="submit" name="submit" value="Save Client">
</form>
