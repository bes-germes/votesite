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
<div>
    <form action="addReqScript.php" method="POST">
        <div>
            <input class="title_rq" type="text" placeholder="Заголовок" name="title_req">
        </div>
        <div>
            <textarea class="text_rq" type="text" placeholder="Описание" name="text_req"></textarea>
        </div>
        <!-- <button type="submit">Отправить</button> -->
        <input style="margin: 15px" type="submit" value="Отправить">
    </form>
</div>
</body>

</html>