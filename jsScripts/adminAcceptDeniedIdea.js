function acceptIdea() {

    if (document.getElementById('acceptIdea').classList.contains('d-none')) {
        document.getElementById('acceptIdea').classList.remove('d-none');
    } else {
        document.getElementById('acceptIdea').classList.add('d-none');

    }
    console.log(document.getElementById('end_vote_field').valueAsNumber);

}


function updateIdea(postID, status) {

    if (!document.getElementById('denyErr').classList.contains('d-none') || !document.getElementById('acceptErr').classList.contains('d-none') || !document.getElementById('timeErr').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
        document.getElementById('acceptErr').classList.add('d-none');
        document.getElementById('timeErr').classList.add('d-none');
    } 

    let vote_start = document.getElementById('start_vote_field').value;
    let vote_finish = document.getElementById('end_vote_field').value;

    if (vote_start >= vote_finish){
        document.getElementById('timeErr').classList.remove('d-none');
        return 0;
    }
    if (status == 8) {
        vote_start = 0;
        vote_finish = 0;
    }
    $.ajax({
        type: "POST",
        url: 'adminUpdatePostScripd.php',
        data: {
            idPost: postID,
            status: status,
            vote_start: vote_start,
            vote_finish: vote_finish
        },
        success: function (data) {
            console.log(data);

            if (status == 8) {
                document.getElementById('denyErr').classList.remove('d-none');
            }
            if (status == 3) {
                document.getElementById('acceptErr').classList.remove('d-none');
            }
        },
    });

}




