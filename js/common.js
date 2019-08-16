function showHide(id) {
    if (document.getElementById(id).style.display == 'none') {
        document.getElementById(id).style.display = 'block';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}
function showElem(id) {
    //console.log("tried:   " + id);
    var elem = document.getElementById(id);
    if (elem != null) {
        elem.style.display = 'block';
    }
}
function hideElem(id) {
    var elem = document.getElementById(id);
    if (elem != null) {
        elem.style.display = 'none';
    }
}
function setPageLabel(text) {
    var elem = document.getElementById('pagelabel');
    if (elem != null) {
        elem.innerHTML = text;
    }
}