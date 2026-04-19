<?php
require_once "../db_connect.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$content = $data['content'] ?? null;
$note_id = $data['note_id'] ?? null;

if (!$content || !$note_id) {
    echo json_encode(["error" => "Invalid data"]);
    exit();
}

/* DEBUG: check length */
if (strlen($content) < 10) {
    echo json_encode(["error" => "Content too small"]);
    exit();
}

$stmt = $conn->prepare("
UPDATE Private_Notes 
SET content=? 
WHERE private_notes_id=?
");

$stmt->bind_param("si", $content, $note_id);

$success = $stmt->execute();

echo json_encode([
    "success" => $success,
    "length" => strlen($content)
]);
?>