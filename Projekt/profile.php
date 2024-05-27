<?php
session_start();
require 'db.php';
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = validateInput($_POST['bio']);
    $userId = $_SESSION['user_id'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $userId . '.' . $fileExtension;

        $allowedfileExtensions = array('jpg', 'gif', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $stmt = $pdo->prepare("UPDATE users SET bio = ?, profile_picture = ? WHERE id = ?");
                $stmt->execute([$bio, $newFileName, $userId]);
                $_SESSION['message'] = "Profil został zaktualizowany.";
            } else {
                $_SESSION['error'] = "Wystąpił błąd podczas przesyłania pliku.";
            }
        } else {
            $_SESSION['error'] = "Nieobsługiwany format pliku. Proszę przesłać plik JPG, GIF lub PNG.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
        $stmt->execute([$bio, $userId]);
        $_SESSION['message'] = "Profil został zaktualizowany.";
    }

    header("Location: profile.php");
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, bio, profile_picture, role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    <h1>Mój profil</h1>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<p style="color: green;">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <label for="username">Nazwa użytkownika *</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username'] . ' (' . $user['role'] . ')') ?>" readonly><br>
        <label for="bio">O mnie</label>
        <textarea name="bio"><?= htmlspecialchars($user['bio']) ?></textarea><br>
        <div class="profile-picture-section">
            <label for="profile_picture">Zdjęcie profilowe</label>
            <?php if ($user['profile_picture']): ?>
                <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="profile-picture">
            <?php endif; ?>
            <input type="file" name="profile_picture">
        </div>
        <input type="submit" value="Zapisz zmiany">
    </form>
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
