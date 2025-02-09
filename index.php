<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOT • DEALERS</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="globals.css">
</head>

<body>
    <div class="relative">
        <div class="landing-background"></div>
        <div class="content">
            <h1 class="heading">DOT•DEALERS</h1>
            <p class="subheading">
                <?php if ($isLoggedIn): ?>
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                <?php else: ?>
                    Claim your name
                <?php endif; ?>
            </p>
            <div class="button-container">
                <?php if (!$isLoggedIn): ?>
                    <a href="login.php" class="link-button">Log in</a>
                    <a href="register.php" class="link-button">Register</a>
                <?php else: ?>
                    <a href="domains.php" class="link-button">Domains</a>
                    <a href="logout.php" class="link-button">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
