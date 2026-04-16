<?php
declare(strict_types=1);
session_start();

function redirect(string $url): never {
    header("Location: $url");
    exit();
}

session_unset();

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

session_destroy();
redirect("login.php");