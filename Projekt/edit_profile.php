<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = validateInput($_POST['bio']);

    $targetDir = "uploads/";
    $profileImage = null;

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            $profileImage = $targetFile;
        }
    }

    if ($profileImage) {
        $stmt = $pdo->prepare("UPDATE profiles SET bio = ?, profile_image = ? WHERE user_id = ?");
        $stmt->execute([$bio, $profileImage, $userId]);
    } else {
        $stmt = $pdo->prepare("UPDATE profiles SET bio = ? WHERE user_id = ?");
        $stmt->execute([$bio, $userId]);
    }

    header("Location: profile.php?id=" . $userId);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->execute([$userId]);
$profile = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    <h1>Edytuj profil</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Bio</label>
        <textarea name="bio"><?= htmlspecialchars($profile['bio']) ?></textarea>
        <label>Zdjęcie profilowe</label>
        <input type="file" name="profile_image">
        <input type="submit" value="Zapisz zmiany">
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
