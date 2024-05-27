<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = validateInput($_POST['comment_id']);
    $topicId = validateInput($_POST['topic_id']);

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    if ($stmt->execute([$commentId])) {
        $_SESSION['message'] = "Komentarz został usunięty.";
        header("Location: topic.php?id=" . $topicId);
        exit();
    } else {
        echo "Błąd podczas usuwania komentarza.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Usuń komentarz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Usuń komentarz</h1>
        <form action="delete_comment.php" method="post">
            <input type="hidden" name="comment_id" value="<?= htmlspecialchars($_GET['id']) ?>">
            <input type="hidden" name="topic_id" value="<?= htmlspecialchars($_GET['topic_id']) ?>">
            <p>Czy na pewno chcesz usunąć ten komentarz?</p>
            <input type="submit" value="Usuń">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
