<main class="home">
    <p>Welcome to Jo's Jobs, we're a recruitment agency based in Northampton. We offer a range of different office jobs. Get in touch if you'd like to list a job with us.</p>

    <h2>About Us</h2>
    <p>Jo's Jobs is a recruitment agency that helps applicants find suitable jobs and helps employers advertise their vacancies.</p>

    <h2>Select the type of job you are looking for:</h2>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="index.php?page=jobs&categoryId=<?= $category['id'] ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></a></li>
        <?php endforeach; ?>
    </ul>
</main>
