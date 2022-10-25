<!DOCTYPE html>
<html lang="en">

<head>

    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>

    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Test</title>

</head>
<header class="header">
    <div class="container">
        <div class="header_inner">
            <div class="header_logo">Название сайта</div>
            <nav class="nav">
                <a class="nav_link" href="#">Информация</a>
                <a class="nav_link" href="#">Сервис</a>
                <a class="nav_link" href="#">Контакты</a>
            </nav>
        </div>
    </div>
</header>

<body>
<div class="intro">
    <div class="container">
        <div class="container_inner">
            <h1 class="intro_title">Здесь вы можете оставить вашу идею</h1>
        </div>
    </div>
</div>

<div class="main">
    <div class="container">
        <div class="main_inner">
            <div style="text-align: center;">
                <a class="click_link" href="?flag=0">Рассмотренные идеи</a>
                <a class="click_link" href="?flag=1" id="1">Идеи в процессе</a>
                <a class="click_link" href="?flag=2" id="2">Отклонённые идеи</a>
                <a class="click_link" href="?flag=3" id="3">Предложенные идеи</a>
                <a class="click_link" href="addRequset.php">Добавить заявку</a>
            </div>
        </div>
    </div>
</div>
<hr>

<?php

if(!isset($_GET['flag'])){
    $flag = 0;
}else{
    $flag = $_GET['flag'];
}

$db = pg_connect("host=localhost port=5432 user=postgres dbname=olegDB password=postgres")
or die('Не удалось подключиться к БД: ' . pg_last_error());
$query = 'SELECT * FROM posts WHERE flag='.$flag;
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
?>
<div class=\"posts\">
    <?php
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

        ?>
        <div class="post">
            <div class="container">
                <div class="post_inner">
                    <div class="descr_inner">

                        <strong><?= ++$line['id'] . ". " . $line['title'] ?></strong>
                        <div>
                            <?= $line['descr'] ?>
                        </div>
                    </div>


<!--                    <a class="post_btn" id="--><?//=--$line['id']?><!--" href="javascript:PopUpShow()">Обзор</a>-->
                    <!-- Кнопка-триггер модального окна -->
                    <button type="button" class="post_btn" data-bs-toggle="modal" data-bs-target="<?='#modal'. $line['id']?>">
                        Обзор
                    </button>

                    <!-- Модальное окно -->
                    <div class="modal fade" id="<?='modal'.  $line['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?= $line['title'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <?= $line['descr'] ?>
                                </div>
                                <hr>
                                <h5 class="modal-title" style="margin-left: 15px" id="exampleModalLabel">Комментарии</h5>
                                <div class="modal-body">
                                    <?= $line['descr'] ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<?php
pg_freeresult($result);
pg_close($db);
?>
</body>

</html>