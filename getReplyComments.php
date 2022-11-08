<?php
$db = pg_connect("host=localhost port=5433 user=postgres dbname=olegDB password=postgres")
    or die('Не удалось подключиться к БД: ' . pg_last_error());

if (isset($_POST['commentId']) && isset($_POST['postId'])) {
    $queryRepComments = 'SELECT * FROM inc_comment WHERE idea_id=' . $_POST['postId'] . 'AND comment_id!=' . $_POST['commentId'] . ';';
    $resultRepComments = pg_query($queryRepComments) or die('Ошибка запроса: ' . pg_last_error());

    echo "<div class='reply_body' id='reply_body" . $_POST['commentId'] . "'>";
    while ($comment = pg_fetch_array($resultRepComments, null, PGSQL_ASSOC)) {
?>
        <div class='comment_rply_body' id='comment_body'>
            <div class='comment_head'>Auther</div>
            <div class='comment_inner'><?=$comment['description']?></div>
            <div class='comment_time'> <?= date('d.m.Y H:i:s', strtotime($comment['created']))?>
                <button type='button' id="<?='answer_btn' . $comment['id']?>" class='btn' style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?=$comment['id']?>)">
                    Ответить
                </button>

            </div>
        </div>
<?php
    }
    echo "</div>";
}
