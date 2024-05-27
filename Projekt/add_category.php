<?php
session_start();
require 'db.php'; 

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = validateInput($_POST['name']);
    $description = validateInput($_POST['description']);

    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    if ($stmt->execute([$name, $description])) {
        $_SESSION['message'] = 'Nowy dział został dodany.';
    } else {
        $_SESSION['message'] = 'Wystąpił błąd podczas dodawania nowego działu.';
    }

    header("Location: forum.php");
    exit;
}
?>
