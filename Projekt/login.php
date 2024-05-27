<?php
session_start();
require 'db.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  
        header("Location: index.php");
        exit();
    } else {
        $error = "Błędna nazwa użytkownika lub hasło.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zaloguj się</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Zaloguj się</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Nazwa użytkownika *</label>
            <input type="text" name="username" required><br>
            <label for="password">Hasło *</label>
            <input type="password" name="password" required><br>
            <p><a href="forgot_password.php">Zapomniałeś hasła?</a></p>
            <input type="submit" value="Zaloguj się">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
