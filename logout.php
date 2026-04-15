<?php
declare(strict_types=1);

session_start();

function redirect(string $url): never {
    header("Location: $url");
    exit();
}

// Clear session data
session_unset();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

redirect("login.php"); // update if your team's login page has a different name
