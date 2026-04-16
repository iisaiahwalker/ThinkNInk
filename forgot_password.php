<?php
declare(strict_types=1);
session_start();

$errorMessage = "";
if (!empty($_GET['error'])) {
    $errorMessage = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
}

$statusMessage = "";
if (!empty($_GET['status'])) {
    $statusMessage = htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <p class="brand">ThinkNInk</p>
    <h1>Forgot Password</h1>
    <p class="subtitle">Enter your PVAMU email and we'll send you a reset link.</p>

    <?php if ($errorMessage !== ""): ?>
        <div class="message error-message">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <?php if ($statusMessage !== ""): ?>
        <div class="message status-message">
            <?php echo $statusMessage; ?>
        </div>
    <?php endif; ?>

    <form action="process_forgot_password.php" method="POST">
        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email"
                   placeholder="student@students.pvamu.edu" required>
        </div>
        <button type="submit" class="login-button">Send Reset Link</button>
    </form>

    <p class="forgot-link">
        <a href="login.php">Back to login</a>
    </p>
</div>
</body>
</html>