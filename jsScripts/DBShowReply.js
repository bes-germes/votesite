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

            if (document.getElementById('rpy_btn' + commId).textContent == "Развернуть") {
                document.getElementById('rpy_btn' + commId).textContent = "Скрыть";
            } else {
                DBHideReply(commId)
                document.getElementById('rpy_btn' + commId).textContent = "Развернуть";
                return 0;
            }
            // document.getElementById('comment_reply' + idx).append(data);
            $('#comment_reply' + commId).append(data);
        },
    });
}


function DBHideReply(commId) {

    document.getElementById('comment_reply' + commId).remove();
    $('#comment_body' + commId).append('<div class="comment_reply' + commId + '" id="comment_reply' + commId + '"></div>');

}

function DBAnwerToComment(commId, idx) {

    let commentArea = document.getElementById("commentInput");
    let answerArea = document.getElementById("answerInput");

    let commentStyles = commentArea.style;
    let answerStyles = answerArea.style;

    answerStyles.display = '';
    commentStyles.display = 'none';

    document.getElementById("commentInputDiv").remove();
    document.getElementById("w-100" + idx).remove();
    document.getElementById("commentErr" + idx).remove();

    $("#input-group" + idx).append('<div class="input-group-append" id="commentInputAnswer"><button type="button" class="btn" style="" type="" onclick="DBAddAnswerComment(' +idx +',' + commId + ')"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" /></svg></button></div>');

    answerArea.focus();

    answerArea.addEventListener(`focusout`, closeTextarea);
    answerArea.addEventListener('click', e => e.stopPropagation());

}


function closeTextarea() {
    let commentArea = document.getElementById("commentInput");
    let answerArea = document.getElementById("answerInput");

    let commentStyles = commentArea.style;
    let answerStyles = answerArea.style;

    answerStyles.display = 'none';
    commentStyles.display = '';
}
