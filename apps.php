<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>groomroom</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav">
        <a href="new-app.php">Новая заявка</a>
        <a href="apps.php">Мои заявки</a>
        <a href="app/logout.php">Выход</a>
    </div>
    <div class="apps">

        <?php
            include 'app/db.php';
            $user_id = $_SESSION['user_id'];
            // INNER JOIN *название привязанной таблицы* ON *основная таблица.связанный стобик* = *привязанная таблица.связанный стобик*
            $query=$db->prepare("SELECT * FROM apps  INNER JOIN categories ON apps.categories_id = categories.categories_id WHERE user_id = ?");
            $query->execute([$user_id]);
            $row = $query -> fetchAll();
            // item - одно дело. foreach - туду лист, следующее дело - след. item
            foreach($row as $item){
                // внутри echo - кавычки одинарные
                echo "<div class='app'>
                <p>$item[timestamp]</p>
                <p>$item[animal_name]</p>
                <p>$item[description_of_the_requested]</p>
                <p>$item[categories_name]</p>
                <p>$item[status]</p></div>";
                // поменять $item[services_id] и $item[pay_methods_id] на $item[service_name] и $item[pay_name]
            }
        ?>
        
    </div>
    <div class="app-a">
        <a href="new-app.php" class="new-app-link">Новая заявка</a>
    </div>
    <script src="assets\js\jquery-3.7.1.min.js"></script>
</body>
</html>