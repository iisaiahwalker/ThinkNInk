# ThinkNInk

ThinkNInk is a smart digital note-taking and study guide platform built with PHP, MySQL, JavaScript, HTML, and CSS.  
It allows students to create visual notes (text, shapes, drawings), share notes, and automatically generate study guides based on filtered content.

---

## System Overview

ThinkNInk is built as a full-stack PHP web application running on XAMPP (Apache + MySQL).

### Core Architecture:
- **Frontend:** HTML, CSS, Vanilla JavaScript
- **Backend:** PHP (REST-style API endpoints)
- **Database:** MySQL (via phpMyAdmin)
- **Server Environment:** XAMPP (Apache + MySQL)

### Key Modules:
-  Private Notes System
-  Shared Notes System
-  Study Guide Generator (Smart Filtering)
-  Visual Note Editor (text, shapes, pen tool, images)
-  Flashcard-style Test Viewer

---

## Features

###  Notes System
- Create, edit, and delete notes
- Add chapter + topic metadata
- Supports multiple pages per note
- Store structured canvas data (JSON format)

---

###  Visual Canvas Editor Support
- Text boxes
- Shapes (rectangles, circles, triangles)
- Freehand pen drawing tool
- Image placement
- Multi-element page system

---

###  Shared Notes
- Share notes across users
- View notes from classmates
- Copy shared notes into personal workspace

---

###  Study Guides (Smart Filtering)
- Generate study guides from:
  - Note title
  - Chapter
  - Topic
  - Note content (text inside canvas)
- Aggregates multiple notes/pages into one test
- Flashcard-style viewer

---

###  Smart Test Viewer
- Navigate through study guide cards
- Each card represents:
  - Different notes
  - Different pages per note
- Canvas preview renderer for study material

---

###  Smart Search / Filter Engine
- Searches inside:
  - Note title
  - Chapter
  - Topic
  - Canvas text content
- Returns aggregated results for study guides

---

##  Project Structure
ThinkNInk/

│

├── api/ 
  └── courses/
    └── get_courses.php
  └── notes/ # Notes CRUD APIs
    └──copy_shared.php
    └──create.php
    └──delete.php
    └──get.php
    └──get_all.php
    └──get_shared.php
    └──share.php
    └──unshare.php
    └──update.php
  └── tests/ # Study guide APIs
    └──create_test.php
    └──delete_test.php
    └──get_tests.php
    └──smart_filter_notes.php
  └── db_connect.php

├── assests/ 
  └── uploads/
  └── style.css

├── auth/ # Login & authentication 
  └──forgot_password.php
  └──login.php
  └──logout.php
  └──process_forget_password.php
  └──process_login.php
  └──process_reset_password.php
  └──process_verification.php
  └──reset_password.php
  └──verify_code.php

├── classes/ # Class interface (main UI)
  └──classes.css
  └──classes.php

├── dashboard/ # Class dashboard
  └──dashboard.css
  └──dashboard.php

|── database/ 
  └──thinknink_tables.sql
  └──thinknink_values.sql

├── notes/ # Note editor + snapshots 
  └──editor.css
  └──editor.js
  └──export
  └──note_editor
  └──notes_snapshot
  └──shared_notes
  └──view_shared

└── index.php


---

## Installation Guide (XAMPP Setup)

### 1. Install XAMPP
Download and install:
- https://www.apachefriends.org/

Make sure these services are running:
-  Apache
-  MySQL

---

### 2. Move Project into htdocs

Place the project folder here: 
C:\xampp\htdocs\
(make sure the folder is unzipped/extracted)


---

### 3. Create Database

Open: http://localhost/phpmyadmin

#### Create new database:
thinknink


---

### 4. Import Database Tables

- Go to **Import tab**
- Upload `.sql` file (which are located in database folder of zipped file)
- Click **Go**

---

### 5. Run Project

Open browser:
http://localhost/ThinkNInk/

(may have to go to http://localhost/ThinkNInk/index.php)





