<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
$count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment"));
echo $count[0];