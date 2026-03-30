<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $enteredCode = trim($_POST["code"]);
    $email = $_SESSION["email"];

    $sql = "
        SELECT * FROM Students 
        WHERE email = ? 
        AND verification_code = ? 
        AND code_expiration > NOW()
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $enteredCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $student = $result->fetch_assoc();

        $_SESSION["student_id"] = $student["student_id"];

        header("Location: dashboard.php");
        exit();

    } else {
        echo "Invalid or expired code.";
    }
}
?>
