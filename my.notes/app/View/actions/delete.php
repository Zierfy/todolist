<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../../Controller/Database.php';
include_once __DIR__ . '/../../Model/BestStories.php';

?>

<?php

$bestStories = new BestStories;
$titles = mysqli_fetch_all($bestStories->getTitlesAllStories());

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>delete page</title>
</head>
<body>

<form action="./../change.php" method="POST">
    Название статьи, которую нужно удалить: <input name="titleToDelete">

    <?php foreach ($titles as $title): ?>
        | <?=$title[0];?> |
    <?php endforeach; ?>

    <br>

    <button name="delete" type="submit">Удалить данные</button>
</form>



</body>
</html>