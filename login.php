<?php
if (isset($_GET['error'])) {

    if ($_GET['error'] == "email") {
        echo "<p style='color:red;'>Email not found.</p>";
    }

    if ($_GET['error'] == "password") {
        echo "<p style='color:red;'>Incorrect password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Notes Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">
    <p class="brand">ThinkNInk</p>

    <h1>Student Notes</h1>
    <p class="subtitle">Sign in to your class workspace</p>

    <?php if (!empty($errorMessage)): ?>
        <div class="message error-message">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <!-- ✅ FIXED FORM -->
    <form action="process_login.php" method="POST">

        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="student@pvamu.edu" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="login-button">
            Enter Dashboard
        </button>

    </form>

</div>

</body>
</html>