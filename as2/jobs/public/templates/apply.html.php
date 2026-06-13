<main class="sidebar">
    <section class="left">
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href="index.php?page=jobs&categoryId=<?= $category['id'] ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="right">
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php elseif ($error): ?>
            <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php else: ?>
            <h2>Apply for <?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h2>
            <form action="index.php?page=apply" method="POST" enctype="multipart/form-data">
                <label>Your name</label>
                <input type="text" name="name" required>
                <label>Email address</label>
                <input type="email" name="email" required>
                <label>Cover letter</label>
                <textarea name="details" required></textarea>
                <label>CV</label>
                <input type="file" name="cv">
                <input type="hidden" name="jobId" value="<?= htmlspecialchars($job['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" name="submit" value="Apply">
            </form>
        <?php endif; ?>
    </section>
</main>
