<!DOCTYPE html>
<html lang="en">

<head>

    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://localhost/votesite/jsScripts/DBAddComment.js"></script>
    <script src="http://localhost/votesite/jsScripts/DBAddLikeDislike.js"></script>
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
    $query = 'SELECT * FROM posts WHERE flag=' . $flag;
    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    ?>
    <div class="posts">
        <?php
        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            $query_likes = 'SELECT * FROM isuserlikepost WHERE userid=' . $_SESSION['userId'] . ' and postid=' . $line['id'];
            $result_likes = pg_query($query_likes) or die('Ошибка запроса: ' . pg_last_error());
            $likes_line = pg_fetch_array($result_likes, null, PGSQL_ASSOC);
            if ($likes_line['islike'] == 't' || $likes_line['isdislike'] == 't') {
                if ($likes_line['islike'] == 't') {
                    $put_like = '';
                    $put_dislike = 'outline-';
                    $likeBool = "true";
                    $disBool = "false";
                } else {
                    $put_like = 'outline-';
                    $put_dislike = '';
                    $likeBool = "false";
                    $disBool = "true";
                }
            } else {
                $put_like = 'outline-';
                $put_dislike = 'outline-';
                $likeBool = "false";
                $disBool = "false";
            }
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
                        <div class="view_and_likes">
                            <button type="button" class="post_btn" data-bs-toggle="modal" data-bs-target="<?= '#modal' . $line['id'] ?>">
                                Обзор
                            </button>
                            <div style="margin-top: 15px;">
                                <button class="btn btn-<?= $put_like ?>danger" id="like_btn<?= $line['id'] ?>" style="border-radius: 15px;" onclick="DBAddLike(<?= $line['id'] ?>, <?=  $likeBool ?>, <?= $disBool ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart-fill" viewBox="0 0 16 16">
                                        <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z" />
                                    </svg></button>
                                <button class="btn btn-<?= $put_dislike ?>dark" id="dis_btn<?= $line['id'] ?>" style="border-radius: 15px;" onclick="DBAddDislike(<?= $line['id'] ?>, <?=  $likeBool ?>, <?= $disBool ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heartbreak-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586ZM7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77Z" />
                                    </svg></button>
                            </div>
                        </div>
                        <!-- Модальное окно -->
                        <div class="modal fade" id="<?= 'modal' .  $line['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <?php $curId = $line['id'];
                                    ?>
                                    <div class="commnet_container" id="commnet_container<?= --$curId ?>">
                                        <?php $query_comments = 'SELECT * FROM postscomment WHERE postid=' . --$line['id'];
                                        $result_comments = pg_query($query_comments) or die('Ошибка запроса: ' . pg_last_error());

                                        while ($comment = pg_fetch_array($result_comments, null, PGSQL_ASSOC)) {
                                        ?>
                                            <div class="comment_body" id="comment_body">
                                                <div class="comment_head">
                                                    Author name
                                                </div>
                                                <div class="comment_inner">
                                                    <?= $comment['commenttext'] ?>
                                                </div>
                                                <div class="comment_time">
                                                    <?=
                                                    date('d.m.Y H:i:s', strtotime($comment['commenttime']));
                                                    ?>
                                                </div>
                                            </div>


                                        <?php
                                        } ?>
                                    </div>
                                    <!-- < action="pushCommentScript.php" method="POST"> -->
                                    <div class="comment_push mb-3">
                                        <div class="container-lg">

                                            <div class="input-group">

                                                <?php $curId = $line['id'];
                                                ?>
                                                <input type="hidden" name="id" id="commentId" value="<?= $curId ?>">

                                                <textarea class="form-control" style="border-color: grey;" id="commentInput<?= $curId ?>" type="text" placeholder="Оставить комментраий" name="comment_push_enter" required></textarea>

                                                <div class="input-group-append">
                                                    <button type="button" class="btn" style="" type="" onclick="DBAddComment(<?= $curId ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="w-100"></div>
                                                <div id="commentErr" class="d-none" style="color: red;">
                                                    Please enter a message in the textarea.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- </form> -->


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