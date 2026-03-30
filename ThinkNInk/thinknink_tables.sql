--  ThinkNInk database Tables 
--  Run the thinknink_tables.sql, then thinknink_values.sql
--------------------------------------------------------------------

DROP DATABASE IF EXISTS ThinkNInk;
CREATE DATABASE ThinkNInk;
USE ThinkNInk;

-- password stores MD5 hash — never plain text
CREATE TABLE Students (
    student_id   VARCHAR(10)  PRIMARY KEY,
    first_name   VARCHAR(50)  NOT NULL,
    last_name    VARCHAR(50)  NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    password     VARCHAR(32)  NOT NULL
);

CREATE TABLE Courses (
    course_id      VARCHAR(20)  PRIMARY KEY,
    course_name    VARCHAR(100) NOT NULL,
    section_number VARCHAR(10)  NOT NULL,
    semester       VARCHAR(20)  NOT NULL,
    occupancy      INTEGER      NOT NULL CHECK (occupancy > 0)
);

CREATE TABLE Enrollment (
    enrollment_id INTEGER     PRIMARY KEY AUTO_INCREMENT,
    student_id    VARCHAR(10) NOT NULL,
    course_id     VARCHAR(20) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id)  REFERENCES Courses(course_id)  ON DELETE CASCADE,
    UNIQUE (student_id, course_id)
);

-- chapter and topic must be filled in for the filter feature to work
-- updated_date is handled automatically by the trigger below
CREATE TABLE Private_Notes (
    private_notes_id INTEGER      PRIMARY KEY AUTO_INCREMENT,
    notes_name       VARCHAR(150) NOT NULL,
    student_id       VARCHAR(10)  NOT NULL,
    course_id        VARCHAR(20)  NOT NULL,
    chapter          VARCHAR(50),
    topic            VARCHAR(100),
    content          TEXT,
    created_date     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_date     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id)  REFERENCES Courses(course_id)  ON DELETE CASCADE
);

-- stores a reference to the original note — not a copy of the content
CREATE TABLE Class_Notes (
    class_notes_id   INTEGER     PRIMARY KEY AUTO_INCREMENT,
    private_notes_id INTEGER     NOT NULL,
    student_id       VARCHAR(10) NOT NULL,
    shared_date      DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (private_notes_id) REFERENCES Private_Notes(private_notes_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id)       REFERENCES Students(student_id)            ON DELETE CASCADE
);

-- chapter and topic matched against Private_Notes to filter notes
CREATE TABLE Tests (
    test_id   INTEGER      PRIMARY KEY AUTO_INCREMENT,
    course_id VARCHAR(20)  NOT NULL,
    test_name VARCHAR(100) NOT NULL,
    chapter   VARCHAR(50),
    topic     VARCHAR(100),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id) ON DELETE CASCADE
);

CREATE INDEX idx_enrollment_student  ON Enrollment(student_id);
CREATE INDEX idx_enrollment_course   ON Enrollment(course_id);
CREATE INDEX idx_privnotes_student   ON Private_Notes(student_id);
CREATE INDEX idx_privnotes_course    ON Private_Notes(course_id);
CREATE INDEX idx_privnotes_chapter   ON Private_Notes(chapter);
CREATE INDEX idx_privnotes_topic     ON Private_Notes(topic);
CREATE INDEX idx_classnotes_privnote ON Class_Notes(private_notes_id);
CREATE INDEX idx_classnotes_student  ON Class_Notes(student_id);
CREATE INDEX idx_tests_course        ON Tests(course_id);

-- Trigger 
-- auto-updates updated_date on every Private_Notes edit
-- do NOT manually set updated_date in PHP UPDATE queries
DELIMITER $$
CREATE TRIGGER trg_update_note_timestamp
BEFORE UPDATE ON Private_Notes
FOR EACH ROW
BEGIN
    SET NEW.updated_date = NOW();
END$$
DELIMITER ;

-- Views 
-- Enrolled courses per student — powers the class dashboard

CREATE VIEW View_Student_Dashboard AS
SELECT
    e.student_id,
    c.course_id,
    c.course_name,
    c.section_number,
    c.semester,
    c.occupancy
FROM Enrollment e
JOIN Courses c ON e.course_id = c.course_id;

-- Shared notes per course with student info and note content
CREATE VIEW View_Class_Notes AS
SELECT
    cn.class_notes_id,
    cn.shared_date,
    pn.private_notes_id,
    pn.notes_name,
    pn.chapter,
    pn.topic,
    pn.content,
    pn.course_id,
    s.student_id,
    s.first_name,
    s.last_name
FROM Class_Notes cn
JOIN Private_Notes pn ON cn.private_notes_id = pn.private_notes_id
JOIN Students s       ON cn.student_id = s.student_id;

-- Student notes matched to a test by chapter and topic — powers note filtering
CREATE VIEW View_Test_Filter AS
SELECT
    t.test_id,
    t.test_name,
    t.course_id,
    pn.private_notes_id,
    pn.notes_name,
    pn.chapter,
    pn.topic,
    pn.content,
    pn.student_id,
    pn.updated_date
FROM Tests t
JOIN Private_Notes pn
    ON  pn.chapter   = t.chapter
    AND pn.topic     = t.topic
    AND pn.course_id = t.course_id;
