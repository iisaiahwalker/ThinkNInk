<?php
declare(strict_types=1);

require_once "db_connect.php";

function redirect(string $url): never {
    header("Location: $url");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect("forgot_password.php");
}

$email = strtolower(trim($_POST["email"] ?? ""));

if (
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !str_ends_with($email, "@pvamu.edu")
) {
    redirect("forgot_password.php?error=invalid_email");
}

$stmt = $conn->prepare("SELECT student_id FROM Students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$studentId = null;
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $studentId = $row["student_id"];
}
$stmt->close();

if ($studentId !== null) {
    $invalidate = $conn->prepare("
        UPDATE password_resets
        SET used = 1
        WHERE email = ? AND used = 0
    ");
    $invalidate->bind_param("s", $email);
    $invalidate->execute();
    $invalidate->close();

    $token = bin2hex(random_bytes(32));

    $insert = $conn->prepare("
        INSERT INTO password_resets (email, token, expiration)
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))
    ");
    $insert->bind_param("ss", $email, $token);
    $insert->execute();
    $insert->close();

    // DEV ONLY:
    error_log("Reset token for $email: $token");

    // In production, email the reset link instead
    // $resetLink = "https://yourdomain.com/reset_password.php?token=" . urlencode($token);
}

redirect("forgot_password.php?status=reset_requested");
