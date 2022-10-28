function DBAddDislike(idx, isLike, isDislike) {

    $.ajax({
        type: "POST",
        url: 'pushDislikeScript.php',
        data: {
            postId: idx,
            likeBool: isLike, 
            dislikeBool: isDislike
        },
        success: function (data) {
            console.log("kryto");

            if(document.getElementById('dis_btn' + idx).classList == 'btn btn-outline-dark'){
                document.getElementById('dis_btn' + idx).classList.add('btn-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-outline-dark');
                if(document.getElementById('like_btn' + idx).classList == 'btn btn-danger'){
                    document.getElementById('like_btn' + idx).classList.remove('btn-danger');
                    document.getElementById('like_btn' + idx).classList.add('btn-outline-danger');
                }
            }
            else{
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-dark');
            }

        },
    });
}
function DBAddLike(idx, isLike, isDislike) {

    $.ajax({
        type: "POST",
        url: 'pushLikeScript.php',
        data: {
            postId: idx,
            likeBool: isLike, 
            dislikeBool: isDislike
        },
        success: function (data) {
            if(document.getElementById('like_btn' + idx).classList == 'btn btn-outline-danger'){
                document.getElementById('like_btn' + idx).classList.add('btn-danger');
                document.getElementById('like_btn' + idx).classList.remove('btn-outline-danger');
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-dark');
            }
            else{
                document.getElementById('like_btn' + idx).classList.add('btn-outline-danger');
                document.getElementById('like_btn' + idx).classList.remove('btn-danger');
                if(ocument.getElementById('dis_btn' + idx).classList == 'btn btn-danger'){
                    document.getElementById('dis_btn' + idx).classList.remove('btn-dark');
                    document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                }
            }

        },
    });
}