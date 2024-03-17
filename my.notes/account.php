<?php session_start(); ?>

<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/app/Account.php';
include_once __DIR__ . '/app/Statistic.php';

?>


<?php

if (isset($_POST['btn'])) {
    header('Location: authorization.php');
    session_destroy();
    exit;
}

if (empty($_SESSION)) {
    header('Location: authorization.php');
    exit;
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personal account</title>

    <link rel="stylesheet" href="./styles/account.css"

</head>
<body>

<div class="header">
    <div class="account">
        <?php

        $db = new Database;
        $id = $db->checkSql($_SESSION['id']);
        $db->connect->close();

        $account = new Account($id);
        $user = mysqli_fetch_array($account->getUser());

        ?>

    <span style="color: red">
        <h1 align="center">
            <?='Приветствуем Вас, ' . $user['surname'] . ' ' . $user['name'] . ' ' . $user['patronymic']?>
        </h1>
    </span>

        <form action="./account.php" method="POST" style="text-align: right">
            <button name="btn" type="btn">Выйти из аккаунта</button>
        </form>

        <div class="buttons">
            <div class="button">
                <p style="font-size:26px">
                    Добавить запись.</p>
                <form action="./account.php" method="POST">
                    Заголовок: <input name="title"><br>
                    Содержание: <textarea name="text"></textarea><br>
                    Укажите статус публикации: <input name="status">(public, private)<br>

                    <button name="btnAdd" type="btnAdd">Press me!</button>
                </form><br>
            </div>
            <div class="button">
                <p style="font-size:26px">
                    Изменить статус записи.</p>
                <form action="./account.php" method="POST">
                    Заголовок: <input name="oldTitle" type="oldTitle"><br>
                    Новый статус публикации: <input name="newStatus" type="newStatus">(public, private)<br>

                    <button name="btnEdit" type="btnEdit">Press me!</button>
                </form><br>
            </div>
        </div>

        <div class="error">
            <p>
                <?php
                if (isset($_POST['btnAdd'])) {
                    $resultAdd = $account->addNote(
                        $id,
                        $account->checkSql($_POST['title']),
                        $account->checkSql($_POST['text']),
                        $account->checkSql($_POST['status'])
                    );
                    echo $resultAdd ? 'Запись успешно добавлена!' : 'Ошибка при добавлении';
                }

                if (isset($_POST['btnEdit'])) {
                    $resultEdit = $account->editNote(
                        $account->checkSql($_POST['oldTitle']),
                        $account->checkSql($_POST['newStatus'])
                    );
                    echo $resultEdit ? 'Запись успешно изменена!' : 'Ошибка при изменении';
                }
                ?>
            </p>
        </div>
    </div>
</div>
<div class="personalPublications">
    <div class="myPublications">
        <i>Все мои записи</i>
        <?php
        $notes = $account->getNotes();
        $account->connect->close();
        ?>
    </div>

    <div class="publications">
        <div class="publications-container">
            <div class="textPublications">
                <?php

                $count = 0;
//                var_dump(mysqli_fetch_all($notes));

                while ($note = mysqli_fetch_array($notes)) {

                    if ($count++ == 5) {
                        break;
                    }
                    ?>
                    <div class="header-publication">
                        <?=$note['title'];?><br>
                    </div>

                    <div class="text-publication">
                        <i><?=$note['text'];?></i>
                    </div>

                    <div class="status-publication">
                        <?=$note['status'];?>
                    </div>
                <?php } ?>
            </div>

            <div class="statistic">
                <div class="statistic-container">
                    <div class="statistic-header">
                        <h1 style="text-align: center">Статистика</h1>
                    </div>
                    <div class="total-statistic">
                        <?php
                        $statistic = new Statistic;
                        $stat = $statistic->getStatistic("SELECT `status_id` FROM `publications` WHERE `uid` = $id");
                        $statistic->connect->close();
                        ?>

                        <ul style="font-size: 26px;">
                            <li>Общее количество публикаций: <?=$stat['total']?>;</li>
                            <li>Общее количество публикаций для всех: <?=$stat['total_public']?>;</li>
                            <li>Общее количество публикаций доступные только Вам: <?=$stat['total_private']?>;</li>
                            <li>Общее количество защищенных публикаций: <?=$stat['total_protected']?>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="back">
    <div class="textBack">
        <div class="smallImg-back">
            <a href="./todolist.php">
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