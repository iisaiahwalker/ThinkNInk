<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$errorMessage = "";

if (isset($_GET["error"]) && $_GET["error"] === "expired") {
    $errorMessage = "Invalid or expired verification code.";
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

    <!-- Error message display when code is invalid or expired -->
    <?php if (!empty($errorMessage)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form action="process_verification.php" method="POST">
        <div class="input-group">
            <label for="code">Verification Code</label>
            <input type="text" id="code" name="code" placeholder="Enter 6-digit code" required>
        </div>
        <button type="submit" class="login-button">Verify</button>
    </form>
</div>

</body>
</html>