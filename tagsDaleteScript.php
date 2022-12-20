<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
if (isset($_POST['tagValue']) && isset($_POST['postID'])) {

    pg_query($db, "DELETE FROM public.inc_idea_tag WHERE idea_id = " . $_POST['postID']);
}
