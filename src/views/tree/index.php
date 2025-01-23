<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дерево сотрудников</title>

    <!-- Подключаем CSS стили из папки assets/css -->
    <link rel="stylesheet" href="<?php echo $_ENV["ASSETS_ROOT"]?>/assets/css/tree.css">

</head>
<body>

<div class="container">
    <h1>Дерево сотрудников</h1>
    <?php echo $tree ?>
</div>

<!-- Подключаем JS скрипт из папки assets/js -->
<script src="<?php echo $_ENV["ASSETS_ROOT"]?>/assets/js/tree.js"></script>

</body>
</html>
