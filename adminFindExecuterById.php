<?php

if (isset($_POST['id_student'])) {
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
        or die('Не удалось подключиться к БД: ' . pg_last_error());

        $res_students_names = pg_query($db, "SELECT first_name, middle_name, last_name FROM public.student where id =" . $_POST['id_student']);

        $bebeebe = pg_fetch_assoc($res_students_names);
        
        echo $bebeebe['first_name'] . " " .$bebeebe['middle_name'] . " ". $bebeebe['last_name'] ;
}
