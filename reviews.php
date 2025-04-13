<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert = "INSERT INTO reviews (name, message, created_at) VALUES ('$name', '$message', NOW())";
    mysqli_query($conn, $insert);
}
$reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Отзывы клиентов</h1>

<form method="post">
    <label>Ваше имя:</label><br>
    <input type="text" name="name" required><br>

    <label>Отзыв:</label><br>
    <textarea name="message" rows="4" required></textarea><br>

    <input type="submit" value="Оставить отзыв">
</form>

<hr>

<h2>Все отзывы:</h2>
<?php while ($row = mysqli_fetch_assoc($reviews)): ?>
    <div style="background:#fff; padding:15px; border-radius:10px; margin-bottom:10px;">
        <strong><?= htmlspecialchars($row['name']) ?></strong> <br>
        <small><?= $row['created_at'] ?></small><br>
        <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
    </div>
<?php endwhile; ?>

<a href="index.php">← Назад</a>

</body>
</html>
