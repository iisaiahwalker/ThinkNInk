<?php
require_once "../db_connect.php";
session_start();

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'] ?? null;
$student_id = $_SESSION['student_id'] ?? null;

if (!$id || !$student_id) {
    echo json_encode(["error" => "Invalid request"]);
    exit();
}

/*
ALLOW:
- owner
- OR same course via Enrollment table
*/
$stmt = $conn->prepare("
SELECT pn.*
FROM Private_Notes pn
JOIN Enrollment e ON pn.course_id = e.course_id
WHERE pn.private_notes_id = ?
AND (
    pn.student_id = ?
    OR e.student_id = ?
)
LIMIT 1
");

$stmt->bind_param("iss", $id, $student_id, $student_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Note not found or access denied"]);
}
?>