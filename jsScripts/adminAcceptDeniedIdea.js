function acceptIdea() {

    if (document.getElementById('acceptIdea').classList.contains('d-none')) {
        document.getElementById('acceptIdea').classList.remove('d-none');
    } else {
        document.getElementById('acceptIdea').classList.add('d-none');

    }
    console.log(document.getElementById('end_vote_field').valueAsNumber);

}

function fillInputByTag(idx, postID) {

    document.getElementById('create_new_tag').value = document.getElementById('existTag' + idx).innerText;
    document.getElementById('taqQuestionBtn').value = 0;

    $.ajax({
        type: "POST",
        url: 'tagsAddScript.php',
        data: {
            tagValue: document.getElementById('create_new_tag').value,
            postID: postID

        },
        success: function (data) {
            console.log(data);

        },
    });
}

function createNewTag() {

    if (document.getElementById('taqQuestionBtn').value == 0){
        document.getElementById('taqQuestionBtn').value = 1;
        document.getElementById('taqQuestionBtn').innerText = "Убрать новый тег?";
        document.getElementById('acceptTag').classList.remove('d-none');
        document.getElementById('denyTag').classList.add('d-none');
    }else{
        document.getElementById('taqQuestionBtn').value = 0;
        document.getElementById('taqQuestionBtn').innerText = "Добавить новый тег?";
        document.getElementById('acceptTag').classList.add('d-none');
        document.getElementById('denyTag').classList.remove('d-none');
    }

}

function updateIdea(postID, status) {

    if (!document.getElementById('denyErr').classList.contains('d-none') || !document.getElementById('acceptErr').classList.contains('d-none') || !document.getElementById('timeErr').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
        document.getElementById('acceptErr').classList.add('d-none');
        document.getElementById('timeErr').classList.add('d-none');
    }



    let vote_start = document.getElementById('start_vote_field').value;
    let vote_finish = document.getElementById('end_vote_field').value;


    if (status == 8) {
        vote_start = null;
        vote_finish = null;
        document.getElementById('taqQuestionBtn').value = 1;
    }

    if (vote_start > vote_finish) {
        document.getElementById('timeErr').classList.remove('d-none');
        return 0;
    }

    if (document.getElementById('taqQuestionBtn').value == 0) {
        $.ajax({
            type: "POST",
            url: 'tagsFilterScript.php',
            data: {
                tagValue: document.getElementById('create_new_tag').value,

            },
            success: function (data) {
                console.log(data);
                if (data == '' && document.getElementById('tagQuetion').classList.contains('d-none')) {
                    document.getElementById('tagQuetion').classList.remove('d-none');
                    return 0;
                }

            },
        });
    } else {
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

                if (status == 8 || status == 5) {
                    document.getElementById('denyErr').classList.remove('d-none');
                }
                if (status == 3 || status == 7) {
                    document.getElementById('acceptErr').classList.remove('d-none');

                    let tagValue = document.getElementById('create_new_tag').value;
                    $.ajax({
                        type: "POST",
                        url: 'tagsAddScript.php',
                        data: {
                            postID: postID,
                            tagValue: tagValue
                
                        },
                        success: function (data) {
                            console.log(data);
            
                            
            
                        },
                    });

                }

            },
        });
    }


}




