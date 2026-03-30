<?php
session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThinkNInk Dashboard</title>
</head>
<body>

<h2>Welcome to ThinkNInk</h2>
<p>You are logged in as <?php echo $_SESSION["email"]; ?></p>

<a href="logout.php">Logout</a>

</body>
</html>
