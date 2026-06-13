<h2>Customer Enquiries</h2>
<form method="get">
<input type="hidden" name="action" value="listEnquiries">
<label>Status</label>
<select name="status"><option <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option><option <?= $selectedStatus === 'Complete' ? 'selected' : '' ?>>Complete</option><option <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option></select>
<input type="submit" value="Filter">
</form>
<table><thead><tr><th>Name</th><th>Email</th><th>Telephone</th><th>Enquiry</th><th>Status</th><th>Handled By</th><th>Action</th></tr></thead><tbody>
<?php foreach ($enquiries as $enquiry): ?><tr>
<td><?= htmlspecialchars($enquiry['firstName'] . ' ' . $enquiry['surname']) ?></td>
<td><?= htmlspecialchars($enquiry['email']) ?></td>
<td><?= htmlspecialchars($enquiry['telephone']) ?></td>
<td><?= htmlspecialchars($enquiry['enquiry']) ?></td>
<td><?= htmlspecialchars($enquiry['status']) ?></td>
<td><?= htmlspecialchars($enquiry['staffUsername'] ?? '') ?></td>
<td><?php if ($enquiry['status'] !== 'Complete'): ?><form method="post" action="index.php?action=completeEnquiry"><input type="hidden" name="id" value="<?= $enquiry['id'] ?>"><input type="submit" value="Mark Complete"></form><?php endif; ?></td>
</tr><?php endforeach; ?>
</tbody></table>
