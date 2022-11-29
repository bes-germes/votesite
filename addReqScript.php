<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());


try {

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['file']['error']) ||
        is_array($_FILES['file']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['file']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $wrong_format = false;
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['file']['tmp_name']),
        array(
            'jpg' => 'image/jpg',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
        ),
        true
    )) {
        $wrong_format = true;
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.

    $uniq_path = sprintf(
        './assets/images/%s.%s',
        sha1_file($_FILES['file']['tmp_name']),
        $ext
    );
    if (!move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $uniq_path
    )) {

        throw new RuntimeException('Failed to move uploaded file.');
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                    <h1 class="fw-light">Идея отправлена</h1>
                </div>
            </div>
        </section>



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a class="btn btn-primary" href="index.php" role="button">Супер!</a>
                </div>
            </div>

        </div>



    </body>

    </html>
<?php
} catch (RuntimeException $e) {

    echo $e->getMessage();
}


if (isset($_POST['title_req']) && isset($_POST['text_req'])) {

    $title = $_POST['title_req'];
    $descr = $_POST['text_req'];
    session_start();
    $user = $_SESSION['userId'];
    $postTime = date('d.m.Y H:i:s');
    $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_idea"));
    $res = pg_query($db, "INSERT into inc_idea VALUES(" . $count[0] . ", '$title', '$descr', '$user', 0, '$postTime', '$postTime', '$postTime', '$postTime', '$postTime', '$postTime','$uniq_path', 0, 0, 0, 0)");
    //header('Location:index.php');
}

// if ($res){
//     echo "kryto";
// }else{
//     echo "ploxo";
// }
