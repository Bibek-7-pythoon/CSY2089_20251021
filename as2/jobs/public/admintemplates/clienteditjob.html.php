<h2><?= isset($job) && $job ? 'Edit My Job' : 'Add Job' ?></h2>
<?php if (!empty($message)): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post">
<input type="hidden" name="id" value="<?= htmlspecialchars($job['id'] ?? '') ?>">
<label>Title</label><input type="text" name="title" value="<?= htmlspecialchars($job['title'] ?? '') ?>" required>
<label>Description</label><textarea name="description" required><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
<label>Salary</label><input type="text" name="salary" value="<?= htmlspecialchars($job['salary'] ?? '') ?>" required>
<label>Location</label><input type="text" name="location" value="<?= htmlspecialchars($job['location'] ?? '') ?>" required>
<label>Category</label><select name="categoryId" required><?php foreach ($categories as $category): ?><option value="<?= $category['id'] ?>" <?= (($job['categoryId'] ?? '') == $category['id']) ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option><?php endforeach; ?></select>
<label>Closing date</label><input type="date" name="closingDate" value="<?= htmlspecialchars($job['closingDate'] ?? '') ?>" required>
<input type="submit" name="submit" value="Save Job">
</form>
