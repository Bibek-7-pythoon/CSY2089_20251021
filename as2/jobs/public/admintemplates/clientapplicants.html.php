<h2>Applicants</h2>
<?php if (!$job): ?><p>Job not found or access denied.</p><?php else: ?>
<h3><?= htmlspecialchars($job['title']) ?></h3>
<table><thead><tr><th>Name</th><th>Email</th><th>Details</th></tr></thead><tbody>
<?php foreach ($applicants as $applicant): ?><tr><td><?= htmlspecialchars($applicant['name']) ?></td><td><?= htmlspecialchars($applicant['email']) ?></td><td><?= htmlspecialchars($applicant['details']) ?></td></tr><?php endforeach; ?>
</tbody></table>
<?php endif; ?>
