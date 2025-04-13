<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID продукта не указан.";
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);

    $update = "UPDATE products SET name='$name', price='$price', category_id='$category_id' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка при обновлении: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);
$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<h1>Редактировать товар</h1>
<form method="post">
    Название: <input type="text" name="name" value="<?= $product['name'] ?>"><br>
    Цена: <input type="text" name="price" value="<?= $product['price'] ?>"> ₽<br>
    Категория:
    <select name="category_id">
        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Сохранить">
    <link rel="stylesheet" href="style.css">
</form>
<a href="admin.php">Назад</a>
