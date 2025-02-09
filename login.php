<?php
    session_start();

    include('includes/db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: domains.php'); 
            exit;
        } else {
            echo "Invalid username or password.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="globals.css">
    <link rel="stylesheet" href="assets/css/custom_button.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>LOGIN</title>
</head>
<body>

    <div class="relative">
        <div class="landing-background"></div>
        <div class="content">
            <div class="login-card">
                <h1>LOGIN</h1>
                <form action="login.php" method="POST">
                    <div class="input-container">
                        <label for="username">Username</label><br>
                        <input class="input-field" type="text" id="username" name="username" required><br>
                    </div>
                    
                    <div class="input-container">
                        <label for="password">Password</label><br>
                        <input class="input-field" type="password" id="password" name="password" required><br>
                    </div>
                    <div class="input-container login-container">
                        <input class="custom-button" type="submit" value="Login" >
                    </div>
                    </form>
                    <div class="switch-mode-container">
                        <p>Don't have an account?</p>
                        <a href="register.php" class="link-button" style="color: gree"><strong>Register</strong></a>
                    </div>
                </div>
            </div>
        </body>
</html>
