<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
        <?php if (!empty($message)): ?>
            <h2><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></h2>
            <p>
                <a href="index.php?action=listJobs">Return to Job List</a> or 
                <a href="index.php?action=addJob">Add another job</a>
            </p>
            
        <?php else: ?>
            <h2>Add Job</h2>

            <form action="index.php?action=addJob" method="POST">
                <label>Title</label>
                <input type="text" name="title" required />

                <label>Description</label>
                <textarea name="description" required></textarea>

                <label>Salary</label>
                <input type="text" name="salary" required />

                <label>Location</label>
                <input type="text" name="location" required />

                <label>Category</label>
                <select name="categoryId" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $row): ?>
                        <option value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Closing Date</label>
                <input type="date" name="closingDate" required />

                <input type="submit" name="submit" value="Add" />
            </form>
        <?php endif; ?>
    </section>
</main>