<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Login</title>
</head>
<body>

<h2>Enter Verification Code</h2>

<form action="process_verification.php" method="POST">
    <input type="text" name="code" placeholder="6-digit code" required>
    <button type="submit">Verify</button>
</form>

</body>
</html>
