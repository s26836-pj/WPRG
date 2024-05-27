<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$threadId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$role = $stmt->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = validateInput($_POST['title']);
    $content = validateInput($_POST['content']);

    if ($role == 'administrator' || $role == 'moderator' || $_POST['user_id'] == $userId) {
        $stmt = $pdo->prepare("UPDATE topics SET title = ?, content = ? WHERE id = ?");
        if ($stmt->execute([$title, $content, $threadId])) {
            header("Location: topic.php?id=" . $threadId);
            exit;
        } else {
            echo "Błąd podczas edytowania wątku.";
        }
    } else {
        echo "Nie masz uprawnień do edycji tego wątku.";
    }
} else {
    $stmt = $pdo->prepare("SELECT id, title, content FROM topics WHERE id = ?");
    $stmt->execute([$threadId]);
    $thread = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$thread) {
        die('Wątek nie istnieje.');
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj wątek</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Edytuj wątek</h1>
        <form action="edit_thread.php?id=<?= htmlspecialchars($thread['id']) ?>" method="post">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>">
            <label for="title">Tytuł *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($thread['title']) ?>" required><br>
            <label for="content">Treść *</label>
            <textarea name="content" required><?= htmlspecialchars($thread['content']) ?></textarea><br>
            <input type="submit" value="Zapisz zmiany">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
