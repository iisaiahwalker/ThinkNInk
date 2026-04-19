<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Shared Note</title>
    <link rel="stylesheet" href="../notes/editor.css">
</head>

<body>

<div class="toolbar">
    <button onclick="goBack()">⬅ Back</button>
</div>

<div id="viewer"></div>

<script>
const note_id = new URLSearchParams(window.location.search).get("note_id");

function goBack() {
    const params = new URLSearchParams(window.location.search);

    const course_id = params.get("course_id");
    const from = params.get("from");

    if (from === "shared") {
        window.location.href = `/ThinkNInk/classes/classes.php?course_id=${course_id}&tab=shared`;
    } else {
        window.location.href = `/ThinkNInk/classes/classes.php?course_id=${course_id}&tab=private`;
    }
}

async function load() {
    const res = await fetch(`/ThinkNInk/api/notes/get.php?id=${note_id}`);
    const data = await res.json();

    const note = data;

    document.getElementById("viewer").innerHTML = `
        <h2>${note.notes_name}</h2>
        <p><b>Chapter:</b> ${note.chapter || ""}</p>
        <p><b>Topic:</b> ${note.topic || ""}</p>
        <hr/>
        <pre style="white-space:pre-wrap;">${note.content}</pre>
    `;
}

load();
</script>

</body>
</html>