<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
if (isset($_POST['tagValue'])) {
    $tags = pg_fetch_assoc(pg_query($db, "SELECT tag FROM public.inc_idea_tag WHERE tag = '" . $_POST['tagValue'] . "';"));
    if (empty($tags)) {
        echo '';
    } else {
        echo $tags['tag'];
    }
}
