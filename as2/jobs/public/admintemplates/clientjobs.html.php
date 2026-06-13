<h2>My Posted Jobs</h2>
<p><a class="new" href="index.php?action=clientEditJob">Add Job</a> | <a href="index.php?action=clientLogout">Client Logout</a></p>
<table>
<thead><tr><th>Title</th><th>Category</th><th>Location</th><th>Closing Date</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($jobs as $job): ?>
<tr>
<td><?= htmlspecialchars($job['title']) ?></td>
<td><?= htmlspecialchars($job['categoryName'] ?? '') ?></td>
<td><?= htmlspecialchars($job['location']) ?></td>
<td><?= htmlspecialchars($job['closingDate']) ?></td>
<td><a href="index.php?action=clientEditJob&id=<?= $job['id'] ?>">Edit</a> | <a href="index.php?action=clientApplicants&id=<?= $job['id'] ?>">Applicants</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
