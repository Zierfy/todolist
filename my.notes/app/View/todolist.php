<?php session_start(); ?>

<?php

/*
 * Подключаем классы
 */
include_once __DIR__ . '/../Controller/Database.php';
include_once __DIR__ . '/../Controller/Publications.php';
include_once __DIR__ . '/../Model/MyNotes.php';
include_once __DIR__ . '/../Model/BestStories.php';

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./../../css/todolist.css">

    <script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>

    <title>ToDoList</title>
</head>

<body>

<div class="static-header">
    <div class="logo">
        <a href="#mainHeader" class="scrollto">
            <img src="./../../images/logo.png" class="logo-img" width="50px" height="50px">
        </a>
    </div>

    <i>
        <div class="nav">
            <a href="./../../../index.php" class="linkTo">Главная</a>
            <a href="./account.php" class="linkTo">Личный кабинет</a>
            <a href="./information.page.php" class="linkTo">Информация</a>
            <a href="./photography.php" class="linkTo">Фотографии</a>

            <a href="#publications" class="scrollto" style="text-decoration: none">Публикации</a>
        </div>
    </i>

    <div class="telephone">
        <div class="phone-image">
            <img src="./../../images/telephone.png" class="tel-img" width="25px" height="20px">
        </div>

        <div class="phone-text">
            +7-(985)-460-12-20
        </div>
    </div>
</div>

<div class="todoBG" id="mainHeader">
    <div class="header">
        <h1><p style="text-align: center">
                ToDoList</p></h1>
    </div>

    <span style="color:white">
        <?php if (!empty($_SESSION['mail'])): ?>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                YOU ARE AN ADMIN

                <form action="./change.php">
                    super magic button: <button>Change</button>
                </form>
            <?php elseif ($_SESSION['role'] == 'manager'): ?>
                YOU ARE A MANAGER

                <form action="./change.php">
                    magic button: <button>Change</button>
                </form>
            <?php else: ?>
                YOU ARE JUST A USER
            <?php endif; ?>
        <?php else: ?>
            WELCOME TO THE CLUB BUDDY
        <?php endif; ?>
    </span>

    <br><br>
    <br><br>
    <br><br>
    <br><br>

    <?php if (!empty($_SESSION)): ?>
        <div class="content">
            <div class="smallHeader">
                <strong><p style="font-size: 30px">
                        Первые пять моих записей:</p></strong>
            </div>
            <div class="text">
                <i><p style="font-size: 20px">
                    <?php
                    $db = new Database;
                    $id = $db->checkSql($_SESSION['id']);
                    $db->connect->close();

                    $myNotes = new MyNotes($id);
                    $data = $myNotes->getData();
                    $myNotes->connect->close();

                    $count = 0;

                    while ($row = mysqli_fetch_array($data)) {
                        echo '<hr>' . ++$count . ') ' . $row['title'] .
                            ' ---> ' . $row['text'] . '<hr>';
                        if ($count == 5) {
                            break;
                        }
                    }
                    ?>
                </p></i>
            </div>
        </div>
    <?php else: ?>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
            <br>
    <?php endif; ?>
</div>

<?php
$storyLink = './story.php';

$bestStories = new BestStories();
$dataStories = mysqli_fetch_all($bestStories->getBestStories());
$bestStories->connect->close();

?>


<div class="history">
    <div class="bestHistories">
        <div class="textBestHist">
            <i><b>У меня есть три <br> лучшие истории!</b></i>
        </div>
        <div class="img-items">
            <div class="img-item">
                <div class="img-image">
                    <img src="./../../images/sambo.jpg" class="sambo">
                </div>

                <div class="img-text">
                    <?=$dataStories[0][0]?>
                </div>

                <div class="img-subtext">
                    <?=$dataStories[0][1]?>
                </div>

                <div class="img-button">
                    <a href="<?=$storyLink?>?title=<?=$dataStories[0][2]?>" class="img-btn">Читать подробнее</a>
                </div>
            </div>
            <div class="img-item">
                <div class="img-image">
                    <img src="./../../images/billiard.jpg" class="billiard">
                </div>

                <div class="img-text">
                    <?=$dataStories[1][0]?>
                </div>

                <div class="img-subtext">
                    <?=$dataStories[1][1]?>
                </div>

                <div class="img-button">
                    <a href="<?=$storyLink?>?title=<?=$dataStories[1][2]?>" class="img-btn">Читать подробнее</a>
                </div>
            </div>
            <div class="img-item">
                <div class="img-image">
                    <img src="./../../images/books.jpg" class="books">
                </div>

                <div class="img-text">
                    <?=$dataStories[2][0]?>
                </div>

                <div class="img-subtext">
                    <?=$dataStories[2][1]?>
                </div>

                <div class="img-button">
                    <a href="<?=$storyLink?>?title=<?=$dataStories[2][2]?>" class="img-btn">Читать подробнее</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$title = !isset($_POST['btnDate']) ? '10 последних публикаций на сайте' : 'Публикации в выбранные дни';

?>

<div class="publications" id="publications">
    <div class="publ-container">
        <div class="header-lastPublications">
            <div class="header-LP-text">
                <p><?=$title;?></p>
            </div>

            <div class="dateFromTo">
                Выбрать даты публикаций

                <?php

                $publications = new Publications();
                $publications->formateSql(isset($_POST['btnDate']));

                ?>

                <form action="./todolist.php" method="POST">
                    <input type="date" name="start"
                           value="<?=$publications->first_date?>"
                           min="<?=$publications->first_date?>" max="<?=$publications->last_date?>">

                    &#8596;

                    <input type="date" name="end"
                           value="<?=$publications->last_date?>"
                           min="<?=$publications->first_date?>" max="<?=$publications->last_date?>"><br>

                    <button type="btnDate" name="btnDate">Посмотреть</button>
                </form>
            </div>
        </div>

        <div class="lastPublications">
            <?php

            $result = $publications->getData();
            $publications->connect->close();

            $count = 0;

            while ($row = mysqli_fetch_array($result)) {
                ++$count;
                ?>
                <div class="titleAndAuthorAndDate">
                    <div class="titles">
                        <a href="./publication.php?id=<?=$row['id']?>" class="linkToPublication" name="articles">
                            <?= $count . ') ' . $row['title'];?>
                        </a><br>
                    </div>
                    <div class="author">
                        <a href="./peoplepage.php?id=<?=$row['uid']?>" class="author-link">
                            <?php
                                echo $row['surname'] . ' ' .
                                    mb_substr($row['name'], 0, 1) . '. ' .
                                    mb_substr($row['patronymic'], 0, 1) . '.';
                            ?>
                        </a>
                    </div>
                    <div class="title-date">
                        <?= $row['date'];?>
                    </div>
                </div>
                <?php
                echo $count < 7 ? '<hr style="border-color: black; border-width: 3px">' : '';
            }?>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery("a.scrollto").click(function () {
            elementClick = jQuery(this).attr("href")
            destination = jQuery(elementClick).offset().top;
            jQuery("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 1100);
            return false;
        });
    });
</script>

</body>

</html>