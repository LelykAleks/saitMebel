<?php
session_start();
require 'db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получаем товары из корзины
$cart_items = $_SESSION['cart'];
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Считаем сумму заказа
$total = 0;
foreach ($cart_items as $id => $qty) {
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $total += $row['price'] * $qty;
}

// Создаем заказ
$user_id = $_SESSION['user_id'];
mysqli_query($conn, "INSERT INTO orders (user_id, total, status) VALUES ($user_id, $total, 'загрузка')");
$order_id = mysqli_insert_id($conn);

// Добавляем товары в заказ
foreach ($cart_items as $id => $qty) {
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $subtotal = $row['price'] * $qty;

    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES ($order_id, $id, $qty, $subtotal)");
}

// Очищаем корзину
unset($_SESSION['cart']);

header("Location: success.php");
exit();
?>
