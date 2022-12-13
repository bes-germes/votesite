<?php

session_start();

if ($_SESSION['role'] != 1) {
    http_response_code(401);
    header('Location:index.php');
    exit;
}

if (isset($_POST['postId'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="http://localhost/votesite/jsScripts/wantToBeExuterShowSucces.js"></script>
        <script src="http://localhost/votesite/jsScripts/adminAcceptDeniedIdea.js"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <title>Test1</title>

    </head>

    <body>
        <header>
            <div class="navbar navbar-dark bg-primary shadow-sm">
                <div class="container">
                    <a href="index.php" class="navbar-brand d-flex align-items-center">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg> -->
                        <strong>Инкубатор идей</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </header>

        <section class="text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Admin кабинет</h1>
                    <h4>Здесь вы можете делать что захотите</h5>
                </div>
            </div>
        </section>



        <?php

        $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
            or die('Не удалось подключиться к БД: ' . pg_last_error());


        $result = pg_query($db, "SELECT * FROM inc_idea WHERE id = " . $_POST['postId']);
        $line = pg_fetch_assoc($result);

        $result_executers = pg_query($db, "SELECT * FROM public.inc_executors WHERE idea_id =" . $_POST['postId']);

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

        if ($line['image'] == null) {
            $link_image = "assets\images\intro.jpg";
        } else {
            $link_image = $line['image'];
        }

        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="card" style="margin-bottom: 15px;">
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%;">
                            <h5 class="card-title"><?= $line['title'] ?></h5>
                            <p class="card-text"><?= $line['description'] ?></p>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <button class="btn btn-success" type="button" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                            </svg><span id="like-span"><?= $likes ?></span></button>
                                        <button class="btn btn-danger" type="button" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                            </svg><span id="dis-span"><?= $dislikes ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($line['status'] == 1) { ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" onclick="acceptIdea()">Принять</button>
                    </div>
                    <div class="col-auto">

                        <button type="button" class="btn btn-primary mb-3" onclick="updateIdea(<?= $_POST['postId'] ?>, 8)">Отклонить</button>

                    </div>
                </div>
                <div class="row justify-content-center d-none" id="acceptIdea" style="margin-top: 2rem;">

                    <div class="col-auto">
                        <label for="staticEmail" class="form-control-plaintext">Дата начала голосования</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="start_vote_field" name="trip-start">
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" id="end_vote_field" name="trip-start">
                    </div>

                    <div class="col-auto">

                        <button type="button" class="btn btn-primary mb-3" onclick="updateIdea(<?= $_POST['postId'] ?>, 3)">Опубликовать</button>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div id="denyErr" class="d-none" style="color: red;">
                            Заявка отклонена
                        </div>
                        <div id="acceptErr" class="d-none" style="color: green;">
                            Заявка принята
                        </div>
                        <div id="timeErr" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        if ($line['status'] == 3) {
        ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <p> Идёт голосование </p>
                        <p> Осталось: <?= round((strtotime($line['vote_finish']) - strtotime(date('d.m.Y H:i:s'))) / 86400) ?> дней</p>
                    </div>
                </div>
            </div>
        <?php
        }
        if ($line['status'] == 4) {
        ?>
            <div class="container" name="settings">

                <div class="row justify-content-center" id="acceptIdea" style="margin-top: 2rem;">

                    <div class="col-auto">
                        <label for="staticEmail" class="form-control-plaintext">Дата начала испонения</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="start_freetry_field" name="trip-start">
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" id="end_freetry_field" name="trip-start">
                    </div>

                </div>
                <div class="row justify-content-center" style="margin-top: 1rem;">
                    <div class="col-auto">
                        <ul class="list-group">
                            <?php
                            $cur_id = 0;

                            while ($line_executers = pg_fetch_array($result_executers, null, PGSQL_ASSOC)) {
                                $result_user = pg_query($db, "SELECT * FROM public.student WHERE id = " . $line_executers['user_id']);
                                $line_user = pg_fetch_assoc($result_user);

                                if ($line['author'] == $line_executers['user_id']) {
                                    $is_leader = " list-group-item-primary";
                                    $is_leader_status = "Предложил заявку";
                                } else {
                                    $is_leader = "";
                                    $is_leader_status = "";
                                }

                            ?>
                                <li class="list-group-item<?= $is_leader ?>"><?= $line_user['first_name'] ?> <?= $line_user['middle_name'] ?> <?= $line_user['last_name'] ?> <?= $is_leader_status ?>
                                    <div class="form-check form-switch">

                                        <input class="form-check-input" type="checkbox" name="form-check-input" value="<?= $line_executers['user_id'] ?>" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">В команду</label>
                                    </div>
                                    <div class="form-check form-switch">

                                        <input class="form-check-input" type="checkbox" name="form-check-input-leader" value="<?= $line_executers['user_id'] ?>" id="flexSwitchCheckDefaultLeader<?= $cur_id ?>" onchange="addExecuterLeader(<?= $cur_id ?>)">
                                        <label class="form-check-label" for="flexSwitchCheckDefaultLeader">Сделать лидером</label>
                                    </div>
                                </li>

                            <?php
                                $cur_id++;
                            } ?>

                        </ul>
                        <div class="row justify-content-center" style="margin-top: 1rem;">
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefaultAll" onchange="chooseAll()">
                                    <label class="form-check-label" for="flexSwitchCheckDefaultAll">Выбрать всех</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="acceptIdea" style="margin-top: 1rem;">
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-3" onclick="addExecuters(<?= $_POST['postId'] ?>, 3)">Опубликовать</button>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div id="denyErr" class="d-none" style="color: red;">
                            Не выбраны исполнители
                        </div>
                        <div id="acceptErr" class="d-none" style="color: green;">
                            Началось исполнение идеи
                        </div>
                        <div id="timeErr" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                        <div id="leaderErr" class="d-none" style="color: red;">
                            Не выбран лидер
                        </div>
                    </div>

                </div>
            </div>

        <?php
        }
        if ($line['status'] == 5) { ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        Не прошла голосование
                    </div>
                </div>
            </div>
        <?php }
        if ($line['status'] == 6) {
        ?>

    <?php }
    }
    ?>