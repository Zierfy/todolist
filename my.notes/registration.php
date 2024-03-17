<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/app/Registration.php';
include_once __DIR__ . '/app/Checks.php';

?>


<?php

$registration = new Registration(new Checks);
$errors = $registration->checkErrors($_POST);

if (!empty($_POST) && isset($errors['notEqual'])) {
    if ($errors['notEqual'] == 'equal') {
        $registration->setUser(
            $registration->checkSql($_POST['surname']),
            $registration->checkSql($_POST['name']),
            $registration->checkSql($_POST['patronymic']),
            $registration->checkSql($_POST['age']),
            $registration->checkSql($_POST['mail']),
            password_hash($registration->checkSql($_POST['password']), PASSWORD_DEFAULT),
            3
        );

        $registration->connect->close();
        header('Location: authorization.php');
        exit;
    }
}
$registration->connect->close();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="styles/registration.css">

    <title>Registration</title>
</head>
<body>

<form action="./registration.php" method="POST">
    Фамилия: <input name="surname" value="<?=!empty($_POST['surname']) ? $_POST['surname'] : ''?>"><br>
    Имя: <input name="name" value="<?=!empty($_POST['name']) ? $_POST['name'] : ''?>"><br>
    Отчество: <input name="patronymic" value="<?=!empty($_POST['patronymic']) ? $_POST['patronymic'] : ''?>"><br>
    Возраст: <input name="age" value="<?=!empty($_POST['age']) ? $_POST['age'] : ''?>"><br>
    Почта: <input type="email" name="mail" value="<?=!empty($_POST['mail']) ? $_POST['mail'] : ''?>"><br>
    Пароль:<input type="password" name="password" value=""><br>
    Подтвердите пароль: <input type="password" name="verifyPassword" value=""><br>

    <button type="submit" name="registration">Продолжить</button>
</form>

<br>

<div class="error-text">
    <?php
    if (isset($_POST['registration'])) {
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    }

    ?>
</div>

<div class="back">
    <div class="textBack">
        <div class="smallImg-back">
            <a href="authorization.php">
                <img width="100px" height="100px" class="img-back" src="./photos/back.png">
            </a>
        </div>
        <div class="smallText-back">
            Вернуться назад
        </div>
    </div>
</div>

</body>
</html>