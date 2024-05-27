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
    $content = validateInput($_POST['content']);

    $stmt = $pdo->prepare("UPDATE comments SET content = ? WHERE id = ?");
    if ($stmt->execute([$content, $commentId])) {
        $_SESSION['message'] = "Komentarz został zaktualizowany.";
        header("Location: topic.php?id=" . $topicId);
        exit();
    } else {
        echo "Błąd podczas edytowania komentarza.";
    }
}

$commentId = validateInput($_GET['id']);
$stmt = $pdo->prepare("SELECT content FROM comments WHERE id = ?");
$stmt->execute([$commentId]);
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    die('Komentarz nie istnieje.');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj komentarz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Edytuj komentarz</h1>
        <form action="edit_comment.php" method="post">
            <input type="hidden" name="comment_id" value="<?= htmlspecialchars($commentId) ?>">
            <input type="hidden" name="topic_id" value="<?= htmlspecialchars($_GET['topic_id']) ?>">
            <label for="content">Treść *</label>
            <textarea name="content" required><?= htmlspecialchars($comment['content']) ?></textarea><br>
            <input type="submit" value="Zaktualizuj komentarz">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
