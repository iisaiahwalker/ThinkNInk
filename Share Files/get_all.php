<?php
require_once "../db_connect.php";
session_start();

$student_id = $_SESSION["student_id"] ?? null;
$course_id = $_GET["course_id"] ?? null;

if (!$student_id || !$course_id) {
    echo json_encode([]);
    exit();
}

$sql = "
SELECT 
    pn.private_notes_id,
    pn.notes_name,
    pn.chapter,
    pn.topic,
    pn.content,
    cn.class_notes_id
FROM Private_Notes pn
LEFT JOIN Class_Notes cn 
    ON pn.private_notes_id = cn.private_notes_id
    AND cn.student_id = ?
WHERE pn.student_id = ?
AND pn.course_id = ?
ORDER BY pn.created_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $student_id, $student_id, $course_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>