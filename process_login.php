<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

if (substr($email, -10) !== "@pvamu.edu") {
    header("Location: login.php?error=email");
    exit();
}

$sql = "SELECT * FROM Students WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $pageTitle = "Login Error";
    $subtitle = "We could not start the login process.";
    $isError = true;
} else {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        header("Location: login.php?error=email");
        exit();
    }

    $student = $result->fetch_assoc();

    if (md5($password) !== $student["password"]) {
        header("Location: login.php?error=password");
        exit();
    }

    $code = rand(100000, 999999);

    $update = $conn->prepare("
        UPDATE Students
        SET verification_code = ?,
            code_expiration = DATE_ADD(NOW(), INTERVAL 1 MINUTE)
        WHERE email = ?
    ");

    if (!$update) {
        $pageTitle = "Verification Error";
        $subtitle = "Your account was found, but the verification code could not be created.";
        $isError = true;
    } else {
        $update->bind_param("ss", $code, $email);
        $update->execute();

        $_SESSION["email"] = $email;
        $_SESSION["demo_code"] = $code; // demo/testing only

        $pageTitle = "Verify Login";
        $subtitle = "Your login was accepted. Use the 6-digit code below to continue.";
        $isError = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | ThinkNInk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <p class="brand">ThinkNInk</p>

    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    <p class="subtitle"><?php echo htmlspecialchars($subtitle); ?></p>

    <?php if (!$isError): ?>
        <div class="message demo-message">
            <span class="message-label">Verification Code</span>
            <strong class="demo-code"><?php echo htmlspecialchars((string)$code); ?></strong><br><br>
        </div>

        <div class="action-stack">
            <a class="login-button action-link" href="verify_code.php">Continue</a>
        </div>
    <?php else: ?>
        <div class="message error-message">
            Please return to the login page and try again.
        </div>

        <div class="action-stack">
            <a class="login-button action-link" href="login.php">Return to Login</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>