<?php
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

            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
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
        <title>REGISTER</title>
    </head>
<body>

    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

</body>
</html>
