<?php
$host = "localhost";  // Хост (обычно localhost)
$user = "root";       // Пользователь MySQL (по умолчанию root)
$pass = "";           // Пароль (обычно пустой)
$db_name = "furniture_store"; // Имя базы данных

$conn = mysqli_connect($host, $user, $pass, $db_name);

// Проверка соединения
if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>
