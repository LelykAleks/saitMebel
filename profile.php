<?php
session_start();
require 'db.php';

// Проверяем, вошел ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Обработка формы доставки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Сохраняем данные доставки
    $query = "INSERT INTO delivery_requests (user_id, name, phone, address, delivery_time, comments) 
              VALUES ($user_id, '$name', '$phone', '$address', '$time', '$comments')";
    mysqli_query($conn, $query);

    // Обновляем статус всех заказов пользователя
    mysqli_query($conn, "UPDATE orders SET status = 'в доставке' WHERE user_id = $user_id AND status != 'в доставке'");

    $message = "Спасибо, покупка скоро приедет!";

    echo "<script>
        setTimeout(function() {
            window.location.href = 'profile.php';
        }, 3000);
    </script>";
}

// Получаем данные пользователя
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

// Получаем заказы пользователя
$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php">Главная</a>
    <a href="cart.php">Корзина</a>
    <a href="logout.php">Выход</a>
    <a href="delivery.php">О доставке</a>
    <a href="reviews.php">Отзывы</a>

</header>

<div class="order-form">
    <h2>Заказать доставку</h2>

    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <form action="profile.php" method="post">
        <div class="form-group">
            <label for="name">Ваше имя:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="address">Адрес доставки:</label>
            <input type="text" id="address" name="address" required>
        </div>

        <div class="form-group">
            <label for="time">Удобное время доставки:</label>
            <select id="time" name="time">
                <option value="10:00-14:00">10:00-14:00</option>
                <option value="14:00-18:00">14:00-18:00</option>
                <option value="18:00-22:00">18:00-22:00</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comments">Особые пожелания:</label>
            <textarea id="comments" name="comments"></textarea>
        </div>

        <div class="form-group">
            <button type="submit">Заказать доставку</button>
        </div>
    </form>

    <h2>Ваши заказы</h2>
    <?php if (mysqli_num_rows($orders) > 0): ?>
        <table border="1">
            <tr>
                <th>ID заказа</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['total'] ?> ₽</td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>У вас пока нет заказов.</p>
    <?php endif; ?>
</div>

<?php include('phone.php'); ?>

<footer class="footer">
    © 2025 Интернет-магазин мебели
</footer>

</body>
</html>
