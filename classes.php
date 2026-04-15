<?php
session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION["first_name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThinkNInk Canvas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="classes.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo">ThinkNInk</div>

            <nav class="nav-menu">
                <a href="dashboard.php" class="nav-item">All Classes</a>
                <a href="#" class="nav-item">Private Notes</a>
                <a href="#" class="nav-item">Shared Notes</a>
                <a href="#" class="nav-item">Study Guides</a>
            </nav>

            <div class="sidebar-footer">
                <a href="login.php" class="log-out-link">Log out</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h1>Welcome <?php echo($firstName); ?></h1>
                <button class="new-note-btn">+ New Note</button>
            </header>

            <section class="canvas-area">
                <div class="card">
                    <div class="card-header">
                        <h2>Notes</h2>
                        <div class="card-actions">
                            <button class="action-btn edit-note">Edit</button>
                            <button class="action-btn delete-note">Delete</button>
                        </div>
                    </div>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates tempore veniam assumenda temporibus necessitatibus quod iusto deleniti quaerat voluptatem deserunt, suscipit, fugiat nobis, sed neque! Natus praesentium veritatis odit voluptatum?</p>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Notes</h2>
                        <div class="card-actions">
                            <button class="action-btn edit-note">Edit</button>
                            <button class="action-btn delete-note">Delete</button>
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In maxime praesentium blanditiis velit at esse similique ad quo nulla nostrum saepe explicabo, incidunt nihil accusamus laboriosam odio consequuntur quidem minus.</p>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Notes</h2>
                        <div class="card-actions">
                            <button class="action-btn edit-note">Edit</button>
                            <button class="action-btn delete-note">Delete</button>
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo distinctio deleniti repellat, excepturi sequi ratione omnis, rem totam quaerat tempore voluptatum molestiae praesentium quis numquam iste nam. Voluptates, quos itaque.</p>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Notes</h2>
                        <div class="card-actions">
                            <button class="action-btn edit-note">Edit</button>
                            <button class="action-btn delete-note">Delete</button>
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero fugit dolore, dolor neque cupiditate hic ipsa labore maxime molestias! Fugit veniam amet id totam officia earum ipsam at aliquam nam?</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
