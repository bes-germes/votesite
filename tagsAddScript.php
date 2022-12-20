<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
if (isset($_POST['tagValue']) && isset($_POST['postID'])) {

    $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM public.inc_idea_tag"));

   


    $quary = "SELECT id, idea_id, tag FROM public.inc_idea_tag WHERE idea_id = " . $_POST['postID'];
    echo $quary;

    $result = pg_query($db, (string) $quary);
    $line = pg_fetch_assoc($result);

    if (!is_array($line)) {
        pg_query($db, "INSERT INTO public.inc_idea_tag( id, idea_id, tag) VALUES (" . $count[0] . ", " . $_POST['postID'] . ", '" . $_POST['tagValue'] . "');");
        echo "INSERT INTO public.inc_idea_tag( id, idea_id, tag) VALUES (" . $count[0] . ", " . $_POST['postID'] . ", '" . $_POST['tagValue'] . "');";
    } else {
        pg_query($db, "UPDATE inc_idea_vote SET value = " . $_POST['likeBool'] . " WHERE idea_id = " . $_POST['postId'] . " and user_id =" . $_SESSION['hash'] . ";");
        echo "UPDATE inc_idea_vote SET value = " . $_POST['likeBool'] . " WHERE idea_id = " . $_POST['postId'] . " and user_id =" . $_SESSION['hash'] . ";";
    }
}
