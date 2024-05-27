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
    $categoryId = validateInput($_POST['category_id']);

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare('DELETE FROM comments WHERE topic_id IN (SELECT id FROM topics WHERE category_id = ?)');
        $stmt->execute([$categoryId]);

        $stmt = $pdo->prepare('DELETE FROM topics WHERE category_id = ?');
        $stmt->execute([$categoryId]);

        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$categoryId]);

        $pdo->commit();

        $_SESSION['message'] = 'Kategoria została usunięta.';
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['message'] = 'Wystąpił błąd podczas usuwania kategorii: ' . $e->getMessage();
    }

    header("Location: forum.php");
    exit;
}
?>
