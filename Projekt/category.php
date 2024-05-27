<?php
session_start();
require 'db.php';
require 'header.php';

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT id, name, description FROM categories WHERE id = ?');
$stmt->execute([$categoryId]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die('Kategoria nie istnieje.');
}

$stmt = $pdo->prepare('SELECT t.id, t.title, t.published_date, t.user_id, u.username 
                       FROM topics t 
                       JOIN users u ON t.user_id = u.id 
                       WHERE t.category_id = ? 
                       ORDER BY t.published_date DESC');
$stmt->execute([$categoryId]);
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
$userRole = '';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userRole = $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($category['name']) ?> - Forum</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($category['name']) ?></h1>
        <p><?= htmlspecialchars($category['description']) ?></p>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= htmlspecialchars($_SESSION['message']) ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="create_thread.php?category_id=<?= $categoryId ?>" class="add-thread">Dodaj nowy wątek</a>
        <?php endif; ?>
        <div class="topics">
            <?php if (empty($topics)): ?>
                <p>Brak wątków w tej kategorii.</p>
            <?php else: ?>
                <?php foreach ($topics as $topic): ?>
                    <div class="topic">
                        <h3><a href="topic.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a></h3>
                        <p>Przez <?= htmlspecialchars($topic['username']) ?>, <?= htmlspecialchars($topic['published_date']) ?></p>
                        <?php if (isset($_SESSION['user_id']) && (in_array($userRole, ['administrator', 'moderator']) || $topic['user_id'] == $_SESSION['user_id'])): ?>
                            <a href="edit_thread.php?id=<?= $topic['id'] ?>" class="edit-thread">Edytuj</a>
                            <a href="delete_thread.php?id=<?= $topic['id'] ?>&category_id=<?= $categoryId ?>" class="delete-thread" onclick="return confirm('Czy na pewno chcesz usunąć ten wątek?');">Usuń</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
