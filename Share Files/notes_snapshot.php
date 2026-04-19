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
    <title>View Note</title>
    <link rel="stylesheet" href="../notes/editor.css">
</head>

<body>

<div class="toolbar">
    <button onclick="goBack()">⬅ Back</button>
</div>

<div id="canvas"></div>

<script>
const note_id = new URLSearchParams(window.location.search).get("note_id");
const course_id = new URLSearchParams(window.location.search).get("course_id");

function goBack() {
    if (course_id) {
        window.location.href = `/ThinkNInk/classes/classes.php?course_id=${course_id}&tab=shared`;
    } else {
        window.location.href = `/ThinkNInk/classes/classes.php?tab=shared`;
    }
}
</script>

<script>
let doc = null;

async function loadNote() {
    try {
        const res = await fetch(`/ThinkNInk/api/notes/get.php?id=${note_id}`);
        const data = await res.json();

        console.log("API response:", data);

        if (!data || !data.content) {
            console.warn("No content:", data);
            return;
        }

        try {
            doc = JSON.parse(data.content);
            render();
        } catch (e) {
            console.error("Invalid JSON:", e, data.content);
        }

    } catch (err) {
        console.error("Failed to load note:", err);
    }
}

function render() {
    const canvas = document.getElementById("canvas");
    canvas.innerHTML = "";

    if (!doc) return;

    const page = doc.pages?.[doc.currentPage] || { elements: [] };

    console.log("ELEMENTS:", page.elements);

    if (!page.elements.length) {
        canvas.innerHTML = "<p style='padding:20px;'>Empty note</p>";
        return;
    }

    page.elements.forEach(el => {

        const div = document.createElement("div");
        div.style.position = "absolute";
        div.style.left = (el.x || 0) + "px";
        div.style.top = (el.y || 0) + "px";

        /*
        =====================
        TEXT
        =====================
        */
        if (el.type === "text") {
            div.innerText = el.text;
            div.style.whiteSpace = "pre-wrap";
            div.style.color = "#2a1748";
        }

        /*
        =====================
        SHAPES
        =====================
        */
        if (el.type === "shape") {

            div.style.width = (el.w || 0) + "px";
            div.style.height = (el.h || 0) + "px";
            div.style.background = "#b98aff";

            if (el.shape === "circle") {
                div.style.borderRadius = "50%";
            }

            if (el.shape === "triangle") {
                div.style.width = "0";
                div.style.height = "0";
                div.style.borderLeft = `${(el.w || 0) / 2}px solid transparent`;
                div.style.borderRight = `${(el.w || 0) / 2}px solid transparent`;
                div.style.borderBottom = `${el.h || 0}px solid #b98aff`;
                div.style.background = "transparent";
            }

            if (el.text) {
                const textDiv = document.createElement("div");
                textDiv.innerText = el.text;
                textDiv.style.position = "absolute";
                textDiv.style.top = "50%";
                textDiv.style.left = "50%";
                textDiv.style.transform = "translate(-50%, -50%)";
                textDiv.style.color = "#fff";
                div.appendChild(textDiv);
            }
        }

        /*
        =====================
        IMAGE
        =====================
        */
        if (el.type === "image") {
            const img = document.createElement("img");
            img.src = el.src;
            img.style.width = (el.w || 100) + "px";
            img.style.height = "auto";
            div.appendChild(img);
        }

        /*
        =====================
        PEN DRAWING
        =====================
        */
        if (el.type === "pen") {

            const canvasEl = document.createElement("canvas");
            const ctx = canvasEl.getContext("2d");

            canvasEl.width = 2000;
            canvasEl.height = 2000;

            ctx.strokeStyle = "#2a1748";
            ctx.lineWidth = 2;
            ctx.lineJoin = "round";
            ctx.lineCap = "round";

            let points = [];

            if (Array.isArray(el.points)) points = el.points;
            else if (Array.isArray(el.path)) points = el.path;
            else if (Array.isArray(el.stroke)) points = el.stroke;

            if (!points.length) return;

            ctx.beginPath();

            points.forEach((p, i) => {
                const x = p.x ?? p[0] ?? 0;
                const y = p.y ?? p[1] ?? 0;

                if (i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });

            ctx.stroke();

            div.appendChild(canvasEl);
        }

        canvas.appendChild(div);
    });
}

loadNote();
</script>

</body>
</html>