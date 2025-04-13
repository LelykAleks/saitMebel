<?php
session_start();
require 'db.php';

$category_id = $_GET['id'];
$category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id = $category_id"));
$products = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $category_id");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Категория: <?= $category['name'] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php">Главная</a>
</header>

<div class="container">
    <h1>Категория: <?= $category['name'] ?></h1>
    <div class="catalog">
        <?php if (mysqli_num_rows($products) > 0): ?>
            <?php while ($product = mysqli_fetch_assoc($products)): ?>
                <div class="product-card">
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <p class="price"><?= $product['price'] ?> ₽</p>
                    <button>Добавить в корзину</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>В этой категории пока нет товаров.</p>
        <?php endif; ?>
    </div>
</div>
<?php include('phone.php'); ?>

<footer class="footer">
    © 2025 Интернет-магазин мебели
</footer>

</body>
</html>
