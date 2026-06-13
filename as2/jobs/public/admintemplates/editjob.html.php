<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        
        <?php if (!empty($message) && empty($job)): ?>
            <h2><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></h2>
            <p><a href="index.php?action=listJobs">Return to Jobs list</a></p>

        <?php elseif ($job !== null || $title === 'Add New Job' || !empty($message)): ?>
            
            <h2><?= $job ? 'Edit Job' : 'Add New Job' ?></h2>
            
            <?php if (!empty($message)): ?>
                <p class="success-msg" style="color: green; font-weight: bold; margin-bottom: 15px;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form action="index.php?action=editJob" method="POST">
                <input type="hidden" name="id" value="<?= isset($job['id']) ? htmlspecialchars($job['id'], ENT_QUOTES, 'UTF-8') : '' ?>" />
                
                <label>Title</label>
                <input type="text" name="title" value="<?= isset($job['title']) ? htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') : '' ?>" required />

                <label>Description</label>
                <textarea name="description" rows="5" required><?= isset($job['description']) ? htmlspecialchars($job['description'], ENT_QUOTES, 'UTF-8') : '' ?></textarea>

                <label>Salary</label>
                <input type="text" name="salary" value="<?= isset($job['salary']) ? htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') : '' ?>" required />

                <label>Location</label>
                <input type="text" name="location" value="<?= isset($job['location']) ? htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') : '' ?>" required />

                <label>Category</label>
                <select name="categoryId" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $category): ?>
                        <?php 
                            $selected = (isset($job['categoryId']) && $job['categoryId'] == $category['id']) ? 'selected' : ''; 
                        ?>
                        <option value="<?= $category['id'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Closing Date</label>
                <input type="date" name="closingDate" value="<?= isset($job['closingDate']) ? htmlspecialchars($job['closingDate'], ENT_QUOTES, 'UTF-8') : '' ?>" required />

                <label>
                    <input type="checkbox" name="archived" value="1" <?= isset($job['archived']) && (int)$job['archived'] === 1 ? 'checked' : '' ?> />
                    Archive this job
                </label>
                
                <input type="submit" name="submit" value="Save Job" />
            </form>

        <?php else: ?>
            <h2>Job not found.</h2>
            <p><a href="index.php?action=listJobs">Back to Jobs list</a></p>
        <?php endif; ?>

    <?php else: ?>
        <h2>Log in</h2>
        <form action="index.php?action=home" method="post">
            <label>Password</label>
            <input type="password" name="password" required />
            <input type="submit" name="submit" value="Log In" />
        </form>
    <?php endif; ?>
    </section>
</main>