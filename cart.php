<?php

session_start();
// Увеличение количества товара
if (isset($_GET['increase'])) {
    $id = (int)$_GET['increase'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    }
    header("Location: cart.php");
    exit();
}

// Уменьшение количества товара
if (isset($_GET['decrease'])) {
    $id = (int)$_GET['decrease'];
    if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id]--;
    } else {
        unset($_SESSION['cart'][$id]); // Если количество стало 0, удаляем товар
    }
    header("Location: cart.php");
    exit();
}

require 'db.php';

// Инициализируем корзину, если её нет
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Добавление товара в корзину
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: cart.php"); // Перезагружаем страницу, чтобы обновилась корзина
    exit();
}

// Удаление товара из корзины
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
}

// Получаем товары из корзины
$cart_items = $_SESSION['cart'];
$products = [];
$total = 0;

if (!empty($cart_items)) {
    $ids = implode(',', array_keys($cart_items));
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $row['quantity'] = $cart_items[$row['id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $total += $row['subtotal'];
        $products[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php">Главная</a>
    <a href="profile.php">Профиль</a>
    <a href="delivery.php">О доставке</a>
    <a href="reviews.php">Отзывы</a>

</header>

<div class="container">
    <h1>Корзина</h1>

    <?php if (empty($products)): ?>
        <p>Ваша корзина пуста.</p>
    <?php else: ?>
        <table class="cart-table">
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($products as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td class="price"><?= number_format($item['price'], 2, '.', ' ') ?> ₽</td>
                    <td>
                        <a href="cart.php?decrease=<?= $item['id'] ?>" class="quantity-btn">−</a>
                        <?= intval($item['quantity']) ?>
                        <a href="cart.php?increase=<?= $item['id'] ?>" class="quantity-btn">+</a>
                    </td>

                    <td class="price"><?= number_format($item['subtotal'], 2, '.', ' ') ?> ₽</td>
                    <td>
                        <a href="cart.php?remove=<?= $item['id'] ?>">
                            <button class="remove-button">Удалить</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h2>Общая сумма: <?= number_format($total, 2, '.', ' ') ?> ₽</h2>
        <a href="checkout.php"><button class="checkout-button">Оформить заказ</button></a>
    <?php endif; ?>
</div>

<footer class="footer">
    © 2025 Интернет-магазин мебели
</footer>

</body>
</html>
