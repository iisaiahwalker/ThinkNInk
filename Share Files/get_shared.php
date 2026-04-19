<?php
session_start();
include("../db_connect.php");

$course_id = $_GET["course_id"];

/* USE YOUR VIEW */
$sql = "
SELECT *
FROM View_Class_Notes
WHERE course_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $course_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>