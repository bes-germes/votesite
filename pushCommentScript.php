<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());

if (isset($_POST['idCom']) && isset($_POST['com'])) {

        $descr = $_POST['com'];
        $postId = $_POST['idCom'];
        $postTime = date('d.m.Y H:i:s');
        $res = pg_query($db, "INSERT into inc_comment VALUES('$postId', '$descr', '$postTime')");

}
