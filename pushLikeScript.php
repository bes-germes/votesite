<?php
   $db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
      or die('Не удалось подключиться к БД: ' . pg_last_error());

   $quary = "UPDATE isuserlikepost SET islike = " . $_POST['likeBool'] . ", isdislike = " . $_POST['dislikeBool'] . " WHERE postid = " . $_POST['postId'] . ";";
   echo $quary;
   
   if (isset($_POST['postId']) && isset($_POST['likeBool']) && isset($_POST['dislikeBool'])) {
      pg_query($db, (string) $quary);
   }

// if ($res) {
//    while ($line = pg_fetch_array($res, null, PGSQL_ASSOC)) {
//       echo $line;
//    }
// }
