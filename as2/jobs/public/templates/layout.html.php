<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/styles.css">
    <title><?= htmlspecialchars($title ?? "Jo's Jobs", ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
<header>
    <section>
        <aside>
            <h3>Office Hours:</h3>
            <p>Mon-Fri: 09:00-17:30</p>
            <p>Sat: 09:00-17:00</p>
            <p>Sun: Closed</p>
        </aside>
        <h1>Jo's Jobs</h1>
    </section>
</header>

<nav>
    <ul>
        <li><a href="/index.php?page=home">Home</a></li>
        <li><a href="/index.php?page=jobs">Jobs</a>
            <ul>
                <?php foreach ($categories ?? [] as $category): ?>
                    <li>
                        <a href="/index.php?page=jobs&categoryId=<?= $category['id'] ?>">
                            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li><a href="/index.php?page=careers-advice">Careers Advice</a></li>
        <li><a href="/index.php?page=about">About Us</a></li>
        <li><a href="/index.php?page=contact">Contact</a></li>
        <li><a href="/admin/index.php?action=clientLogin">Client Login</a></li>
    </ul>
</nav>

<img src="/images/randombanner.php" alt="Banner">

<?= $output ?? '' ?>

<footer>
    &copy; Jo's Jobs <?= date('Y') ?>
</footer>
</body>
</html>
