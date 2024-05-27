<?php
session_start();
require 'db.php';
require 'functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);
    $confirmPassword = validateInput($_POST['confirm_password']);
    $role = validateInput($_POST['role']); 

    if ($password !== $confirmPassword) {
        $message = "Hasła nie pasują do siebie.";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            $message = "Nazwa użytkownika już istnieje. Wybierz inną nazwę.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $passwordHash, $role])) {
                $message = "Rejestracja zakończona sukcesem. Możesz się teraz zalogować.";
            } else {
                $message = "Rejestracja nie powiodła się. Spróbuj ponownie.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            var password = document.forms["registerForm"]["password"].value;
            var confirmPassword = document.forms["registerForm"]["confirm_password"].value;

            if (password != confirmPassword) {
                document.getElementById("passwordError").innerText = "Hasło w obu polach musi być identyczne";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    <h1>Rejestracja</h1>
    <?php
    if ($message) {
        echo '<p style="color: ' . ($message === "Rejestracja zakończona sukcesem. Możesz się teraz zalogować." ? 'green' : 'red') . ';">' . $message . '</p>';
    }
    ?>
    <form name="registerForm" action="register.php" method="post" onsubmit="return validateForm()">
        <label for="username">Nazwa użytkownika *</label>
        <input type="text" name="username" required><br>
        <label for="password">Hasło *</label>
        <input type="password" name="password" required>
        <span id="passwordError" style="color: red;"></span><br>
        <label for="confirm_password">Hasło (powtórnie) *</label>
        <input type="password" name="confirm_password" required><br>
        <label for="role">Rola *</label>
        <select name="role">
            <option value="uzytkownik">Użytkownik</option>
            <option value="moderator">Moderator</option>
            <option value="administrator">Administrator</option>
        </select><br>
        <input type="submit" value="Zarejestruj">
    </form>
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
