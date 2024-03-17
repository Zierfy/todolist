<?php session_start(); ?>

<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/app/Change.php';
include_once __DIR__ . '/app/BestStories.php';
include_once __DIR__ . '/app/Statistic.php';

?>

<?php

$statistic = new Statistic;
$stat = $statistic->getStatistic("SELECT `status_id` FROM `publications`");
$statistic->connect->close();

$change = new Change;

if (isset($_POST['add'])) {
    $result = $change->add($_POST['title'], $_POST['subText'], $_POST['text']);
    $error = $result ? 'Запись добавлена' : 'Ошибка при добавлении записи!';
} elseif (isset($_POST['edit'])) {
    $bestStories = new BestStories;
    $titles = mysqli_fetch_all($bestStories->getTitlesAllStories());

    foreach ($titles as $title) {
        if ($title[0] == $_POST['titleToChange']) {
            $result = $change->edit($_POST['titleToChange'], $_POST['title'], $_POST['subText'], $_POST['text']);
        } else {
            $result = false;
        }
    }
    $error = $result ? 'Запись изменена' : 'Ошибка при изменении записи!';
} elseif (isset($_POST['delete'])) {
    $bestStories = new BestStories;
    $titles = mysqli_fetch_all($bestStories->getTitlesAllStories());

    foreach ($titles as $title) {
        if ($title[0] == $_POST['titleToDelete']) {
            $result = $change->delete($_POST['titleToDelete']);
        } else {
            $result = false;
        }
    }
    $error = $result ? 'Запись удалена' : 'Ошибка при удалении записи!';
} elseif (isset($_POST['changeRole'])) {
    switch ($_POST['newRole']) {
        case 'manager':
            $newRole = 2;
            break;
        case 'user':
            $newRole = 3;
            break;
        default:
            $result = false;
            break;
    }

    if (isset($newRole)) {
        $result = $change->changeRole($change->checkSql($_POST['mail']), $newRole);
    }
    $error = $result ? 'Роль изменена' : 'Ошибка при изменении роли!';
} else {
    $result = false;
    $error = '';
}

$change->connect->close();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="styles/change.css">

    <title>ChangePage</title>
</head>
<body>

<div class="buttons">
    <div class="items">
        <div class="item">
            <div class="text">
                Добавить статью
            </div>
            <div class="btn">
                <form action="./actions/add.php" method="POST">
                    <button>press1</button>
                </form>
            </div>
        </div>
        <div class="item">
            <div class="text">
                Изменить статью
            </div>
            <div class="btn">
                <form action="./actions/edit.php" method="POST">
                    <button>press2</button>
                </form>
            </div>
        </div>
<?php if ($_SESSION['role'] == 'admin'): ?>
        <div class="item">
            <div class="text">
                Удалить статью
            </div>
            <div class="btn">
                <form action="./actions/delete.php" method="POST">
                    <button>press3</button>
                </form>
            </div>
        </div>
        <div class="item">
            <div class="text">
                Изменить роль
            </div>
            <div class="btn">
                <form action="./actions/role.php" method="POST">
                    <button>press4</button>
                </form>
            </div>
        </div>
    </div>

    <div class="statistic">
        <div class="statistic-header">
            <h1 style="text-align: center">Статистика</h1>
        </div>
        <div class="total-statistic">
            <ul style="font-size: 26px;">
                <li>Общее количество публикаций: <?=$stat['total'];?>;</li>
                <li>Общее количество публикаций для всех: <?=$stat['total_public'];?>;</li>
                <li>Общее количество публикаций доступные только самим пользователем: <?=$stat['total_private'];?>;</li>
                <li>Общее количество защищенных публикаций: <?=$stat['total_protected']?>.</li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="message">
    <?php if (!empty($error)): ?>
        <?php if ($result): ?>
            <span style="
            background-color: brown; border-radius: 15px;
            color: #28ff00; text-decoration: underline;
            padding: 15px 15px 15px 15px;">
                <?=$error;?></span>
        <?php else: ?>
            <span style="
            background-color: gray; border-radius: 15px;
            color: red; text-decoration: underline;
            padding: 15px 15px 15px 15px;">
                <?=$error;?></span>
        <?php endif; ?>
    <?php endif; ?>
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