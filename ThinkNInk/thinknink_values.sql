-- ---------------------------------------------------------------------------------------------------------
-- Thinknink Inserted values
-- PVAMU used as reference institution for test data only.
-- ---------------------------------------------------------------------------------------------------------

-- ------------------------------------------------------------------
-- Passwords are MD5 hashed. Plain text for testing:
-- A00123456 → Jordan@26  |  A00234567 → Maya@26
-- A00345678 → Devon@26   |  A00456789 → Aaliyah@26
-- A00567890 → Marcus@26
-- ------------------------------------------------------------------
INSERT INTO Students (student_id, first_name, last_name, email,phone_number, password) VALUES
    ('A00123456', 'Jordan',  'Hayes',   'jhayes@students.pvamu.edu', '9362611042',  'b13d881831d9b349355e9e785d336788'),
    ('A00234567', 'Maya',    'Collins', 'mcollins@students.pvamu.edu','7134489021', '5b3051caf90d7dc5df698037050f6afb'),
    ('A00345678', 'Devon',   'Brooks',  'dbrooks@students.pvamu.edu', '2813308004', '304d9ed1cd7d5786748759ebd2add7ed'),
    ('A00456789', 'Aaliyah', 'Turner',  'aturner@students.pvamu.edu', '9364729301',  'f9615ea2f1b4943e6f057339be3dcf1a'),
    ('A00567890', 'Marcus',  'Reed',    'mreed@students.pvamu.edu',    '8325557718',   '3101770976728646d0152cb0b9c82691');

INSERT INTO Courses (course_id, course_name, section_number, semester, occupancy) VALUES
    ('COSC1301-001', 'Introduction to Computer Science', '001', 'Spring 2026', 35),
    ('COSC3311-002', 'Database Management',              '002', 'Spring 2026', 30),
    ('MATH1401-001', 'Calculus I',                       '001', 'Spring 2026', 40),
    ('COSC3321-003', 'Operating Systems',                '003', 'Spring 2026', 25);
-- -----------------------------------------------------------------------------------
-- Example 
-- Jordan  → Intro Introduction to Computer Science, Database Management, Calculus I
-- Maya    → Intro Introduction to Computer Science, Operating Systems
-- Devon   → Database Management, Calculus I
-- Aaliyah → Intro Introduction to Computer Science, Database Management, Operating Systems
-- Marcus  → Calculus I, Operating Systems
-- -------------------------------------------------------------------------------------------
INSERT INTO Enrollment (student_id, course_id) VALUES
    ('A00123456', 'COSC1301-001'),
    ('A00123456', 'COSC3311-002'),
    ('A00123456', 'MATH1401-001'),
    ('A00234567', 'COSC1301-001'),
    ('A00234567', 'COSC3321-003'),
    ('A00345678', 'COSC3311-002'),
    ('A00345678', 'MATH1401-001'),
    ('A00456789', 'COSC1301-001'),
    ('A00456789', 'COSC3311-002'),
    ('A00456789', 'COSC3321-003'),
    ('A00567890', 'MATH1401-001'),
    ('A00567890', 'COSC3321-003');

INSERT INTO Tests (course_id, test_name, chapter, topic) VALUES
    ('COSC1301-001', 'Midterm 1',  'Chapter 3', 'Loops and Conditionals'),
    ('COSC1301-001', 'Midterm 2',  'Chapter 5', 'Functions and Recursion'),
    ('COSC1301-001', 'Final Exam', 'Chapter 7', 'Arrays and Strings'),
    ('COSC3311-002', 'Quiz 1',     'Chapter 1', 'Relational Model'),
    ('COSC3311-002', 'Midterm',    'Chapter 3', 'SQL Queries'),
    ('COSC3311-002', 'Final Exam', 'Chapter 5', 'Normalization'),
    ('MATH1401-001', 'Exam 1',     'Chapter 2', 'Limits and Derivatives'),
    ('MATH1401-001', 'Exam 2',     'Chapter 4', 'Integration'),
    ('COSC3321-003', 'Midterm',    'Chapter 2', 'Process Management'),
    ('COSC3321-003', 'Final Exam', 'Chapter 5', 'Memory Management');

INSERT INTO Private_Notes (notes_name, student_id, course_id, chapter, topic, content, created_date, updated_date) VALUES
    ('Loops Overview',           'A00123456', 'COSC1301-001', 'Chapter 3', 'Loops and Conditionals',
     'A loop repeats a block of code. Types: for, while, do-while. Use for when iterations are known, while when condition-based.',
     '2026-01-15 09:00:00', '2026-01-20 11:00:00'),
    ('Recursion Notes',          'A00123456', 'COSC1301-001', 'Chapter 5', 'Functions and Recursion',
     'Recursion is a function calling itself. Must have a base case to stop. Example: factorial(n) = n * factorial(n-1).',
     '2026-02-01 10:00:00', '2026-02-01 10:00:00'),
    ('Arrays and Strings Summary','A00123456', 'COSC1301-001', 'Chapter 7', 'Arrays and Strings',
     'Arrays store elements of the same type at contiguous memory. Strings are char arrays. Index starts at 0. Use loops to traverse.',
     '2026-03-05 08:00:00', '2026-03-07 09:30:00'),
    ('Relational Model Notes',   'A00123456', 'COSC3311-002', 'Chapter 1', 'Relational Model',
     'Data stored in tables (relations). Each row is a tuple, each column an attribute. Primary key uniquely identifies rows.',
     '2026-01-18 08:30:00', '2026-01-22 09:00:00'),
    ('SQL SELECT Basics',        'A00123456', 'COSC3311-002', 'Chapter 3', 'SQL Queries',
     'SELECT col FROM table WHERE condition ORDER BY col. Use JOIN to combine tables on matching keys.',
     '2026-02-10 14:00:00', '2026-02-12 15:00:00'),
    ('Normalization Guide',      'A00123456', 'COSC3311-002', 'Chapter 5', 'Normalization',
     '1NF: no repeating groups. 2NF: no partial dependencies. 3NF: no transitive dependencies. Goal is to reduce redundancy.',
     '2026-03-01 11:00:00', '2026-03-03 12:00:00'),
    ('CS Intro Summary',         'A00234567', 'COSC1301-001', 'Chapter 3', 'Loops and Conditionals',
     'Conditionals control flow with if/else. Loops automate repetition. Both are fundamental control structures.',
     '2026-01-16 10:00:00', '2026-01-16 10:00:00'),
    ('Functions Study Notes',    'A00234567', 'COSC1301-001', 'Chapter 5', 'Functions and Recursion',
     'Functions take input (parameters) and return output. Recursion breaks a problem into smaller sub-problems with a base case.',
     '2026-02-03 09:00:00', '2026-02-04 10:00:00'),
    ('Process Management Overview','A00234567','COSC3321-003', 'Chapter 2', 'Process Management',
     'A process is a program in execution. States: new, ready, running, waiting, terminated. PCB stores process info.',
     '2026-02-14 13:00:00', '2026-02-15 14:00:00'),
    ('DB Keys and Constraints',  'A00345678', 'COSC3311-002', 'Chapter 1', 'Relational Model',
     'Primary key: unique, not null. Foreign key: references PK in another table. Unique constraint: no duplicate values.',
     '2026-01-19 11:00:00', '2026-01-25 12:00:00'),
    ('SQL Joins and Subqueries', 'A00345678', 'COSC3311-002', 'Chapter 3', 'SQL Queries',
     'INNER JOIN returns matching rows. LEFT JOIN returns all left rows. Subquery is a query inside a query used in WHERE or FROM.',
     '2026-02-11 09:00:00', '2026-02-13 10:00:00'),
    ('Derivatives Study Guide',  'A00345678', 'MATH1401-001', 'Chapter 2', 'Limits and Derivatives',
     'Derivative measures rate of change. Power rule: d/dx(x^n) = nx^(n-1). Chain rule for composite functions.',
     '2026-02-05 09:00:00', '2026-02-06 10:00:00'),
    ('Integration Techniques',   'A00345678', 'MATH1401-001', 'Chapter 4', 'Integration',
     'Integration is the reverse of differentiation. Substitution method: replace u = g(x). Integration by parts: uv - integral(v du).',
     '2026-03-10 08:30:00', '2026-03-11 09:00:00'),
    ('Memory Management Notes',  'A00567890', 'COSC3321-003', 'Chapter 5', 'Memory Management',
     'OS manages RAM allocation. Paging divides memory into fixed-size pages. Segmentation uses variable sizes. Virtual memory extends RAM using disk.',
     '2026-03-08 10:00:00', '2026-03-09 11:00:00'),
    ('Calculus Limits Review',   'A00567890', 'MATH1401-001', 'Chapter 2', 'Limits and Derivatives',
     'Limit is the value a function approaches. L Hospital rule: use when 0/0 or inf/inf. Continuity requires limit = function value.',
     '2026-02-07 14:00:00', '2026-02-08 15:00:00');

INSERT INTO Class_Notes (private_notes_id, student_id, shared_date) VALUES
    (1,  'A00123456', '2026-01-21 12:00:00'),
    (4,  'A00123456', '2026-01-23 08:00:00'),
    (5,  'A00123456', '2026-02-13 10:00:00'),
    (7,  'A00234567', '2026-01-17 11:00:00'),
    (9,  'A00234567', '2026-02-16 09:00:00'),
    (10, 'A00345678', '2026-01-26 09:00:00'),
    (12, 'A00345678', '2026-02-07 10:00:00'),
    (13, 'A00345678', '2026-03-12 08:00:00'),
    (14, 'A00567890', '2026-03-10 13:00:00'),
    (15, 'A00567890', '2026-02-09 11:00:00');
