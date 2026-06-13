<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css"/>
    <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : "Jo's Jobs - Admin Panel" ?></title>
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
            <h1>Jo's Jobs - Admin Area</h1>
        </section>
    </header>
    <nav>
        <ul>
            <li><a href="../index.php">Public Home</a></li>
            <li><a href="index.php?action=home">Admin Dashboard</a></li>
            <?php if (isset($_SESSION['loggedin'])): ?>
                <li><a href="index.php?action=listJobs">Jobs</a></li>
                <li><a href="index.php?action=listCategories">Categories</a></li>
                <li><a href="index.php?action=listUsers">Staff</a></li>
                <li><a href="index.php?action=listClients">Clients</a></li>
                <li><a href="index.php?action=listEnquiries">Enquiries</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['loggedin'])): ?>
                <li><a href="index.php?action=logout">Log Out</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <img src="../images/randombanner.php" alt="Banner"/>
    
    <main>
        <?= isset($output) ? $output : '' ?>
    </main>

    <footer>
        &copy; Jo's Jobs Admin Panel <?= date('Y') ?>
    </footer>
</body>
</html>