<?php
require_once "../db_connect.php";
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$note_id = $data["note_id"];
$student_id = $_SESSION["student_id"];

// prevent duplicates
$check = $conn->prepare("
SELECT class_notes_id 
FROM Class_Notes 
WHERE private_notes_id = ? AND student_id = ?
");

$check->bind_param("is", $note_id, $student_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows === 0) {

    $stmt = $conn->prepare("
    INSERT INTO Class_Notes (private_notes_id, student_id)
    VALUES (?, ?)
    ");

    $stmt->bind_param("is", $note_id, $student_id);
    $stmt->execute();
}

echo json_encode(["success" => true]);


echo json_encode(["success" => true, "message" => "Shared"]);