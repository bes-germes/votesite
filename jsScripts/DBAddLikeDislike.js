function DBAddDislike(idx) {

    // if (!isLike && isDislike){
    //     isLike = !isLike;
    // }

    // if (!isLike && !isDislike){
    //     isLike = !isLike;
    // }

    var isLike = document.getElementById('like_btn' + idx).value
    var isDislike = document.getElementById('dis_btn' + idx).value

    if (isLike == 1)
        isLike = 0;

    if (isDislike == 0)
        isDislike = -1;
    else {
        isDislike = 0;
    }

    $.ajax({
        type: "POST",
        url: 'pushDislikeScript.php',
        data: {
            postId: idx,
            likeBool: isLike,
            dislikeBool: isDislike
        },
        success: function (data) {
            console.log(data);

            if (document.getElementById('dis_btn' + idx).classList == 'btn btn-outline-danger') {
                document.getElementById('dis_btn' + idx).classList.add('btn-danger');
                document.getElementById('dis_btn' + idx).classList.remove('btn-outline-danger');
                if (document.getElementById('like_btn' + idx).classList == 'btn btn-success') {
                    document.getElementById('like_btn' + idx).classList.remove('btn-success');
                    document.getElementById('like_btn' + idx).classList.add('btn-outline-success');
                }
                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = -1;
            }
            else {
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-danger');
                document.getElementById('dis_btn' + idx).classList.remove('btn-danger');

                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = 0;
            }
            // location.reload();

        },
    });
}
function DBAddLike(idx) {


    var isLike = document.getElementById('like_btn' + idx).value
    var isDislike = document.getElementById('dis_btn' + idx).value

    if (isDislike == -1)
        isDislike = 0;

    if (isLike == 0)
        isLike = 1;
    else {
        isLike = 0;
    }

    $.ajax({
        type: "POST",
        url: 'pushLikeScript.php',
        data: {
            postId: idx,
            likeBool: isLike,
            dislikeBool: isDislike
        },
        success: function (data) {
            console.log(data);

            if (document.getElementById('like_btn' + idx).classList == 'btn btn-outline-success') {
                document.getElementById('like_btn' + idx).classList.add('btn-success');
                document.getElementById('like_btn' + idx).classList.remove('btn-outline-success');
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-danger');
                document.getElementById('dis_btn' + idx).classList.remove('btn-danger');
                document.getElementById('like_btn' + idx).value = 1;
                document.getElementById('dis_btn' + idx).value = 0;
            }
            else {
                document.getElementById('like_btn' + idx).classList.add('btn-outline-success');
                document.getElementById('like_btn' + idx).classList.remove('btn-success');
                if (document.getElementById('dis_btn' + idx).classList == 'btn btn-success') {
                    document.getElementById('dis_btn' + idx).classList.remove('btn-danger');
                    document.getElementById('dis_btn' + idx).classList.add('btn-outline-danger');
                    document.getElementById('like_btn' + idx).value = false;
                }
                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = 0;
            }

        },
    });
}