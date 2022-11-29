function DBaddReq() {
    let title_req = document.getElementById('title_req').value;
    let text_req = document.getElementById('text_req').value;
    if (title_req == "") {
        document.getElementById('titleErr').classList.remove('d-none');
        return;
    }
    if (text_req == "") {
        document.getElementById('descrErr').classList.remove('d-none');
        return;
    }
    if (document.getElementById('titleErr').classList != 'd-none')
        document.getElementById('titleErr').classList.add('d-none');
    if (document.getElementById('descrErr').classList != 'd-none') {
        document.getElementById('descrErr').classList.add('d-none');
    }

    var inputFile = document.getElementById('formFile').value;
    var curFiles = inputFile.files;

    var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
    if (!re.exec(inputFile)) {
        alert("Вы не выбрали картинку!");

    }

    
}

