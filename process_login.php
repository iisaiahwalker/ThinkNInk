<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (substr($email, -10) !== "@pvamu.edu") {
        die("Only PVAMU email addresses are allowed.");
    }

    $sql = "SELECT * FROM Students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();

        if (md5($password) === $student["password"]) {

            //  Generate 6-digit code
            $code = rand(100000, 999999);

            //  Save code in database
            $update = $conn->prepare("
                UPDATE Students 
                SET verification_code = ?, 
                    code_expiration = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                WHERE email = ?
            ");
            $update->bind_param("ss", $code, $email);
            $update->execute();

            $_SESSION["email"] = $email;

            // TEMP (for demo)
            echo "Verification Code: " . $code;
            echo "<br><a href='verify_code.php'>Continue</a>";
            exit();

        } else {
            echo "Incorrect password.";
        }

    } else {
        echo "No account found.";
    }
}
?>
