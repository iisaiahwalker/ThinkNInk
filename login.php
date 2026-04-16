<?php
declare(strict_types=1);
session_start();

$errorMessage = "";

if (!empty($_GET['error'])) {
    $errorMessage = match($_GET['error']) {
        "invalid_email" => "Only PVAMU email addresses are allowed.",
        "invalid_code"  => "Invalid or expired verification code.",
        default         => htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8')
    };
}

$statusMessage = "";
if (!empty($_GET['status'])) {
    $statusMessage = match($_GET['status']) {
        "reset_success" => "Password reset successful. Please log in.",
        default         => htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8')
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Notes Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <p class="brand">ThinkNInk</p>
    <h1>Student Notes</h1>
    <p class="subtitle">Sign in to your class workspace</p>

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

    <form action="process_login.php" method="POST">
        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email"
                   placeholder="student@pvamu.edu" required
                   value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password"
                   placeholder="Enter password" required>
        </div>
        <button type="submit" class="login-button">Enter Dashboard</button>
    </form>

    <p class="forgot-link">
        <a href="forgot_password.php">Forgot your password?</a>
    </p>
</div>
</body>
</html>
