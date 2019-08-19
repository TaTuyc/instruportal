function showHide(id) {
    if (document.getElementById(id).style.display == 'none') {
        document.getElementById(id).style.display = 'block';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}
function showElem(id) {
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
function mark(checkboxName, checkboxOrient) {
    var orient = document.getElementById(checkboxOrient);
    if (orient != null) {
        var value = !orient.checked;
        var clist = document.getElementsByName(checkboxName);
        for (var i = 0; i < clist.length; i++) {
            clist[i].checked = value;
        }
    }
}
function getIdForInsElem(insId, insInnerHTML) {
    var elems = insInnerHTML.match(/_elem\d+/g);
    var maxId = 0;
    if (elems != null) {
        elems.forEach(function(element) {
            id = Number(element.substr(5));
            if (id > maxId) {
                maxId = id;
            }
        });
    }
    maxId++;
    if (insId != null) {
        return insId + '_elem' + maxId;
    } else {
        return maxId;
    }
}
function removeElem(id) {
    document.getElementById(id).parentNode.removeChild(document.getElementById(id));
}