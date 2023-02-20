<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());



if (!isset($_POST['idCom'])) {
    $comId = -1;
} else {
    $comId = $_POST['idCom'];
}


$descr = $_POST['com'];
$postId = $_POST['idPost'];

$postTime = date('d.m.Y H:i:s');
$count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment"));
session_start();
$authorId = $_SESSION['hash'];



$quary = "INSERT into inc_comment(idea_id, comment_id, author_id, description, created, modified)  VALUES(" . $postId . "," . $comId . "," . $authorId . ", '" . $descr . "','" . $postTime . "','" . $postTime . "');";
$res = pg_query($db, (string) $quary);
$quary = "SELECT MAX(id) from inc_comment";
$res = pg_query($db, (string) $quary);

echo pg_fetch_assoc($res)['max'];
