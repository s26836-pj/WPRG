<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$role = $user['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = validateInput($_POST['title']);
    $content = validateInput($_POST['content']);
    $categoryId = validateInput($_POST['category_id']);

    if (in_array($role, ['administrator', 'moderator', 'uzytkownik'])) {
        $stmt = $pdo->prepare("INSERT INTO topics (category_id, user_id, title, content) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$categoryId, $userId, $title, $content])) {
            header("Location: category.php?id=" . $categoryId);
            exit;
        } else {
            echo "Błąd podczas dodawania wątku.";
        }
    } else {
        $message = "Nie masz uprawnień do tworzenia wątków.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Utwórz nowy wątek</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Utwórz nowy wątek</h1>
        <?php if (isset($message)): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="create_thread.php" method="post">
            <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id']) ?>">
            <label for="title">Tytuł *</label>
            <input type="text" name="title" required><br>
            <label for="content">Treść *</label>
            <textarea name="content" required></textarea><br>
            <input type="submit" value="Utwórz wątek">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
