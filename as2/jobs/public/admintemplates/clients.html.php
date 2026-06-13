<h2>Manage Client Accounts</h2>
<p><a class="new" href="index.php?action=addClient">Add client</a></p>
<table>
<thead><tr><th>Company</th><th>Username</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($clients as $client): ?>
<tr>
<td><?= htmlspecialchars($client['companyName']) ?></td>
<td><?= htmlspecialchars($client['username']) ?></td>
<td>
<a href="index.php?action=editClient&id=<?= $client['id'] ?>">Edit</a>
<form method="post" action="index.php?action=deleteClient" style="display:inline" onsubmit="return confirm('Delete this client?');">
<input type="hidden" name="id" value="<?= $client['id'] ?>"><input type="submit" value="Delete">
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
