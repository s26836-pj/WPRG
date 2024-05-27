<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'administrator' && $_SESSION['role'] !== 'moderator')) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topicId = validateInput($_POST['topic_id']); // użyj 'topic_id' zamiast 'thread_id'
    $categoryId = validateInput($_POST['category_id']);

    $stmt = $pdo->prepare("DELETE FROM comments WHERE topic_id = ?");
    $stmt->execute([$topicId]);

    $stmt = $pdo->prepare("DELETE FROM topics WHERE id = ?");
    if ($stmt->execute([$topicId])) {
        $_SESSION['message'] = "Wątek został usunięty.";
        header("Location: category.php?id=" . $categoryId);
        exit();
    } else {
        $_SESSION['message'] = "Błąd podczas usuwania wątku.";
        header("Location: category.php?id=" . $categoryId);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Usuń wątek</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Usuń wątek</h1>
        <form action="delete_thread.php" method="post">
            <input type="hidden" name="topic_id" value="<?= htmlspecialchars($_GET['id']) ?>"> <!-- zmiana z 'thread_id' na 'topic_id' -->
            <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id']) ?>">
            <p>Czy na pewno chcesz usunąć ten wątek?</p>
            <input type="submit" value="Usuń">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
