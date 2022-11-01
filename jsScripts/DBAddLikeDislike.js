function DBAddDislike(idx) {

    // if (!isLike && isDislike){
    //     isLike = !isLike;
    // }

    // if (!isLike && !isDislike){
    //     isLike = !isLike;
    // }

    if(document.getElementById('like_btn' + idx).value == 1)
        var isLike = "true";
    else
        var isLike = "false";

    if(document.getElementById('dis_btn' + idx).value == 1)
        var isDislike = "true";
    else
        var isDislike = "false";

    if(isLike === "true")
        isLike = "false";

    if(isDislike === 'false')
        isDislike = "true";
    else
        isDislike = "false";
        
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

            if(document.getElementById('dis_btn' + idx).classList == 'btn btn-outline-dark'){
                document.getElementById('dis_btn' + idx).classList.add('btn-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-outline-dark');
                if(document.getElementById('like_btn' + idx).classList == 'btn btn-danger'){
                    document.getElementById('like_btn' + idx).classList.remove('btn-danger');
                    document.getElementById('like_btn' + idx).classList.add('btn-outline-danger');
                }
                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = 1;
            }
            else{
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-dark');

                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = 0;
            }
            // location.reload();

        },
    });
}
function DBAddLike(idx) {

    
    if(document.getElementById('like_btn' + idx).value == 1)
        var isLike = "true";
    else
        var isLike = "false";

    if(document.getElementById('dis_btn' + idx).value == 1)
        var isDislike = "true";
    else
        var isDislike = "false";

    if(isDislike === "true")
        isDislike = "false";

    if(isLike === 'false')
        isLike = "true";
    else
        isLike = "false";

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
            
            if(document.getElementById('like_btn' + idx).classList == 'btn btn-outline-danger'){
                document.getElementById('like_btn' + idx).classList.add('btn-danger');
                document.getElementById('like_btn' + idx).classList.remove('btn-outline-danger');
                document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                document.getElementById('dis_btn' + idx).classList.remove('btn-dark');
                document.getElementById('like_btn' + idx).value = 1;
                document.getElementById('dis_btn' + idx).value = 0;
            }
            else{
                document.getElementById('like_btn' + idx).classList.add('btn-outline-danger');
                document.getElementById('like_btn' + idx).classList.remove('btn-danger');
                if(document.getElementById('dis_btn' + idx).classList == 'btn btn-danger'){
                    document.getElementById('dis_btn' + idx).classList.remove('btn-dark');
                    document.getElementById('dis_btn' + idx).classList.add('btn-outline-dark');
                    document.getElementById('like_btn' + idx).value = false;
                }
                document.getElementById('like_btn' + idx).value = 0;
                document.getElementById('dis_btn' + idx).value = 0;
            }

        },
    });
}