<?php
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());

    if (isset($_POST['postId']) && isset($_POST['likeBool']) && isset($_POST['isDislike'])){
       
       $res = pg_query($db, "UPDATE isuserlikepost SET islike =" .$_POST['likeBool'].", isdislike = " .$_POST['isDislike']." WHERE postid =". --$_POST['postId'].";");
       echo $res;
    }
?>