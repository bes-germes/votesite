<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
   or die('Не удалось подключиться к БД: ' . pg_last_error());
$count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_idea_vote"));

session_start();

$quary = "SELECT * FROM inc_idea_vote WHERE idea_id =". $_POST['postId'];
echo $quary;

$result = pg_query($db, (string) $quary);
$line = pg_fetch_assoc($result);

if (!is_array($line)){
   $quary = "INSERT INTO inc_idea_vote VALUES(" . $_POST['postId'] . "," . $_SESSION['userId'] . "," . $_POST['dislikeBool'] . "," . $count[0] . ")";
    echo $quary;
    pg_query($db, (string) $quary);
}else{
   $quary = "UPDATE inc_idea_vote SET value = " . $_POST['dislikeBool'] . " WHERE idea_id = " . $_POST['postId'] . ";";
   echo $quary;
   pg_query($db, (string) $quary);

}