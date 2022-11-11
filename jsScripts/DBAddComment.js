function DBAddComment(idx) {
    let comment = document.getElementById('commentInput' + idx).value;
    if (comment == "") {
        document.getElementById('commentErr').classList.remove('d-none');
        return;
    }
    if (document.getElementById('commentErr').classList != 'd-none')
        document.getElementById('commentErr').classList.add('d-none');
    let id = idx;
    document.getElementById("commentInput" + idx).value = "";
    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        data: {
            com: comment,
            idCom: id
        },
        success: function (data) {
            console.log(data);
            var today = new Date();
            var now = today.toLocaleString();
            $('#commnet_container' + idx).append(" <div class='comment_body' id='comment_body'><div class='comment_head'>Auther</div><div class='comment_inner'>" + comment + "</div><div class='comment_time'>" + now + "</div></div>");

        },
    });
}

function DBAddAnswerComment(idx, ComIdx) {
    let comment = document.getElementById('answerInput').value;
    document.getElementById("answerInput").value = "";
    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        data: {
            com: comment,
            idCom: ComIdx
        },
        success: function (data) {
            console.log(data);
            var today = new Date();
            var now = today.toLocaleString();
            $('#reply_body' + ComIdx).append("<div class='reply_body' id='reply_body" + ComIdx + "'><div class='comment_rply_body' id='comment_body'><div class='comment_head'>Auther</div><div class='comment_inner'>" + comment + "</div> <div class='comment_time'>" + now + "<button type='button' id='answer_btn" + ComIdx + "'class='btn' style='max-width: 100px; color: black; background-color: white; font-size: 13px;' onclick='DBAnwerToComment(" + ComIdx + "," + idx + "Ответить</button></div></div></div>");

        },
    });
}