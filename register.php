<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Color Betting Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container auth-container">
        <h1>Register</h1>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <form action="core/handleAuth.php" method="POST" class="auth-form">
            <p>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" required>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" required>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </p>
            <p>
                <label for="address">Address:</label>
                <textarea name="address" required></textarea>
            </p>
            <p>
                <label for="age">Age:</label>
                <input type="number" name="age" required min="18">
            </p>
            <input type="submit" name="registerBtn" value="Register" class="btn">
            <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>