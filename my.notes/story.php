<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/app/Story.php';

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="styles/story.css">

    <title>Story</title>
</head>
<body>

<?php
$db = new Database;
$chpu = $db->checkSql($_GET['title']);
$db->connect->close();

$story = new Story($chpu);
$data = mysqli_fetch_all($story->getStory());
$story->connect->close();
?>

<div class="story">
    <div class="header" style="text-align: center">
        <i><h1><?=$data[0][0]?></h1></i>
    </div>
    <div class="content">
        <?php
        $text = explode("\n", $data[0][1]);

        foreach ($text as $smallText) {
            echo $smallText . '<br>';
        }?>
    </div>
</div>
</body>
</html>

