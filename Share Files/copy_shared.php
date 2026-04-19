<?php
session_start();
require_once "../db_connect.php";

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

$note_id = $data["note_id"] ?? null;
$student_id = $_SESSION["student_id"] ?? null;

if (!$note_id || !$student_id) {
    echo json_encode(["error" => "Invalid request"]);
    exit();
}

/*
CHECK ACCESS:
User must be in same course
*/
$check = $conn->prepare("
SELECT pn.*
FROM Private_Notes pn
JOIN Enrollment e ON pn.course_id = e.course_id
WHERE pn.private_notes_id = ?
AND e.student_id = ?
LIMIT 1
");

$check->bind_param("is", $note_id, $student_id);
$check->execute();

$result = $check->get_result();

if (!$result || $result->num_rows === 0) {
    echo json_encode(["error" => "Access denied"]);
    exit();
}

$note = $result->fetch_assoc();

/*
COPY NOTE (INCLUDING CONTENT)
*/
$insert = $conn->prepare("
INSERT INTO Private_Notes
(notes_name, student_id, course_id, chapter, topic, content)
VALUES (?, ?, ?, ?, ?, ?)
");

$insert->bind_param(
    "ssssss",
    $note["notes_name"],
    $student_id,
    $note["course_id"],
    $note["chapter"],
    $note["topic"],
    $note["content"]
);

$insert->execute();

echo json_encode(["success" => true]);
?>