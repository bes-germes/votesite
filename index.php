<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                <center>
                    <a class="click_link" href="">Рассмотренные идеи</a>
                    <a class="click_link" href="#">Идеи в процессе</a>
                    <a class="click_link" href="#">Откланённые идеи</a>
                    <a class="click_link" href="#">Предложенные идеи</a>
                    <a class="click_link" href="addRequset.php">Добавить заявку</a>
                </center>
            </div>
        </div>
    </div>
    <hr>
    </hr>

    <?php
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
        or die('Не удалось подключиться к БД: ' . pg_last_error());
    $query = 'SELECT * FROM posts';
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
                            
                            <strong><?= ++$line['id'].". ". $line['title'] ?></strong>
                            <div>
                                <?= $line['descr'] ?>
                            </div>
                        </div>
                        <button class="post_btn">Обзор</button>
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