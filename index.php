<?php
session_start();
require 'db.php';

// Массив с ручным добавлением товаров
$products = [
    [
        'id' => 1,
        'name' => 'Стол',
        'image' => 'images/i (2).webp',
        'description' => 'Прочный деревянный стол.',
        'details' => 'Идеальный стол для кухни или офиса. Натуральное дерево, устойчивая конструкция.',
        'price' => 5000
    ],
    [
        'id' => 2,
        'name' => 'Стул',
        'image' => 'images/i (5).webp',
        'description' => 'Удобный стул с мягким сиденьем.',
        'details' => 'Эргономичная спинка, обивка из велюра, подходит для длительного сидения.',
        'price' => 5000
    ],
    [
        'id' => 3,
        'name' => 'Шкаф',
        'image' => 'images/i (6).webp',
        'description' => 'Широкий шкаф для одежды.',
        'details' => 'Вместительный шкаф с полками и вешалкой. Отлично впишется в спальню.',
        'price' => 5000
    ],
    [
        'id' => 4,
        'name' => 'Диван',
        'image' => 'images/i (1).webp',
        'description' => 'Комфортный диван на три места.',
        'details' => 'Мягкий и уютный, обивка легко чистится. Идеален для гостиной.',
        'price' => 5000
    ],
    [
        'id' => 5,
        'name' => 'Кресло',
        'image' => 'images/i (4).webp',
        'description' => 'Мягкое кресло с подлокотниками.',
        'details' => 'Расслабляющее кресло для чтения или отдыха. Поддержка спины и стильный дизайн.',
        'price' => 5000
    ]
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог мебели</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 80%;
            max-width: 900px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .modal-img {
            width: 100%;
            max-width: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .modal-info {
            flex: 1;
            min-width: 250px;
        }

        .modal-price {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
        }

        .close {
            position: absolute;
            top: 10px; right: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .modal button {
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header class="header" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; padding: 10px 0;">
    <div style="text-align: center; margin-bottom: 10px;">
        <h1 style="margin: 0; font-size: 28px; color: #2c3550;">У Санька</h1>
        <p style="margin: 4px 0 0; font-size: 20px; color: #013123;">Мебель по-человечески — уютно, честно, по-домашнему</p>
    </div>
    <nav style="text-align: center; margin-top: 10px;">
        <a href="index.php" style="margin: 0 10px;">Главная</a>
        <a href="cart.php" style="margin: 0 10px;">Корзина</a>
        <a href="profile.php" style="margin: 0 10px;">Профиль</a>
        <a href="delivery.php" style="margin: 0 10px;">О доставке</a>
        <a href="reviews.php" style="margin: 0 10px;">Отзывы</a>
    </nav>
</header>
<div class="container">
    <h1>Каталог мебели</h1>
    <div class="catalog">
        <?php foreach ($products as $product): ?>
            <div class="product-card" onclick="openModal(
                    `<?= htmlspecialchars($product['name']) ?>`,
                    `<?= htmlspecialchars($product['description']) ?>`,
                    `<?= htmlspecialchars($product['details']) ?>`,
                    `<?= htmlspecialchars($product['price']) ?>`,
                    `<?= htmlspecialchars($product['image']) ?>`,
            <?= $product['id'] ?>
                    )">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <p><?= $product['description'] ?></p>
                <p class="price"><?= $product['price'] ?> ₽</p>
                <button>Подробнее</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Модальное окно -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <img id="modalImage" src="" alt="" class="modal-img">
        <div class="modal-info">
            <h2 id="modalName"></h2>
            <p id="modalShort"></p>
            <p id="modalDescription"></p>
            <p id="modalPrice" class="modal-price"></p>
            <a id="modalAddToCart" href=""><button>Добавить в корзину</button></a>
        </div>
    </div>
</div>

<?php include('phone.php'); ?>

<footer class="footer">
    © 2025 Интернет-магазин мебели | <a href="">УУУ</a> | <a href="https://vk.com/swaaagans">VK</a>
</footer>

<script>
    function openModal(name, shortDesc, fullDesc, price, image, id) {
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalShort').textContent = shortDesc;
        document.getElementById('modalDescription').textContent = fullDesc;
        document.getElementById('modalPrice').textContent = price + ' ₽';
        document.getElementById('modalImage').src = image;
        document.getElementById('modalAddToCart').href = 'cart.php?add=' + id;
        document.getElementById('productModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('productModal').style.display = 'none';
    }
</script>

</body>
</html>
