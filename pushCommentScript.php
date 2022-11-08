<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());


 
if (isset($_POST['idCom']) && isset($_POST['com'])) {

    $descr = $_POST['com'];
    $postId = $_POST['idCom'];
    $postTime = date('d.m.Y H:i:s');
    $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment"));
    session_start();
    $autherId = $_SESSION['userId'];


    $quary = "INSERT into inc_comment VALUES(". $count[0]. "," . $postId. "," . "0". "," . $autherId . ", '" . $descr. "','" . $postTime. "','" . $postTime."');";
    $res = pg_query($db, (string) $quary);
    echo "INSERT into inc_comment VALUES(". $count[0]. "," . $postId. "," . "-1". "," . $autherId . ", '" . $descr. "','" . $postTime. "','" . $postTime."');";
}

