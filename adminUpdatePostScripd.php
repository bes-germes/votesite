<?php

if (isset($_POST['idPost']) && isset($_POST['status'])) {
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
        or die('Не удалось подключиться к БД: ' . pg_last_error());


    $quary = "UPDATE inc_idea SET status = " . $_POST['status'] . ", vote_start = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_start'])) . "',vote_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_finish'])) . "' WHERE id = " . $_POST['idPost'];
    $res = pg_query($db, "UPDATE inc_idea SET status = " . $_POST['status'] . ", vote_start = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_start'])) . "',vote_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_finish'])) . "' WHERE id = " . $_POST['idPost']);
    echo $quary;
    if ($res) {
        echo "kryto";
    } else {
        echo "ploxo";
    }
}
