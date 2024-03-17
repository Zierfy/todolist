<?php session_start(); ?>

<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../Controller/Database.php';
include_once __DIR__ . '/../Controller/Authorization.php';
include_once __DIR__ . '/../Model/Checks.php';

?>


<?php
if (!empty($_SESSION)) {
    header('Location: account.php');
    exit;
}

$authorization = new Authorization(new Checks);

if (!empty($_POST)) {
    $errors = $authorization->checkErrors(
        $authorization->checkSql($_POST['mail']),
        $authorization->checkSql($_POST['password'])
    );
    if ($errors['noMail'] == 'exists' && $errors['noPassword'] == 'entered') {
        if ($authorization->checkPassword($_POST['mail'], $_POST['password'])) {
            $result = mysqli_fetch_array($authorization->joinAccount($_POST['mail']));

            $_SESSION['mail'] = $_POST['mail'];
            $_SESSION['role'] =  $result['role'];
            $_SESSION['id'] = $result['id'];

            $authorization->connect->close();

            header('Location: account.php');
            exit;
        } else {
            $errors['notEqual'] = 'НЕВЕРНЫЙ ПАРОЛЬ';
        }
    }
}
$authorization->connect->close();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./../../css/login.css">

    <title>Authorization</title>
</head>
<body>

<div class="registration">
    <div class="container">
        <div class="reg-header">
            Вход в личный кабинет
        </div>

        <form action="./authorization.php" method="POST">

            <div class="reg-form">
                <div class="email-item">
                    <div class="emailText">
                        <div class="email-text">
                            E-mail:
                        </div>

                        <div class="email-txt">
                            *
                        </div>
                    </div>

                    <div class="email-input">
                        <input type="mail" name="mail" placeholder="name@example.com" size="35" value="<?=!empty($_POST['mail']) ? $_POST['mail'] : '';?>">
                    </div>
                </div>

                <div class="password-item">
                    <div class="passwordText">
                        <div class="password-text">
                            Password:
                        </div>
                        <div class="password-txt">
                            *
                        </div>
                    </div>

                    <div class="password-input">
                        <input type="password" name="password" placeholder="Password: " size="35">
                    </div>
                </div>

                <div class="remember-item">
                    <div class="remember-text">
                        <input type="checkbox" name="remember">

                        Запомнить меня
                    </div>
                    <div class="remember-text-link">
                        <a href="#" class="remember-link">Забыли пароль?</a>
                    </div>
                </div>
            </div>

            <div class="enter-link">
                <div class="enter-text">
                    <button class="enter-btn">Войти</button>
                </div>
            </div>

        </form>

        <div class="registration-link">
            <div class="registration-text">
                <a href="./registration.php" class="reg-btn">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</div>

<div class="login-error">
    <span>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                if ($error != 'exists' && $error != 'entered') {
                    echo $error . '<br>';
                } else {
                    echo '<br>';
                }
            }
        }
        ?>
    </span>
</div>

<div class="back">
    <div class="textBack">
        <div class="smallImg-back">
            <a href="./todolist.php">
                <img width="100px" height="100px" class="img-back" src="./../../images/back.png">
            </a>
        </div>
        <div class="smallText-back">
            Вернуться назад
        </div>
    </div>
</div>

</body>
</html>