<!DOCTYPE html>
<html lang="en">

<head>

    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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

                        <button type="button" class="post_btn" data-bs-toggle="modal" data-bs-target="<?= '#modal' . $line['id'] ?>">
                            Обзор
                        </button>

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
                                    <div class="commnet_container" id="commnet_container">
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

                                                <textarea class="form-control" style="border-color: grey;" id="commentInput" type="text" placeholder="Оставить комментраий" name="comment_push_enter"></textarea>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn" style="" type="" id="btnLoad" onclick="DBAddComment(); eraseText()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
  <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
</svg>
                                                    </button>
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
    <script>
        function DBAddComment() {
            let comment = document.getElementById('commentInput').value;
            let id = document.getElementById('commentId').value;
            $.ajax({
                type: "POST",
                url: 'pushCommentScript.php',
                data: {
                    com: comment,
                    idCom: id
                },
                success: function(data) {
                    console.log(data);
                    var today = new Date();
                    var now = today.toLocaleString();
                    var curCom = data.com;
                    $('#commnet_container').append(" <div class='comment_body' id='comment_body'><div class='comment_head'>Author</div><div class='comment_inner'>" + comment + "</div><div class='comment_time'>" + now + "</div></div>");

                },
            });
        }

        function eraseText() {
            document.getElementById("commentInput").value = "";
        }
    </script>
</body>

</html>