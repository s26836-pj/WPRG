<?php
session_start();
require 'db.php';
require 'functions.php';

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$role = '';

if ($userId) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $role = $user['role'];
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = validateInput($_POST['content']);
    $topicId = validateInput($_POST['topic_id']);
    $pseudonym = isset($_POST['pseudonym']) ? validateInput($_POST['pseudonym']) : '';

    if ($userId) {
        if (in_array($role, ['administrator', 'moderator', 'uzytkownik'])) {
            $stmt = $pdo->prepare("INSERT INTO comments (topic_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$topicId, $userId, $content]);
            header("Location: topic.php?id=" . $topicId);
            exit;
        } else {
            $message = "Nie masz uprawnień do dodawania komentarzy.";
        }
    } else {
        if (empty($pseudonym)) {
            $message = "Pseudonim jest wymagany dla niezalogowanych użytkowników.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO comments (topic_id, pseudonym, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$topicId, $pseudonym . ' (niezalogowany)', $content]);
            header("Location: topic.php?id=" . $topicId);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj komentarz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Dodaj komentarz</h1>
        <?php if (!empty($message)): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="add_comment.php" method="post">
            <input type="hidden" name="topic_id" value="<?= htmlspecialchars($_GET['topic_id']) ?>">
            <?php if (!$userId): ?>
                <label for="pseudonym">Pseudonim *</label>
                <input type="text" name="pseudonym" required><br>
            <?php endif; ?>
            <label for="content">Komentarz *</label>
            <textarea name="content" required></textarea><br>
            <input type="submit" value="Dodaj komentarz">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
