<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Only allow PVAMU emails
    if (substr($email, -10) !== "@pvamu.edu") {
        die("Only PVAMU email addresses are allowed.");
    }

    $sql = "SELECT * FROM Students WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database error.");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();

        // TEMP: plain text password check (matches your current DB)
        if ($password === $student["password"]) {

            $_SESSION["student_id"] = $student["student_id"];
            $_SESSION["email"] = $student["email"];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "Incorrect password.";
        }

    } else {
        echo "No account found.";
    }

    $stmt->close();
    $conn->close();
}
?>
