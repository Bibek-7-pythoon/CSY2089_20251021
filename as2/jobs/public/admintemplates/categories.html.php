<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
        </ul>
    </section>

    <section class="right">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <h2>Categories</h2>
        <a class="new" href="index.php?action=addCategory">Add new category</a>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 5%\">&nbsp;</th>
                    <th style="width: 5%\">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a style="float: right" href="index.php?action=editCategory&id=<?= $category['id'] ?>">Edit</a>
                        </td>
                        <td>
                            <form method="post" action="index.php?action=deleteCategory">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>" />
                                <input type="submit" name="submit" value="Delete" />
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h2>Log in</h2>
        <form action="index.php?action=home" method="post">
            <label>Password</label>
            <input type="password" name="password" />
            <input type="submit" name="submit" value="Log In" />
        </form>
    <?php endif; ?>
    </section>
</main>