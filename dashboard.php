<?php
declare(strict_types=1);
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
    <title>Student Notes Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="dashboard-header-top">
                <div class="dashboard-title">
                    <h1>Dashboard</h1>
                    <p>Welcome back. Select a class to open your notes.</p>
                </div>
                <a href="logout.php" class="log-out-link">Logout</a>
            </div>
        </header>

        <main class="canvas-grid">
            <a href="classes.php" class="canvas-card">
                <h2>COMP 3305</h2>
                <p>Class Description</p>
                <span>Open class</span>
            </a>

            <a href="classes.php" class="canvas-card">
                <h2>COMP 2419</h2>
                <p>Class Description</p>
                <span>Open class</span>
            </a>

            <a href="classes.php" class="canvas-card">
                <h2>COMP 2413</h2>
                <p>Class Description</p>
                <span>Open class</span>
            </a>

            <a href="classes.php" class="canvas-card">
                <h2>COMP 3995</h2>
                <p>Class Description</p>
                <span>Open class</span>
            </a>

            <a href="classes.php" class="canvas-card">
                <h2>COMP 3322</h2>
                <p>Class Description</p>
                <span>Open class</span>
            </a>
        </main>
    </div>

</body>
</html>
