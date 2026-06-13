<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <h2>Jobs</h2>
        <a class="new" href="index.php?action=addJob">Add new job</a>

        <form method="get" action="index.php">
            <input type="hidden" name="action" value="listJobs">

            <label>Category</label>
            <select name="categoryId">
                <option value="">All categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= (string)$selectedCategoryId === (string)$category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Status</label>
            <select name="status">
                <option value="active" <?= $selectedStatus === 'active' ? 'selected' : '' ?>>Available jobs</option>
                <option value="all" <?= $selectedStatus === 'all' ? 'selected' : '' ?>>All jobs</option>
                <option value="archived" <?= $selectedStatus === 'archived' ? 'selected' : '' ?>>Archived jobs</option>
            </select>

            <input type="submit" value="Filter">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Received date</th>
                    <th>Closing date</th>
                    <th>Salary</th>
                    <th>Applicants</th>
                    <th>Edit</th>
                    <th>Archive/Repost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($job['categoryName'] ?? 'No category', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($job['dateAdded'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($job['closingDate'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="index.php?action=viewApplicants&id=<?= $job['id'] ?>">
                                View applicants (<?= $job['applicant_count'] ?? 0 ?>)
                            </a>
                        </td>
                        <td>
                            <a href="index.php?action=editJob&id=<?= $job['id'] ?>">Edit</a>
                        </td>
                        <td>
                            <?php if ((int)$job['archived'] === 1): ?>
                                <form method="post" action="index.php?action=repostJob">
                                    <input type="hidden" name="id" value="<?= $job['id'] ?>">
                                    <input type="submit" value="Repost">
                                </form>
                            <?php else: ?>
                                <form method="post" action="index.php?action=archiveJob">
                                    <input type="hidden" name="id" value="<?= $job['id'] ?>">
                                    <input type="submit" value="Archive">
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h2>Log in</h2>
        <form action="index.php?action=home" method="post">
            <label>Password</label>
            <input type="password" name="password">
            <input type="submit" name="submit" value="Log In">
        </form>
    <?php endif; ?>
    </section>
</main>
