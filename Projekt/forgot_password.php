<?php
session_start();
require 'db.php';
require 'functions.php';

$message = '';
$showResetForm = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $username = validateInput($_POST['username']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['reset_user_id'] = $user['id'];
        $showResetForm = true;
    } else {
        $message = "Użytkownik nie istnieje.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
    $newPassword = validateInput($_POST['new_password']);
    if (isset($_SESSION['reset_user_id'])) {
        $userId = $_SESSION['reset_user_id'];

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        if ($stmt->execute([$hashedPassword, $userId])) {
            $message = "Twoje hasło zostało zaktualizowane.";
            unset($_SESSION['reset_user_id']);
        } else {
            $message = "Błąd podczas resetowania hasła.";
        }
    } else {
        $message = "Sesja wygasła. Spróbuj ponownie.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zapomniałeś hasła</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Masz problem</h1>
        
        <?php if (!empty($message)): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <?php if (!$showResetForm): ?>
            <form action="forgot_password.php" method="post">
                <label for="username">Nazwa użytkownika *</label>
                <input type="text" name="username" required><br>
                <input type="submit" value="Przypomnij hasło">
            </form>
        <?php else: ?>
            <form action="forgot_password.php" method="post">
                <label for="new_password">Nowe hasło *</label>
                <input type="password" name="new_password" required><br>
                <input type="submit" value="Ustaw nowe hasło">
            </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
