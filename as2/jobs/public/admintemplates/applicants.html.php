<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        
        <?php if ($job): ?>
            <h2>Applicants for <?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h2>

            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">Name</th>
                        <th style="width: 10%">Email</th>
                        <th style="width: 65%">Details</th>
                        <th style="width: 15%">CV</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applicants)): ?>
                        <?php foreach ($applicants as $applicant): ?>
                            <tr>
                                <td><?= htmlspecialchars($applicant['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($applicant['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($applicant['details'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <a href="/cvs/<?= htmlspecialchars($applicant['cv'], ENT_QUOTES, 'UTF-8') ?>">Download CV</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No applicants found for this job position.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h2>Job not found.</h2>
            <p><a href="index.php?action=listJobs">Back to Job list</a></p>
        <?php endif; ?>

    <?php else: ?>
        <h2>Log in</h2>
        <form action="index.php" method="post">
            <label>Password</label>
            <input type="password" name="password" />
            <input type="submit" name="submit" value="Log In" />
        </form>
    <?php endif; ?>
    </section>
</main>