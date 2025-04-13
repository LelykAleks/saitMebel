<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $insert = "INSERT INTO categories (name) VALUES ('$name')";
    if (mysqli_query($conn, $insert)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка при добавлении: " . mysqli_error($conn);
    }
}
?>

<h1>Добавить категорию</h1>
<form method="post">
    Название: <input type="text" name="name"><br>
    <input type="submit" value="Добавить">
    <link rel="stylesheet" href="style.css">
</form>
<a href="admin.php">Назад</a>
