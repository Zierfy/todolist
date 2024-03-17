<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../Controller/Database.php';
include_once __DIR__ . '/../Model/Article.php';

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Статья</title>
</head>
<body>

<?php

$db = new Database;
$id = $db->checkSql($_GET['id']);
$db->connect->close();

$article = new Article($id);
$result = mysqli_fetch_array($article->getArticle());
$article->connect->close();
?>

<h2 style="text-align: center"><?=$result['title']?></h2>

<p><?=$result['text']?></p>


</body>
</html>