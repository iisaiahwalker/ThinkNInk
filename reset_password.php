<?php
declare(strict_types=1);

session_start();

$token = trim($_GET["token"] ?? "");

if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
    header("Location: forgot_password.php");
    exit();
}

$error = $_SESSION["reset_error"] ?? "";
unset($_SESSION["reset_error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>

<h2>Reset Your Password</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<form action="process_reset_password.php" method="POST">
    <input
        type="hidden"
        name="token"
        value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>"
    >

    <input
        type="password"
        name="new_password"
        placeholder="New Password"
        required
        minlength="8"
    >
    <br><br>

    <input
        type="password"
        name="confirm_password"
        placeholder="Confirm Password"
        required
        minlength="8"
    >
    <br><br>

    <button type="submit">Reset Password</button>
</form>

</body>
</html>
