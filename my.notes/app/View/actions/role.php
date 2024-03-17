<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../../Controller/Database.php';
include_once __DIR__ . '/../../Model/HumanSettings.php';

?>

<?php

$human = new HumanSettings();

$human->loadMailsAllUsers();
$human->loadRolesAllUsers();

$mails = array_slice(mysqli_fetch_all($human->getMailsAllUsers()), 1);
$roles = array_slice(mysqli_fetch_all($human->getRolesAllUsers()), 1);

$total = count($mails);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Role</title>
</head>
<body>

<form action="./../change.php" method="POST">
    Почты пользователей, роли которых можно редактировать:<br>

    <?php for ($i = 0; $i < $total; $i++) { ?>
        <?=$i + 1?>) <?=$mails[$i][0]; ?> ( <?=$roles[$i][0]; ?> ) <br>
    <?php } ?>
    <br>

    Введите e-mail, кому поменять роль: <input name="mail"><br>
    Введите роль, которую присвоим пользователю: <input name="newRole"><br>

    <button name="changeRole" type="submit">Присвоить новую роль</button>
</form>

</body>
</html>