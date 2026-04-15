<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host   = "localhost";
$db_user = "root";
$db_pass = "";
$dbname = "thinknink";

try {
    $conn = new mysqli($host, $db_user, $db_pass, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log("DB connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}
