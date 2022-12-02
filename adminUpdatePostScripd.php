<?php

if (isset($_POST['idPost']) && isset($_POST['status'])) {
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
        or die('Не удалось подключиться к БД: ' . pg_last_error());


    $quary = "UPDATE inc_idea SET status = " . $_POST['status'] . " WHERE id = " . $_POST['idPost'];
    // $res = pg_query($db, (string) $quary);
    echo $quary;
    
    // $result = pg_query($db, "SELECT * FROM inc_idea WHERE id =" .$_POST['postId']);
}
