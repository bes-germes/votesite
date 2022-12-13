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


</head>

<body>
    <header>
        <?php
        session_start();
        if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
            $_SESSION['login'] = '';
            $_SESSION['hash'] = -1;
        }
        ?>
        <div class="navbar navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg> -->
                    <strong>Инкубатор идей</strong>
                </a>

                <?php if ($_SESSION['login'] != '') { ?>
                    <form id="checkInOut" action="loginScript.php" enctype="multipart/form-data" method="POST">

                        <input type="hidden" value="logout" name="action">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                            <?php if ($_SESSION['role'] == 1) { ?>
                                <a class="btn btn-primary rounded-pill w-100" href="adminProfil.php"><?= $_SESSION['login'] ?></a>
                            <?php } else { ?>
                                <a class="btn btn-primary rounded-pill w-100" href="profil.php"><?= $_SESSION['login'] ?></a>
                            <?php } ?>
                        </div>

                        <input type="submit" class="btn btn-primary rounded-pill w-100" value="Выйти">
                    </form>
                <?php } else { ?>
                    <form id="checkInOut" action="login.php" enctype="multipart/form-data" method="POST">

                        <input type="hidden" value="login" name="action">
                        <input type="submit" class="btn btn-primary rounded-pill w-100" value="Войти">
                    </form>
                <?php } ?>
            </div>
        </div>
    </header>
    <main>

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Здесь вы можете оставить свою идею</h1>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=0">Все идеи</a>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=1" id="1">Идеи в процессе</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=2" id="2">Отклонённые идеи</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=3" id="3">Предложенные идеи</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="addRequset.php">Добавить идею</a>

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

        switch ($flag) {
            case 0:
                $query = 'SELECT * FROM inc_idea  WHERE status != 1 and status != 9 ORDER BY status';
                break;
            case 1:
                $query = 'SELECT * FROM inc_idea WHERE status = 6';
                break;
            case 2:
                $query = 'SELECT * FROM inc_idea WHERE status = 5 or status = 8';
                break;
            case 3:
                $query = 'SELECT * FROM inc_idea WHERE status = 2 or status = 3';
                break;
        }
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());


        ?>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

                        $query_likes = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.user_id=' . $_SESSION['hash'] . ' and inc_idea_vote.idea_id=' . $line['id'];

                        $likes = 0;
                        $dislikes = 0;
                        $query_count_vote = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.idea_id=' . $line['id'];
                        $result_count_vote = pg_query($query_count_vote) or die('Ошибка запроса: ' . pg_last_error());

                        while ($line_count_vote = pg_fetch_array($result_count_vote, null, PGSQL_ASSOC)) {

                            if ($line_count_vote['value'] == 1) {
                                $likes++;
                            }

                            if ($line_count_vote['value'] == -1) {
                                $dislikes++;
                            }
                        }

                        $result_end_vote_time = pg_send_query($db, "SELECT * FROM public.inc_idea WHERE DATE_PART('day', vote_finish - '" . date('d.m.Y') . "') >= 0 and DATE_PART('day', vote_start - '" . date('d.m.Y') . "') <= 0 and id = " . $line['id'] . ";");
                        $res_end_time_vote = pg_get_result($db);
                        $rows_end_time_vote = pg_num_rows($res_end_time_vote);
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

                        if ($line['image'] == null) {
                            $link_image = "assets\images\intro.jpg";
                        } else {
                            $link_image = $line['image'];
                        }
                    ?>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                            <div class="card" style="margin-bottom: 15px;">
                                <div style="width: 100%;height: 40vh;object-fit: cover;">
                                    <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                                </div>

                                <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                                    <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                                    <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                                </div>
                                <div class="card-body">

                                    <div class="container">
                                        <div class="row justify-content-between">
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="<?= '#modal' . $line['id'] ?>">
                                                    Обзор
                                                </button>
                                            </div>
                                            <div class="col-auto">
                                                <?php if ($rows_end_time_vote > 0) { ?>
                                                    <?php if ($_SESSION['login'] != '') { ?>
                                                        <button class="btn btn-<?= $put_like ?>success" id="like_btn<?= $line['id'] ?>" value="<?= $likeBool ?>" style="border-radius: 15px;" onclick="DBAddLike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                            </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></button>
                                                        <button class="btn btn-<?= $put_dislike ?>danger" id="dis_btn<?= $line['id'] ?>" value=" <?= $disBool ?>" style="border-radius: 15px;" onclick="DBAddDislike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                            </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></button>
                                                    <?php } else { ?>
                                                        <a class="btn btn-outline-success" id="like_btn" value="" style="border-radius: 15px;" href="authSuggestion.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                            </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></a>
                                                        <a class="btn btn-outline-danger" id="dis_btn" value="" style="border-radius: 15px;" href="authSuggestion.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                            </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <button class="btn btn-<?= $put_like ?>success" id="like_btn<?= $line['id'] ?>" value="<?= $likeBool ?>" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                        </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></button>
                                                    <button class="btn btn-<?= $put_dislike ?>danger" id="dis_btn<?= $line['id'] ?>" value=" <?= $disBool ?>" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                        </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></button>
                                                <?php } ?>
                                            </div>
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
                                        <img class="card-img-top" src="<?= $link_image ?>" style="width: 30%; height: 30%; margin: auto; max-height: 400px;" alt="Card image cap">
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
                                            <?php $query_comments = 'SELECT * FROM inc_comment WHERE idea_id=' . $line['id'] . 'and comment_id = -1';
                                            $result_comments = pg_query($query_comments) or die('Ошибка запроса: ' . pg_last_error());
                                            while ($comment = pg_fetch_array($result_comments, null, PGSQL_ASSOC)) {
                                            ?>
                                                <div class="comment_body" id="comment_body<?= $comment['id'] ?>">
                                                    <div class="comment_head">
                                                        Author name
                                                    </div>
                                                    <div class="comment_inner text-break">
                                                        <?= $comment['description'] ?>
                                                    </div>
                                                    <div class="comment_time">
                                                        <?=
                                                        date('d.m.Y H:i:s', strtotime($comment['created']));
                                                        ?>
                                                    </div>

                                                    <?php $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment WHERE comment_id =" . $comment['id']));

                                                    if ($count[0] != 0) {
                                                    ?>
                                                        <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBShowReply(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Развернуть</button>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Ответить</button>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="d-none" id="comment_reply<?= $comment['id'] ?>" style="flex-direction: column;display: flex;padding: 10px;margin-right: 65px;margin-left: 60px;">
                                                        <?php
                                                        $query_comments_reply = 'SELECT * FROM inc_comment WHERE comment_id != -1';
                                                        $result_comments_reply = pg_query($query_comments_reply) or die('Ошибка запроса: ' . pg_last_error());
                                                        while ($comment_reply = pg_fetch_array($result_comments_reply, null, PGSQL_ASSOC)) {
                                                            if ($comment_reply['comment_id'] == $comment['id']) {

                                                        ?>
                                                                <div class="comment_head">
                                                                    Author name
                                                                </div>
                                                                <div class="comment_inner text-wrap">
                                                                    <?= $comment_reply['description'] ?>
                                                                </div>
                                                                <div class="comment_time">
                                                                    <?=
                                                                    date('d.m.Y H:i:s', strtotime($comment_reply['created']));
                                                                    ?>
                                                                    <button type="button" id="answer_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Ответить</button>
                                                                </div>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Ответить</button>
                                                    </div>
                                                </div>


                                            <?php
                                            } ?>
                                        </div>

                                        <div class="comment_push mb-3">
                                            <div class="container-lg">

                                                <?php if ($_SESSION['login'] != '') { ?>
                                                    <div class="input-group" id="input-group<?= $curId ?>">

                                                        <?php $curId = $line['id'];
                                                        ?>
                                                        <textarea name="hide" style="display:none;" class="form-control" id="answerInputArea<?= $curId ?>" type="text" placeholder="Ответить на комментарий" required></textarea>

                                                        <textarea class="form-control" id="commentInputArea<?= $curId ?>" type="text" placeholder="Оставить комментраий" name="comment_push_enter" required></textarea>

                                                        <div class="input-group-append" id="commentInputDiv<?= $curId ?>">

                                                            <button type="button" id="commentInputBtn<?= $curId ?>" class="btn" style="" type="" onclick="DBAddComment(<?= $curId ?>)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                                                </svg>
                                                            </button>

                                                        </div>


                                                    </div>
                                                    <div class="row" style="margin-top: 1rem;">
                                                        <div class="col">
                                                            <!-- <a type="button" href="wantToBeExuter.php" class="btn btn-outline-secondary btn-sm">Хочу стать исполнителем идеи!</a> -->
                                                            <form id="checkInOut" action="wantToBeExuter.php" enctype="multipart/form-data" method="POST">

                                                                <input type="hidden" value="<?= $curId ?>" name="action">
                                                                <input type="submit" class="btn btn-outline-secondary btn-sm" value="Хочу стать исполнителем идеи!">
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="container">
                                                        <div class="row justify-content-center">
                                                            <input class="form-control" type="text" value="Оставлять комментарии могут только авторизированные пользователи" aria-label="Disabled input example" disabled readonly>
                                                            <a class="btn btn-primary" style="margin-top: 1rem;" href="authSuggestion.php" role="button">Войти</a>
                                                        </div>
                                                    </div>
                                                    </a>
                                                <?php } ?>
                                                <div class="w-100" id="w-100"></div>
                                                <div id="commentErr<?= $curId ?>" class="d-none" style="color: red;">
                                                    Пожалуйста введите текст
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

    </main>
</body>

</html>