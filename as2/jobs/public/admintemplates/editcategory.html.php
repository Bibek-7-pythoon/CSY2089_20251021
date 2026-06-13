<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        
        <?php if (!empty($message) && empty($currentCategory)): ?>
            <h2><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></h2>
            <p><a href="index.php?action=listCategories">Return to Categories list</a></p>

        <?php elseif ($currentCategory !== null || $title === 'Add New Category' || !empty($message)): ?>
            
            <h2><?= $currentCategory ? 'Edit Category' : 'Add New Category' ?></h2>
            
            <?php if (!empty($message)): ?>
                <p class="success-msg" style="color: green; font-weight: bold; margin-bottom: 15px;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form action="index.php?action=editCategory" method="POST">
                <input type="hidden" name="id" value="<?= isset($currentCategory['id']) ? htmlspecialchars($currentCategory['id'], ENT_QUOTES, 'UTF-8') : '' ?>" />
                
                <label>Name</label>
                <input type="text" name="name" value="<?= isset($currentCategory['name']) ? htmlspecialchars($currentCategory['name'], ENT_QUOTES, 'UTF-8') : '' ?>" required />
                
                <input type="submit" name="submit" value="Save Category" />
            </form>

        <?php else: ?>
            <h2>Category not found.</h2>
            <p><a href="index.php?action=listCategories">Back to Categories list</a></p>
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