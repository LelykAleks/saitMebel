<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID категории не указан.";
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $update = "UPDATE categories SET name='$name' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка при обновлении: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
$category = mysqli_fetch_assoc($result);
?>

<h1>Редактировать категорию</h1>
<form method="post">
    Название: <input type="text" name="name" value="<?= $category['name'] ?>"><br>
    <input type="submit" value="Сохранить">
    <link rel="stylesheet" href="style.css">
</form>
<a href="admin.php">Назад</a>
