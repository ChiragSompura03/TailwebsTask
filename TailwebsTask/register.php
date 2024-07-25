<?php

include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'];
    if (empty($csrfToken) || $csrfToken !== $_SESSION['csrf_token']) {
        echo 'Invalid CSRF token.';
        exit;
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id FROM teachers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Username already exists. Please choose a different one.';
        $stmt->close();
        exit;
    }

    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insertStmt = $conn->prepare("INSERT INTO teachers (username, password) VALUES (?, ?)");
    $insertStmt->bind_param("ss", $username, $hashedPassword);

    if ($insertStmt->execute()) {
        echo 'success';
    } else {
        echo 'Failed to register. Please try again later.';
    }

    $insertStmt->close();
} else {
    echo 'Invalid request method.';
}
