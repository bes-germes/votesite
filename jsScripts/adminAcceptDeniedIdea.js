function acceptIdea() {

    if (document.getElementById('acceptIdea').classList.contains('d-none')) {
        document.getElementById('acceptIdea').classList.remove('d-none');
    }else{
        document.getElementById('acceptIdea').classList.add('d-none');

    }
    console.log(document.getElementById('end_vote_field').valueAsNumber);

}


function denyIdea(postID, status) {

    $.ajax({
        type: "POST",
        url: 'adminUpdatePostScripd.php',
        data: {
            idPost: postID,
            status: status
        },
        success: function (data) {
            console.log(data);
            document.getElementById('denyErr').classList.remove('d-none');

        },
    });

}




