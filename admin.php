<?php
session_start();
require 'db.php';

// Проверяем, админ ли это
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Получаем категории и товары
$categories = mysqli_query($conn, "SELECT * FROM categories");
$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php">Главная</a>
    <a href="logout.php">Выход</a>
</header>

<div class="container">
    <h1>Админ-панель</h1>

    <h2>Категории</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Действия</th>
        </tr>
        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= $cat['name'] ?></td>
                <td>
                    <a href="edit_category.php?id=<?= $cat['id'] ?>">Редактировать</a> |
                    <a href="delete_category.php?id=<?= $cat['id'] ?>">Удалить</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_category.php">Добавить категорию</a>

    <h2>Товары</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        <?php while ($prod = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?= $prod['id'] ?></td>
                <td><?= $prod['name'] ?></td>
                <td><?= $prod['price'] ?> ₽</td>
                <td><?= $prod['category_id'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $prod['id'] ?>">Редактировать</a> |
                    <a href="delete_product.php?id=<?= $prod['id'] ?>">Удалить</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_product.php">Добавить товар</a>
</div>

<footer class="footer">
    © 2025 Админ-панель
</footer>

</body>
</html>
