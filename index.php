<!DOCTYPE html>
<html lang="en">

<head>

    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://localhost/votesite/jsScripts/DBAddComment.js"></script>
    <script src="http://localhost/votesite/jsScripts/DBAddLikeDislike.js"></script>
    <script src="http://localhost/votesite/jsScripts/DBShowReply.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Test</title>

    <?php
    session_start();
    if (!isset($_SESSION['count'])) {
        $_SESSION['userId'] = 123;
    }
    ?>

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

    if (!isset($_GET['flag'])) {
        $flag = 0;
    } else {
        $flag = $_GET['flag'];
    }

    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
        or die('Не удалось подключиться к БД: ' . pg_last_error());
    $query = 'SELECT * FROM inc_idea WHERE status=' . $flag;
    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    ?>
    <div class="container">
        <div class="row">
            <?php
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

                $query_likes = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.user_id=' . $_SESSION['userId'] . ' and inc_idea_vote.idea_id=' . $line['id'];
                $result_likes = pg_query($query_likes) or die('Ошибка запроса: ' . pg_last_error());
                $likes_line = pg_fetch_array($result_likes, null, PGSQL_ASSOC);

                if ($likes_line == false) {
                    $put_like = 'outline-';
                    $put_dislike = 'outline-';
                    $likeBool = 0;
                    $disBool = 0;
                } else {

                    if ($likes_line['value'] == 1) {
                        $put_like = '';
                        $put_dislike = 'outline-';
                        $likeBool = 1;
                        $disBool = 0;
                    } else if ($likes_line['value'] == -1) {
                        $put_like = 'outline-';
                        $put_dislike = '';
                        $likeBool = 0;
                        $disBool = 1;
                    } else if ($likes_line['value'] == 0) {
                        $put_like = 'outline-';
                        $put_dislike = 'outline-';
                        $likeBool = 0;
                        $disBool = 0;
                    }
                }
            ?>




                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                    <div class="card" style="margin-bottom: 15px;">
                        <img class="card-img-top" src="assets\images\intro.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= $line['title'] ?></h5>
                            <p class="card-text"><?= $line['description'] ?></p>
                        </div>
                        <div class="card-body">

                            <div style="display: flex; justify-content: space-between;">
                                <button type="button" class="post_btn" data-bs-toggle="modal" data-bs-target="<?= '#modal' . $line['id'] ?>">
                                    Обзор
                                </button>
                                <div>
                                    <button class="btn btn-<?= $put_like ?>success" id="like_btn<?= $line['id'] ?>" value="<?= $likeBool ?>" style="border-radius: 15px;" onclick="DBAddLike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                        </svg></button>
                                    <button class="btn btn-<?= $put_dislike ?>danger" id="dis_btn<?= $line['id'] ?>" value=" <?= $disBool ?>" style="border-radius: 15px;" onclick="DBAddDislike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                        </svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Модальное окно-->
                    <div class="modal fade" id="<?= 'modal' .  $line['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="exit" style="margin-left: 97%">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <img class="card-img-top" src="assets\images\intro.jpg" style="width: 30%; height: 30%; margin: auto;" alt="Card image cap">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?= $line['title'] ?></h5>
                                </div>
                                <div class="modal-body">
                                    <?= $line['description'] ?>
                                </div>
                                <hr>
                                <h5 class="modal-title" style="margin-left: 15px" id="exampleModalLabel">Комментарии</h5>
                                <?php $curId = $line['id'];
                                ?>
                                <div class="commnet_container" id="commnet_container<?= $curId ?>">
                                    <?php $query_comments = 'SELECT * FROM inc_comment WHERE idea_id=' . $line['id'] . 'AND comment_id!= -1';
                                    $result_comments = pg_query($query_comments) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($comment = pg_fetch_array($result_comments, null, PGSQL_ASSOC)) {
                                    ?>
                                        <div class="comment_body" id="comment_body<?= $comment['id'] ?>">
                                            <div class="comment_head">
                                                Author name
                                            </div>
                                            <div class="comment_inner">
                                                <?= $comment['description'] ?>
                                            </div>
                                            <div class="comment_time">
                                                <?=
                                                date('d.m.Y H:i:s', strtotime($comment['created']));
                                                ?>
                                            </div>
                                            <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBShowReply(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Развернуть</button>
                                            <div class="comment_reply<?= $comment['id'] ?>" id="comment_reply<?= $comment['id'] ?>">

                                            </div>
                                        </div>


                                    <?php
                                    } ?>
                                </div>

                                <div class="comment_push mb-3">
                                    <div class="container-lg">

                                        <div class="input-group" id="input-group<?= $line['id'] ?>">

                                            <?php $curId = $line['id'];
                                            ?>
                                            <textarea name="hide" style="display:none;" class="form-control" style="border-color: grey;" id="answerInput" type="text" placeholder="Ответить на комментарий" required></textarea>

                                            <textarea class="form-control" style="border-color: grey;" id="commentInput" type="text" placeholder="Оставить комментраий" name="comment_push_enter" required></textarea>

                                            <div class="input-group-append" id="commentInputDiv">
                                                <button type="button" class="btn" style="" type="" onclick="DBAddComment(<?= $curId ?>)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                                    </svg>
                                                </button>

                                            </div>
                                            <div class="w-100" id="w-100<?= $line['id'] ?>"></div>
                                            <div id="commentErr<?= $line['id'] ?>" class="d-none" style="color: red;">
                                                Пожалуйста введите текст
                                            </div>
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
    </div>
    <?php
    pg_freeresult($result);
    pg_close($db);
    ?>
</body>

</html>