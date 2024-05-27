<?php
session_start();
require 'db.php'; 

$stmt = $pdo->query("SELECT id, name, description FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Forum - Strona główna</title>
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
<main>
    <div class="container">
        <h1>Forum</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= htmlspecialchars($_SESSION['message']) ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php foreach ($categories as $category): ?>
            <div class="category">
                <h2><a href="category.php?id=<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></a></h2>
                <p><?= htmlspecialchars($category['description']) ?></p>
                <?php if ($userRole == 'administrator'): ?>
                    <form action="delete_category.php" method="post" class="delete-category-form">
                        <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                        <input type="submit" value="Usuń kategorię" class="delete-category-btn" onclick="return confirm('Czy na pewno chcesz usunąć tę kategorię? Wszystkie wątki i komentarze w tej kategorii zostaną usunięte.');">
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if ($userRole == 'administrator'): ?>
            <div class="add-category">
                <h2>Dodaj nowy dział</h2>
                <form action="add_category.php" method="post">
                    <label for="name">Nazwa działu:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="description">Opis:</label>
                    <textarea id="description" name="description" required></textarea><br>
                    <input type="submit" value="Dodaj dział">
                </form>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
