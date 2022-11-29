function DBAddComment(idx) {
    let comment = document.getElementById('commentInputArea' + idx).value;
    if (comment == "") {
        document.getElementById('commentErr' + idx).classList.remove('d-none');
        return;
    }
    if (document.getElementById('commentErr' + idx).classList != 'd-none')
        document.getElementById('commentErr' + idx).classList.add('d-none');
    document.getElementById("commentInputArea" + idx).value = "";
    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        data: {
            com: comment,
            idPost: idx
        },
        success: function (data) {
            let ComIdx = GetCurBDCommCount(idx);
            var today = new Date();
            var now = today.toLocaleString();
            $('#commnet_container' + idx).append(" <div class='comment_body' id='comment_body" + ComIdx + "'><div class='comment_head'>Auther</div><div class='comment_inner'>" + comment + "</div><div class='comment_time'>" + now + "</div><button type='button' id='rpy_btn" + ComIdx + "' value='" + ComIdx + "' class='btn' style='max-width: 100px; color: black; background-color: white; font-size: 13px; ' onclick='DBAnwerToComment(" + ComIdx + ", " + idx + ")'>Ответить</button><div class='d-none' id='comment_reply" + ComIdx + "' style='flex-direction: column;display: flex;padding: 10px;margin-right: 65px;margin-left: 60px;'></div></div>");

        },
    });
}

function GetCurBDCommCount(idx) {
    var res = '';
    $.ajax({
        async: false,
        type: "POST",
        url: 'getBDComCount.php',
        data: {
            idPost: idx
        },
        success: function (data) {
            console.log(data);
            res = data;
        },
    });
    return res;
}

function DBAddAnswerComment(idx, ComIdx) {
    let comment = document.getElementById('answerInputArea' + idx).value;
    if (comment == "") {
        document.getElementById('commentErr' + idx).classList.remove('d-none');
        return;
    }
    if (document.getElementById('commentErr' + idx).classList != 'd-none')
        document.getElementById('commentErr' + idx).classList.add('d-none');
    document.getElementById("answerInputArea" + idx).value = "";


    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        data: {
            com: comment,
            idCom: ComIdx,
            idPost: idx
        },
        success: function (data) {
            console.log(data);
            var today = new Date();
            var now = today.toLocaleString();
            $('#comment_reply' + ComIdx).append("<div class='comment_head'>Author name</div><div class='comment_inner'>" + comment + "</div ><div class='comment_time'>" + now + "<button type = 'button' id = 'answer_btn" + ComIdx + "' value = '" + ComIdx + "' class= 'btn' style = 'max-width: 100px; color: black; background-color: white; font-size: 13px;' onclick = 'DBAnwerToComment(" + ComIdx + ", " + idx + ")'> Ответить </button></div>");

            if (document.getElementById('comment_reply' + ComIdx).classList == 'd-none')
                document.getElementById('comment_reply' + ComIdx).classList.remove('d-none');
            document.getElementById('rpy_btn' + ComIdx).textContent = "Скрыть";
            document.getElementById('rpy_btn' + ComIdx).setAttribute('onclick', 'DBShowReply(' + ComIdx + ',' + idx + ')');

        },
    });
}