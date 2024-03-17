<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../app/Database.php';
include_once __DIR__ . '/../app/BestStories.php';

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
    <title>add page</title>
</head>
<body>

<form action="./../change.php" method="POST">
    Название статьи, которую нужно редактировать: <input name="titleToChange">

    <?php foreach ($titles as $title): ?>
        | <?=$title[0];?> |
    <?php endforeach; ?>

    <br>

    Название: <input name="title"><br>
    Подтекст: <input name="subText"><br>

    Текст: <textarea name="text" rows="20" cols="150"></textarea><br>

    <button name="edit" type="submit">Изменить данные</button>
</form>

</body>
</html>



