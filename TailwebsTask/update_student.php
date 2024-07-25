<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = (int)$_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $stmt = $conn->prepare("UPDATE students SET $field = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $studentId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Failed to update student.';
    }
}
