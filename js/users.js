function getPWArray(arr) {
    var result = [];
    arr.forEach(function(elem) {
        result.push(document.getElementById('pw' + elem).value);
    });
    return result;
}
function getPWUpdateConfirmation() {
    var answer = confirm("Обновить пароли отмеченных пользователей?\nОтменить это действие будет невозможно.");
    if (answer) {
        updatingUsers   = getMarkedElements('marks');
        passwords       = getPWArray(updatingUsers);
        
        // Отправка на сервер для обновления
        if (updatingUsers !== []) {
            var x = $.ajax({
                type: 'POST',
                url: '../../php/ajaxdata.php',
                async: false,
                data: {
                    action: 'update_users',
                    users:  JSON.stringify(updatingUsers),
                    pws:    JSON.stringify(passwords)},
                dataType: "json",
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
}
function getDeleteConfirmation() {
    var answer = confirm("Удалить выбранные учётные записи?\nОтменить это действие будет невозможно.");
    if (answer) {
        deletingUsers = getMarkedElements('marks');
        
        // Отправка на сервер для удаления
        if (deletingUsers !== []) {
            var x = $.ajax({
                type: 'POST',
                url: '../../php/ajaxdata.php',
                async: false,
                data: {
                    action: 'delete_users',
                    users:  JSON.stringify(deletingUsers)},
                dataType: "json",
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
}
function checkPW() {
    var nulogin = document.getElementById('nulogin').value;
    var v1 = document.getElementById('nupw').value;
    var v2 = document.getElementById('nupw2').value;
    if (nulogin == "") {
        alert("Логин не может быть пустым!");
    } else if (v1 != v2) {
        alert("Пароли не совпадают!")
    } else if (v1 == "") {
        alert("Пароль не может быть пустым!")
    } else {
        // Отправка данных для регистрации пользователя
        document.getElementById('newuserform').submit();
    }
}
function getUsers() {
    var x = $.ajax({
        type: 'POST',
        url: '../../php/ajaxdata.php',
        async: false,
        data: {
            fill: 'get_users'},
        dataType: "json",
        success: function(data) {
            var parent  = document.getElementById("alluserstbody");
            var content = '';
            var num     = 0;
            var id      = '';
            var markBtnIsEmpty = true;
            data.forEach(function(item, i, data) {
                num = item[0];
                id = num;
                if (markBtnIsEmpty) {
                    document.getElementById('markallbtn').onclick = function() {
                        mark('marks', id);
                    };
                    markBtnIsEmpty = false;
                }
                content = `<tr>
                    <td><input id="` + id + '" type="checkbox" name="marks" value="' + item[1] + '">' + (i + 1) + `</td>
                    <td>` + item[1] + `</td>
                    <td>
                        <input id="pw` + id + `" type="password" class="fat-elem fat-border no-margin" placeholder="Новый пароль">
                    </td>
                </tr>`;
                parent.insertAdjacentHTML("beforeend", content);
            });
        }
    }).responseText;
}