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

    var inputElements = document.getElementsByName('form-check-input');

    if (document.getElementById('flexSwitchCheckDefaultAll').checked) {
        for (var i = 0; inputElements[i]; ++i) {
            inputElements[i].checked = true;
            inputElements[i].setAttribute('disabled', '');
        }
    } else {
        for (var i = 0; inputElements[i]; ++i) {
            inputElements[i].checked = false;
            inputElements[i].removeAttribute('disabled');
        }
    }



}


function addExecuters(action) {
    
    let result = [];
    let leaderErr = false;
    var inputElements = document.getElementsByName('form-check-input');
    for (var i = 0; inputElements[i]; ++i) {
        if (inputElements[i].checked) {
            if (document.getElementById('flexSwitchCheckDefaultLeader' + i).checked){
                user = {
                    hash: inputElements[i].value,
                    role: '2'
                }
                leaderErr = true;
                result.push(user);
            }else{
                user = {
                    hash: inputElements[i].value,
                    role: '1'
                }
                result.push(user);
            }
        }
    }
    // let arrLeader = [];
    // var inputElementsLeader = document.getElementsByName('form-check-input-leader');
    // for (var i = 0; inputElementsLeader[i]; ++i) {
    //     if (inputElementsLeader[i].checked) {
    //         user = {
    //             hash: '',
    //             role: '2'
    //         }
    //         user.hash 
    //          = inputElementsLeader[i].value;
    //     }
    // }

    if (!leaderErr) {
        document.getElementById('leaderErr').classList.remove('d-none');
        return;
    }

    if (result.length <= 0) {

        document.getElementById('denyErr').classList.remove('d-none');
        return;
    }

    if (!document.getElementById('denyErr').classList.contains('d-none') || !document.getElementById('leaderErr').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
        document.getElementById('leaderErr').classList.add('d-none');
    }

    


    let freetry_start = document.getElementById('start_freetry_field').value;
    let freetry_finish = document.getElementById('end_freetry_field').value;

    if (freetry_start >= freetry_finish || freetry_start == '' || freetry_finish == ''){
        document.getElementById('timeErr').classList.remove('d-none');
        return 0;
    }

    $.ajax({
        type: "POST",
        url: 'wantToBeExuterScript.php',
        data: {
            postId: action,
            arr: result,
            freetry_start: freetry_start,
            freetry_finish: freetry_finish

        },
        success: function (data) {
            console.log(data);

            if (document.getElementById('acceptErr').classList.contains('d-none')) {
                document.getElementById('acceptErr').classList.remove('d-none');
            } else {
                document.getElementById('acceptErr').classList.add('d-none');

            }
        },
    });

}


function addExecuterLeader(idx) {

    var inputElements = document.getElementsByName('form-check-input-leader');

    for (var i = 0; inputElements[i]; ++i) {
        if (i == idx) {
            document.getElementById('flexSwitchCheckDefaultLeader' + i).checked = true;
        } else {
            document.getElementById('flexSwitchCheckDefaultLeader' + i).checked = false;
        }
    }

}