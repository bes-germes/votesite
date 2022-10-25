<?php 
    $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());
    
    if (isset($_POST)){

        //$count = pg_fetch_row(pg_query($db, "SELECT".$_POST['id_post']."FROM posts"));
        echo "рыба
        ";
     }

?>

<div>
    <h1>gdfg</h1>
</div>

<div>
    ghdrhdrfh

</div>