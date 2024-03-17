<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../Controller/Database.php';
include_once __DIR__ . '/../Model/Human.php';

?>



<?php

$db = new Database;
$id = $db->checkSql($_GET['id']);
$db->connect->close();

$human = new Human($id);

$user = mysqli_fetch_array($human->getUser());
$publications = $human->getPublications();
$human->connect->close();

$snp = $user['surname'] . ' ' . $user['name'] . ' ' . $user['patronymic'];
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$snp;?></title>
</head>
<body>

<h1 style="text-align: right"><?=$snp;?></h1>
<h2 style="text-align: right">Возраст: <?=$user['age'];?></h2>
<h2 style="text-align: right">e-mail: <?=$user['mail'];?></h2>

<?php while ($row = mysqli_fetch_array($publications)) { ?>
    <h3><?=$row['title'];?></h3>
    <a style="text-decoration: none; color: purple" href="./publication.php?id=<?=$row['id']?>"><p><?=mb_substr($row['text'], 0, 20);?>...</p></a>
<?php } ?>


</body>
</html>