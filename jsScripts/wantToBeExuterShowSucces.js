function wantToBeExuterShowSucces(action) {



    $.ajax({
        type: "POST",
        url: 'wantToBeExuterScript.php',
        data: {
            postId: action
        },
        success: function (data) {
            console.log(data);
            if (data == "Вы уже оставили заявку") {

                if (document.getElementById('errExecutor').classList.contains('d-none')) {
                    document.getElementById('errExecutor').classList.remove('d-none');
                } else {
                    document.getElementById('errExecutor').classList.add('d-none');

                }
            } else {
                if (document.getElementById('succes').classList.contains('d-none')) {
                    document.getElementById('succes').classList.remove('d-none');
                    document.getElementById('acceptCancelbuttons').classList.add('d-none');
                } else {
                    document.getElementById('succes').classList.add('d-none');

                }
            }
        },
    });

}

function chooseAll() {
    if (document.getElementById('flexSwitchCheckDefaultAll').checked) {
        $(".form-check-input").prop("checked", true);
    } else {
        $(".form-check-input").prop("checked", false);
    }
}


function addExecuters(action) {

    let arr = [];

    var inputElements = document.getElementsByClassName('form-check-input');
    for (var i = 0; inputElements[i]; ++i) {
        if (inputElements[i].checked) {
            arr[i] = inputElements[i].value;
        }
    }

    if (arr.length <= 0) {

        document.getElementById('denyErr').classList.remove('d-none');

        return;
    }

    if (!document.getElementById('denyErr').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
    }

    arr.pop();

    $.ajax({
        type: "POST",
        url: 'wantToBeExuterScript.php',
        data: {
            postId: action,
            arr: arr

        },
        success: function (data) {
            // console.log(data);
        
            if (document.getElementById('acceptErr').classList.contains('d-none')) {
                document.getElementById('acceptErr').classList.remove('d-none');
            } else {
                document.getElementById('acceptErr').classList.add('d-none');
        
            }
        },
    });

}
