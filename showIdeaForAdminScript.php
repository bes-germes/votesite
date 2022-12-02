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

        $result = pg_query($db, "SELECT * FROM inc_idea WHERE" . $_POST['postId']);
        $line = pg_fetch_assoc($result);
        $cur_data = date('d.m.Y H:i:s');
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

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <button type="button" class="btn btn-success" onclick="denyIdea(<?= $_POST['postId'] ?>, 2)">Принять</button>
                </div>
                <div class="col-auto">

                    <button type="button" class="btn btn-primary mb-3" onclick="denyIdea(<?= $_POST['postId'] ?>, 8)">Отклонить</button>

                </div>
            </div>
            <div class="row justify-content-center d-none" id="acceptIdea" style="margin-top: 2rem;">

                <div class="col-auto">
                    <label for="staticEmail" class="form-control-plaintext">Дата начала голосования</label>
                </div>
                <div class="col-auto">
                    <label for="inputPassword2" class="visually-hidden"></label>
                    <input class="form-control" id="curData" type="text" value="<?= $cur_data ?>" aria-label="Disabled input example" disabled readonly>
                </div>

                <div class='col-auto'>
                    <input type="date" class="form-control" id="end_vote_field" name="trip-start">
                </div>

                <div class="col-auto">

                    <button type="button" class="btn btn-primary mb-3">Опубликовать</button>


                </div>
            </div>
        </div>
        <div id="denyErr" class="d-none" style="color: red;">
            Заявка отклонена
        </div>
    <?php
}
