<?php
// Включение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных формы
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';

    // Настройка email
    $to = 'ваш_email@example.com'; // Замените на реальный email
    $subject = 'Новый заказ доставки';
    $message = "Имя: $name\nТелефон: $phone\nАдрес: $address\nВремя: $time\nПожелания: $comments";
    $headers = 'From: noreply@ваш_сайт.ru' . "\r\n" .
        'Reply-To: noreply@ваш_сайт.ru' . "\r\n" .
        'Content-type: text/plain; charset=utf-8';

    // Отправка email
    if (mail($to, $subject, $message, $headers)) {
        header('Location: thank-you.html'); // Убедись, что файл thank-you.html существует!
    } else {
        echo 'Ошибка при отправке данных.';
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>


