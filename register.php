<?php
    session_start();
    include('includes/db.php');

    $error = '';
    $success = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            $error = "Username or email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword, 'user']);

            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);

            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header('Location: domains.php');
                exit;
            }
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
        <link rel="stylesheet" href="assets/css/register.css">
        <link rel="stylesheet" href="assets/css/custom_button.css">
        <title>REGISTER</title>
    </head>
<body>
    <div class="relative">
        <div class="landing-background"></div>
        <div class="content">
            <div class="register-card">

                <h2>REGISTER</h2>

                <form action="register.php" method="POST">
                    <div class="input-container">
                        <label for="username">Username:</label>
                        <input class="input-field" type="text" name="username" id="username" required><br><br>
                    </div>

                    <div class="input-container">
                        <label class="input-title" for="email">Email:</label>
                        <input class="input-field" type="email" name="email" id="email" required><br><br>
                    </div>

                    <div class="input-container">
                        <label class="input-title" for="password">Password:</label>
                        <input class="input-field" type="password" name="password" id="password" required><br><br>
                    </div>

                    <div class="input-container register-container">
                        <input class="custom-button"  type="submit" value="Register">
                    </div>

                </form>

                <div class="switch-mode-container">
                    <p>Already have an account? </p> 
                    <a href="login.php" class="link-button"><strong>Login</strong></a>
                </div>  
            </div>
        </div>
    </div>
</body>
</html>
