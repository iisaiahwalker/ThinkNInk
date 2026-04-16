<?php
declare(strict_types=1);
session_start();

if (empty($_SESSION["pending_email"]) || empty($_SESSION["pending_student_id"])) {
    header("Location: login.php");
    exit();
}

$errorMessage = "";
if (!empty($_GET["error"])) {
    $errorMessage = htmlspecialchars($_GET["error"], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <p class="brand">ThinkNInk</p>
    <h1>Verify Login</h1>
    <p class="subtitle">Enter your 6-digit verification code.</p>

    <?php if ($errorMessage !== ""): ?>
        <p style="color:red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form action="process_verification.php" method="POST">
        <div class="input-group">
            <label for="code">Verification Code</label>
            <input type="text" id="code" name="code"
                   placeholder="Enter 6-digit code"
                   maxlength="6" pattern="\d{6}"
                   inputmode="numeric" required>
        </div>
        <button type="submit" class="login-button">Verify</button>
    </form>
</div>
</body>
</html>