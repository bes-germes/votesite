<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://localhost/votesite/jsScripts/DBaddReq.js"></script>
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
                <h1 class="fw-light">Предложить идею</h1>
            </div>
        </div>
    </section>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <form id="checkForm" action="addReqScript.php" enctype="multipart/form-data" method="POST">


                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Заголовок" aria-label="Заголовок" maxlength="23 " name="title_req" id="title_req" aria-describedby="basic-addon1" required>
                    </div>
                    <!-- <div>
                        <input class="title_rq" type="text" placeholder="Заголовок" name="title_req">
                    </div> -->
                    <div class="input-group mb-3">
                        <textarea name="text_req" class="form-control" placeholder="Предложить идею" aria-label="Предложить идею" id="text_req" style="resize: none; height: 50vh" required></textarea>
                    </div>
                    <!-- <div>
                        <textarea class="text_rq" type="text" placeholder="Описание" name="text_req"></textarea>
                    </div> -->
                    <div class="w-100" id="w-100"></div>
                    <div id="titleErr" class="d-none" style="color: red;">
                        Пожалуйста введите заголовок
                    </div>
                    <div id="descrErr" class="d-none" style="color: red;">
                        Пожалуйста введите описание идеи
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="input-group">

                                <!-- <label style="border: 1px solid grey; border-radius: 6px 0px 0px 6px; cursor:pointer;" class="d-flex">
                                    <div id="fileenter" class="color:grey;">Прикрепить файл</div>
                                    <input type="file" name="file" class="d-none form-control">

                                </label> -->
                                <div class="mb-3 d-flex flex-column">
                                    <label for="formFile" class="form-label">Выберите изoбражение для идеи</label>
                                    <div class="mb-3" style="display:flex; justify-content: space-between;">
                                        <input class="form-control" type="file" name="file" id="formFile" accept=".jpg, .jpeg, .png" required>
                                        <button class="btn btn-outline-secondary" id="submit-btn" type="submit" onclick="DBaddReq()">Отправить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

    </div>



</body>

</html>