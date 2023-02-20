<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());



if (isset($_POST['idCom'])) {
    $res = pg_query($db, "DELETE FROM public.inc_comment WHERE id =" . $_POST['idCom'] . ";");
    if ($res){
        echo "aaaaaaaaa";
    }else{
        echo "bbbbbbbbb";
    }
}
