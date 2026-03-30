<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Notes Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">
    <p class="brand">ThinkNInk</p>

    <h1>Student Notes</h1>
    <p class="subtitle">Sign in to your class workspace.</p>

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
