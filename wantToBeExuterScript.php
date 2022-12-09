<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
session_start();
if (isset($_POST['postId'])) {

    if (isset($_POST['arr'])) {

        $role_status = 2;
        foreach ($_POST['arr'] as &$value) {
            pg_query($db, "UPDATE public.inc_executors SET role=" . $role_status . ", role_date='" . date('d.m.Y H:i:s') . "' WHERE user_id = " . $value);
            $role_status = 1;
        }

        

        // pg_query($db, "UPDATE public.inc_executors SET role=1, role_date='" . date('d.m.Y H:i:s') . "' WHERE user_id = ");

        exit;
    }


    $result_end_vote_time = pg_send_query($db, "SELECT id, idea_id, user_id, role, role_date FROM public.inc_executors WHERE idea_id = " . $_POST['postId'] . "and user_id = " . $_SESSION['hash']);
    $res_end_time_vote = pg_get_result($db);
    $rows_end_time_vote = pg_num_rows($res_end_time_vote);
    if ($rows_end_time_vote > 0) {
        echo "Вы уже оставили заявку";
    } else {
        $user = $_SESSION['hash'];
        $postTime = date('d.m.Y H:i:s');
        $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM public.inc_executors"));
        pg_query($db, "INSERT INTO public.inc_executors(id, idea_id, user_id, role, role_date)VALUES (" . $count[0] . ", " . $_POST['postId'] . ", " . $user . ", 0, '" . $postTime . "');");
    }
}
