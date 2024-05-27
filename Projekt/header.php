<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php'; // Dołączenie połączenia z bazą danych

// Pobieranie wybranych działów z bazy danych
$stmt = $pdo->query("SELECT id, name FROM categories WHERE name IN ('IT', 'rozwój kariery', 'programowanie', 'inne')");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Twoja Strona</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav>
        <ul class="main-nav">
            <li><a href="index.php">Strona główna</a></li>
            <li class="dropdown">
                <a href="forum.php">Forum</a>
                <ul class="dropdown-content">
                    <?php foreach ($categories as $category): ?>
                        <li><a href="category.php?id=<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Wyloguj się</a></li>
            <?php else: ?>
                <li><a href="login.php">Zaloguj się</a></li>
                <li><a href="register.php">Zarejestruj się</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
</body>
</html>
