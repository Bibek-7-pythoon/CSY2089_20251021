<main class="sidebar">
    <section class="left">
        <ul>
            <li><a href="index.php?action=listJobs">Jobs</a></li>
            <li><a href="index.php?action=listCategories">Categories</a></li>
            <li><a href="index.php?action=listUsers">Staff Accounts</a></li>
            <li><a href="index.php?action=logout">Log Out</a></li>
        </ul>
    </section>

    <section class="right">
        <h2>Admin Dashboard</h2>
        <p>You are logged in as <?= htmlspecialchars($_SESSION['username'] ?? 'staff', ENT_QUOTES, 'UTF-8') ?>.</p>
        <p>Use the links on the left to manage jobs, categories and staff accounts.</p>
    </section>
</main>
