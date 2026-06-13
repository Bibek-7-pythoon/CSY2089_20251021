<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?page=jobs">All Jobs</a></li>
            <?php foreach ($categories as $category): ?>
                <li class="<?= (string)$category['id'] === (string)$categoryId ? 'current' : '' ?>">
                    <a href="index.php?page=jobs&categoryId=<?= $category['id'] ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="right">
        <h1><?= htmlspecialchars($currentCategory['name'] ?? 'All Jobs', ENT_QUOTES, 'UTF-8') ?></h1>

        <form method="get" action="index.php">
            <input type="hidden" name="page" value="jobs">
            <?php if ($categoryId !== ''): ?>
                <input type="hidden" name="categoryId" value="<?= htmlspecialchars($categoryId, ENT_QUOTES, 'UTF-8') ?>">
            <?php endif; ?>
            <label>Job title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($titleSearch, ENT_QUOTES, 'UTF-8') ?>">
            <label>Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($locationSearch, ENT_QUOTES, 'UTF-8') ?>">
            <input type="submit" value="Filter jobs">
            <a href="index.php?page=jobs<?= $categoryId !== '' ? '&categoryId=' . urlencode($categoryId) : '' ?>">Clear filter</a>
        </form>

        <ul class="listing">
            <?php foreach ($jobs as $job): ?>
                <li>
                    <div class="details">
                        <h2><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <h3><?= htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p>Category: <?= htmlspecialchars($job['categoryName'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p>Location: <?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= nl2br(htmlspecialchars($job['description'], ENT_QUOTES, 'UTF-8')) ?></p>
                        <a class="more" href="index.php?page=apply&id=<?= $job['id'] ?>">Apply for this job</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (count($jobs) === 0): ?>
            <p>No jobs matched your search.</p>
        <?php endif; ?>
    </section>
</main>
