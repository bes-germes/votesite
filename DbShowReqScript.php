<?php
session_start();
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
$result_idea = pg_query($db, "SELECT * FROM inc_idea WHERE author=" . $_SESSION['hash'] . $_POST['status']);
