<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        
        <?php if (!empty($message)): ?>
            <h2><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></h2>
            <p><a href="index.php?action=listCategories">Return to Categories list</a> or <a href="addcategory.php">Add another category</a></p>
        <?php else: ?>
            <h2>Add Category</h2>

            <form action="addcategory.php" method="POST">
                <label>Name</label>
                <input type="text" name="name" />

                <input type="submit" name="submit" value="Add Category" />
            </form>
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