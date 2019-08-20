<?php
include_once '../../php/iface.php';
include_once '../../php/common.php';

if (isset($_POST['instruportal_logout'])) {
    unset($_SESSION['instruportal_user']);
    header('Location: ../../index.php');
}
if (isset($_SESSION['instruportal_user'])) {
    $pdo = connect_db();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Портал инструкций</title>
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <script type="text/javascript" src="../../js/const.js"></script>
        <script type="text/javascript" src="../../js/common.js"></script>
        <script type="text/javascript" src="../../jquery/jquerymin.js"></script>
        <script type="text/javascript">
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
            
            function getPWUpdateConfirmation() {
                var answer = confirm("Обновить пароли?\nОтменить это действие будет невозможно.");
                if (answer) {
                    // TO DO обновить
                }
            }
            
            function getDeleteConfirmation() {
                var answer = confirm("Удалить выбранные учётные записи?\nОтменить это действие будет невозможно.");
                if (answer) {
                    allUsers = document.getElementsByName('marks');
                    deletingUsers = [];
                    
                    // Формирование массива, состоящего из значений первичного ключа (хранятся в id), для отправки на сервер и последующего удаления
                    allUsers.forEach(function(user) {
                        if (user.checked) {
                            deletingUsers.push(user.id);
                        }
                    });
                    
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
                                    <input id="pw` + id + `" type="text" class="fat-elem fat-border no-margin" placeholder="Новый пароль">
                                </td>
                            </tr>`;
                            parent.insertAdjacentHTML("beforeend", content);
                        });
                    }
                }).responseText;
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            
            <div class="text-center" style="float: left">
                <button type="button" class="btn feedback-btn report-btn" name="addusers"       onclick="showElem('newuser');"          title="Создание учётной записи">
                    Создать
                </button>
                <button type="button" class="btn feedback-btn report-btn" name="saveusers"      onclick="getPWUpdateConfirmation();"    title="Сохранить внесённые изменения">
                    Обновить пароли
                </button>
                <button type="button" class="btn feedback-btn report-btn" name="deleteusers"    onclick="getDeleteConfirmation();"      title="Удалить выбранные учётные записи">
                    Удалить
                </button>
            </div>
            
            <form id="newuserform" method="post" action="../../php/common.php">
                <div id="newuser" class="medium-width" style="float: right; margin: 0.5rem">
                    <table class="no-border">
                        <tbody>
                            <tr>
                                <td><input id="nulogin"   type="text"     class="fat-elem fat-border no-margin" name="nulogin"  placeholder="Логин учётной записи"></td>
                                <td><input id="nupw"      type="password" class="fat-elem fat-border no-margin" name="nupw"     placeholder="Пароль"></td>
                                <td><input id="nupw2"     type="password" class="fat-elem fat-border no-margin" name="nupw2"    placeholder="Пароль (ещё раз)"></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn confirm-btn ok-btn medium-width more-padding" onclick="checkPW();" title="Записать учётную запись в базу данных">Создать</button>
                </div>
            </form>
            
            <form id="allusersform" method="post" action="../../php/common.php">    
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody id="alluserstbody" class="striped text-usual">
                        <tr>
                            <th class="lowly-advanced">
                                <button id="markallbtn" type="button" class="btn feedback-btn lowly" title="Выделить всё / снять выделение" style="float: left">Все</button>
                            </th>
                            <th>Пользователь</th>
                            <th>Новый пароль</th>
                        </tr>                  
                    </tbody>
                </table>
            </form>
            
            <?php
                draw_footer(3);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            addLogoutBtn(3);
            setPageLabel("Управление учётными записями");
            hideElem('newuser');
            
            getUsers();
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}