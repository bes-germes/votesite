function DBAddComment(idx) {
    let comment = document.getElementById('commentInput' + idx).value;
    if (comment == ""){
        document.getElementById('commentErr').classList.remove('d-none');
        return;
    }
    if(document.getElementById('commentErr').classList != 'd-none')
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
            console.log(data.idCom);
            var today = new Date();
            var now = today.toLocaleString();
            var curCom = data.com;
            $('#commnet_container' + idx).append(" <div class='comment_body' id='comment_body'><div class='comment_head'>Auther</div><div class='comment_inner'>" + comment + "</div><div class='comment_time'>" + now + "</div></div>");

        },
    });
}