<?php
declare(strict_types=1);

session_start();
require_once "db_connect.php";

function redirect(string $url): never {
    header("Location: $url");
    exit();
}

$loginPage = "login.php";
$verifyPage = "verify_code.php";

if (empty($_SESSION["pending_email"]) || empty($_SESSION["pending_student_id"])) {
    redirect($loginPage);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect($verifyPage);
}

$enteredCode = $_POST["code"] ?? "";

if (!preg_match('/^\d{6}$/', $enteredCode)) {
    redirect($verifyPage . "?error=Invalid+code+format.");
}

$email = $_SESSION["pending_email"];
$pendingStudentId = $_SESSION["pending_student_id"];
$code = (int)$enteredCode;

$stmt = $conn->prepare("
    SELECT student_id
    FROM Students
    WHERE student_id = ?
      AND email = ?
      AND verification_code = ?
      AND code_expiration > NOW()
");
$stmt->bind_param("isi", $pendingStudentId, $email, $code);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows !== 1) {
    redirect($verifyPage . "?error=Invalid+or+expired+code.");
}

$clear = $conn->prepare("
    UPDATE Students
    SET verification_code = NULL,
        code_expiration = NULL
    WHERE email = ?
");
$clear->bind_param("s", $email);
$clear->execute();
$clear->close();

session_regenerate_id(true);
$_SESSION["student_id"] = $pendingStudentId;
$_SESSION["email"] = $email;

unset($_SESSION["pending_email"], $_SESSION["pending_student_id"]);

redirect("dashboard.php");
