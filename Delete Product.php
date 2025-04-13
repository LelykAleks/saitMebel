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

$delete = "DELETE FROM products WHERE id = $id";
if (mysqli_query($conn, $delete)) {
    header("Location: admin.php");
} else {
    echo "Ошибка при удалении: " . mysqli_error($conn);
}
