<?php
declare(strict_types=1);

session_start();
require_once "db_connect.php";

function redirect(string $url): never {
    header("Location: $url");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect("forgot_password.php");
}

$token = trim($_POST["token"] ?? "");
$newPassword = $_POST["new_password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
    $_SESSION["reset_error"] = "Invalid or expired reset link.";
    redirect("forgot_password.php");
}

if (strlen($newPassword) < 8) {
    $_SESSION["reset_error"] = "Password must be at least 8 characters.";
    redirect("reset_password.php?token=" . urlencode($token));
}

if ($newPassword !== $confirmPassword) {
    $_SESSION["reset_error"] = "Passwords do not match.";
    redirect("reset_password.php?token=" . urlencode($token));
}

$stmt = $conn->prepare("
    SELECT email
    FROM password_resets
    WHERE token = ?
      AND used = 0
      AND expiration > NOW()
    LIMIT 1
");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows !== 1) {
    $_SESSION["reset_error"] = "Invalid or expired reset link.";
    redirect("forgot_password.php");
}

$reset = $result->fetch_assoc();
$email = $reset["email"];

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$update = $conn->prepare("
    UPDATE Students
    SET password = ?
    WHERE email = ?
");
$update->bind_param("ss", $hashedPassword, $email);
$update->execute();

if ($update->errno) {
    $update->close();
    $_SESSION["reset_error"] = "Unable to reset password. Please try again.";
    redirect("forgot_password.php");
}

if ($update->affected_rows === 0) {
    $update->close();
    $_SESSION["reset_error"] = "Account not found. Please request a new reset.";
    redirect("forgot_password.php");
}

$update->close();

$invalidate = $conn->prepare("
    UPDATE password_resets
    SET used = 1
    WHERE token = ?
");
$invalidate->bind_param("s", $token);
$invalidate->execute();
$invalidate->close();

$purge = $conn->prepare("
    UPDATE password_resets
    SET used = 1
    WHERE email = ? AND used = 0
");
$purge->bind_param("s", $email);
$purge->execute();
$purge->close();

$_SESSION["login_success"] = "Password reset successfully. Please log in.";
redirect("login.php");
