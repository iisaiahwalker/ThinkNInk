<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$course_id = $_GET['course_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shared Notes</title>
    <link rel="stylesheet" href="../classes/classes.css">
</head>

<body>

<h1>Shared Class Notes</h1>

<div id="sharedContainer"></div>

<script>
const COURSE_ID = "<?php echo $course_id; ?>";

fetch("../api/notes/get_shared.php?course_id=" + COURSE_ID)
.then(res => res.json())
.then(data => {

    const container = document.getElementById("sharedContainer");

    data.forEach(note => {

        container.innerHTML += `
            <div class="card">
                <h3>${note.notes_name}</h3>
                <p>${note.chapter} - ${note.topic}</p>
                <p>Shared by: ${note.first_name} ${note.last_name}</p>

                <button onclick="copyNote(${note.private_notes_id})">
                    Download Copy
                </button>
            </div>
        `;
    });
});
</script>

<script>
function copyNote(noteId) {
    fetch("../api/notes/copy_shared.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            private_notes_id: noteId
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
}
</script>

</body>
</html>