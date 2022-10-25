<?php
    $db = pg_connect("host=localhost port=5432 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());

    if (isset($_POST['title_req']) && isset($_POST['text_req'])){

       $title = $_POST['title_req'];
       $descr = $_POST['text_req'];
       $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM posts"));
       $res = pg_query($db, "INSERT into posts VALUES(".$count[0].", '$title', '$descr')");
    }

    // if ($res){
    //     echo "kryto";
    // }else{
    //     echo "ploxo";
    // }
    
    header('Location:index.php')
?>
