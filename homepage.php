<?php
require_once 'bootstrap.php';
?>


<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Home page</title>
    <link rel="stylesheet" href="./static/homepage.css">
</head>

<body>

    <div class="account-related">
        <?php if (isset($_SESSION['username'])): ?>
            <div class="greetings">Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>! Welcome back.</div>
        <?php else: ?>
            <?php header("Location: index.html"); ?>
        <?php endif; ?>

        <div class="logout-button">
        <!-- Бутон за logout -->
        <form method="post" action="logout.php">
            <button type="submit" name="logout">Log out</button>
        </form>
        </div>
    </div>

    <!-- Секция за качване на снимка -->
    <div class="change-password-section">

            
    </div>

</body>

</html>