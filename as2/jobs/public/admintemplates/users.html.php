<h2>Staff Accounts</h2>

<p><a href="index.php?action=addUser">Add staff account</a></p>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['role'] ?? 'staff', ENT_QUOTES, 'UTF-8') ?></td>
                <td><a href="index.php?action=editUser&id=<?= $user['id'] ?>">Edit</a></td>
                <td>
                    <?php if ((int)$user['id'] !== (int)($_SESSION['userId'] ?? 0)): ?>
                        <form action="index.php?action=deleteUser" method="post">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>" />
                            <input type="submit" value="Delete" />
                        </form>
                    <?php else: ?>
                        Current user
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
