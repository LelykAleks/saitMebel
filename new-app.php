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
    <div class="new-app">
        <form action="app/new_app.php" method="POST">
            <p>Кличка домашнего питомца</p><input type="text" name="animal_name" required>
            <p>Описание запрашиваемых работ</p><input type="text" name="description_of_the_requested" required>
            <p>Категория</p><select name="categories_id">
                <option value="1">Кошка</option>
                <option value="2">Собака</option>
            </select>
            <input type="submit" value="Создать заявку">
        </form>
    </div>
    <script src="assets\js\jquery-3.7.1.min.js"></script>
</body>
</html>