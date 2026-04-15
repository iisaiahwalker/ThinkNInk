<?php
declare(strict_types=1);
session_start();
require_once "db_connect.php";
function redirect(string $url): never {
    header("Location: $url");
    exit();
}
$loginPage = "login.php"; // change this if your team's UI uses a different file
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect($loginPage);
}
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$emailLower = strtolower($email);
if (
    !filter_var($emailLower, FILTER_VALIDATE_EMAIL) ||
    !str_ends_with($emailLower, "@pvamu.edu")
) {
    redirect($loginPage . "?error=Only+PVAMU+email+addresses+are+allowed.&email=" . urlencode($email));
}
$stmt = $conn->prepare("SELECT student_id, password FROM Students WHERE email = ?");
$stmt->bind_param("s", $emailLower);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    $stmt->close();
    redirect($loginPage . "?error=Invalid+email+or+password.&email=" . urlencode($email));
}
$student = $result->fetch_assoc();
$stmt->close();
if (!password_verify($password, $student["password"])) {
    redirect($loginPage . "?error=Invalid+email+or+password.&email=" . urlencode($email));
}
$code = random_int(100000, 999999);
$update = $conn->prepare("
    UPDATE Students
    SET verification_code = ?,
        code_expiration = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
    WHERE email = ?
");
$update->bind_param("is", $code, $emailLower);
$update->execute();
$update->close();
session_regenerate_id(true);
$_SESSION["pending_email"] = $emailLower;
$_SESSION["pending_student_id"] = $student["student_id"];
// TODO: Send verification code to email in production
// error_log("Verification code for $emailLower: $code");
redirect("verify_code.php");
