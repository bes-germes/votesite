function DBShowReply(commId, idx) {


    $.ajax({
        type: "POST",
        url: 'getReplyComments.php',
        data: {
            commentId: commId,
            postId: idx
        },
        success: function (data) {
            console.log(data);

            // document.getElementById('comment_reply' + commId).remove;

            if (document.getElementById('rpy_btn' + idx).textContent == "Развернуть") {
                document.getElementById('rpy_btn' + idx).textContent = "Скрыть";
            } else {
                DBHideReply(idx)
                document.getElementById('rpy_btn' + idx).textContent = "Развернуть";
                return 0;
            }

            $('#commnet_container' + idx).append(data);
        },
    });
}


function DBHideReply(idx) {

    document.getElementById('reply_body' + idx).remove();

}

function DBAnwerToComment(idx) {

    document.getElementById('form-control').textContent = "ответить";

}