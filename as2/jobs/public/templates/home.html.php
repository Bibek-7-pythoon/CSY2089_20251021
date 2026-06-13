<main>
    <p>Welcome to Jo's Jobs, we're a recruitment agency based in Northampton. We offer a range of different office jobs. Get in touch if you'd like to list a job with us.</p>

    <h2>Jobs Closing Soon:</h2>
    <ul class="listing">
        <?php foreach ($jobs as $job): ?>
            <li>
                <div class="details">
                    <h2><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <h3><?= htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p>Location: <?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p>Closing Date: <?= htmlspecialchars($job['closingDate'], ENT_QUOTES, 'UTF-8') ?></p>
                    <a class="more" href="index.php?page=apply&id=<?= $job['id'] ?>">Apply for this job</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Select the type of job you are looking for:</h2>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="index.php?page=jobs&categoryId=<?= $category['id'] ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></a></li>
        <?php endforeach; ?>
    </ul>
</main>
