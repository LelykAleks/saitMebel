<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);

    $insert = "INSERT INTO products (name, price, category_id) VALUES ('$name', '$price', '$category_id')";
    if (mysqli_query($conn, $insert)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка при добавлении: " . mysqli_error($conn);
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<h1>Добавить товар</h1>
<form method="post">
    Название: <input type="text" name="name"><br>
    Цена: <input type="text" name="price"> ₽<br>
    Категория:
    <select name="category_id">
        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Добавить">
    <link rel="stylesheet" href="style.css">
</form>
<a href="admin.php">Назад</a>