<main>
    <h2>Contact Jo's Jobs</h2>
    <?php if ($message): ?><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
    <form method="post" action="index.php?page=contact">
        <label>First name</label><input type="text" name="firstName" required>
        <label>Surname</label><input type="text" name="surname" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Telephone</label><input type="text" name="telephone" required>
        <label>Enquiry</label><textarea name="enquiry" required></textarea>
        <input type="submit" name="submit" value="Send Enquiry">
    </form>
</main>
