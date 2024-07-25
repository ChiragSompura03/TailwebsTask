<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $subject = trim($_POST['subject']);
    $marks = (int)$_POST['marks'];

    $stmt = $conn->prepare("SELECT id, marks FROM students WHERE name = ? AND subject = ?");
    $stmt->bind_param("ss", $name, $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $newMarks = $student['marks'] + $marks;

        $updateStmt = $conn->prepare("UPDATE students SET marks = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $newMarks, $student['id']);

        if ($updateStmt->execute()) {
            echo 'success';
        } else {
            echo 'Failed to update student marks.';
        }
    } else {
        $insertStmt = $conn->prepare("INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)");
        $insertStmt->bind_param("ssi", $name, $subject, $marks);

        if ($insertStmt->execute()) {
            echo 'success';
        } else {
            echo 'Failed to add student.';
        }
    }
}
