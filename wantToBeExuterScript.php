<?php

$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
session_start();
if (isset($_POST['postId'])) {

    if (isset($_POST['arr'])) {
        foreach ($_POST['arr'] as $arr){
            pg_query($db, "UPDATE public.inc_executors SET role=" . $arr['role'] . ", role_date='" . date('d.m.Y H:i:s') . "' WHERE user_id = " . $arr['hash']);
        }

        pg_query($db,"UPDATE public.inc_idea SET status = 6, freetry_start = '" . date('d.m.Y H:i:s', strtotime($_POST['freetry_start'])) . "',freetry_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['freetry_finish'])) .  "' WHERE id = " . $_POST['postId']);
        return;
    }


    $result_end_vote_time = pg_send_query($db, "SELECT id, idea_id, user_id, role, role_date FROM public.inc_executors WHERE idea_id = " . $_POST['postId'] . " and user_id = " . $_SESSION['hash']);
    // print_r("SELECT id, idea_id, user_id, role, role_date FROM public.inc_executors WHERE idea_id = " . $_POST['postId'] . " and user_id = " . $_SESSION['hash']);
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
