<?php
session_start();
require 'db.php';
require 'header.php';

$topicId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT t.id, t.title, t.content, t.published_date, u.username 
                       FROM topics t 
                       JOIN users u ON t.user_id = u.id 
                       WHERE t.id = ?');
$stmt->execute([$topicId]);
$topic = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$topic) {
    die('Temat nie istnieje.');
}

$stmt = $pdo->prepare('SELECT c.content, c.created_at, c.pseudonym, u.username 
                       FROM comments c 
                       LEFT JOIN users u ON c.user_id = u.id 
                       WHERE c.topic_id = ? 
                       ORDER BY c.created_at DESC');
$stmt->execute([$topicId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($topic['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($topic['title']) ?></h1>
        <p><?= htmlspecialchars($topic['content']) ?></p>
        <p>Autor: <?= htmlspecialchars($topic['username']) ?></p>
        <p>Opublikowano: <?= htmlspecialchars($topic['published_date']) ?></p>

        <h2>Komentarze</h2>
        <?php if (empty($comments)): ?>
            <p>Brak komentarzy.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><?= htmlspecialchars($comment['content']) ?></p>
                    <p>Przez <?= htmlspecialchars($comment['username'] ?? $comment['pseudonym']) ?>, <?= htmlspecialchars($comment['created_at']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h2>Dodaj komentarz</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="add_comment.php" method="post">
                <input type="hidden" name="topic_id" value="<?= $topicId ?>">
                <label for="content">Treść komentarza:</label>
                <textarea name="content" required></textarea><br>
                <input type="submit" value="Dodaj komentarz">
            </form>
        <?php else: ?>
            <form action="add_comment.php" method="post">
                <input type="hidden" name="topic_id" value="<?= $topicId ?>">
                <label for="pseudonym">Pseudonim *</label>
                <input type="text" name="pseudonym" required><br>
                <label for="content">Treść komentarza:</label>
                <textarea name="content" required></textarea><br>
                <input type="submit" value="Dodaj komentarz">
            </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
