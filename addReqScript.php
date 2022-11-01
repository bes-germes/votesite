<?php
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());

    if (isset($_POST['title_req']) && isset($_POST['text_req'])){

       $title = $_POST['title_req'];
       $descr = $_POST['text_req'];
       session_start();
       $user = $_SESSION['userId'];
       $postTime = date('d.m.Y H:i:s');
       $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_idea"));
       $res = pg_query($db, "INSERT into inc_idea VALUES(".$count[0].", '$title', '$descr', '$user', 0, '$postTime', '$postTime', '$postTime', '$postTime', '$postTime', '$postTime', ' ', 0, 0, 0, 0)");
    }

    // if ($res){
    //     echo "kryto";
    // }else{
    //     echo "ploxo";
    // }
    
    header('Location:index.php')
?>
