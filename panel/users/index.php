<?php
include_once '../../php/iface.php';
include_once '../../php/common.php';

if (isset($_POST['instruportal_logout'])) {
    unset($_SESSION['instruportal_user']);
    header('Location: ../../index.php');
}
if (isset($_SESSION['instruportal_user'])) {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Портал инструкций</title>
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <script type="text/javascript" src="../../js/const.js"></script>
        <script type="text/javascript" src="../../js/common.js"></script>
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
                    // TO DO удалить
                }
            }
            
            function checkPW() {
                if (document.getElementById('pw1').value != document.getElementById('pw2').value) {
                    alert("Пароли не совпадают!")
                } else {
                    // TO DO записать уч.данные
                }
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            <form method="post" action="../../php/common.php">
                <div class="text-center" style="float: left">
                    <button type="button" class="btn feedback-btn report-btn" name="addusers" onclick="showElem('newuser');" title="Создание учётной записи">
                        Создать
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" name="saveusers" onclick="getPWUpdateConfirmation();" title="Сохранить внесённые изменения">
                        Обновить пароли
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" name="deleteusers" onclick="getDeleteConfirmation();" title="Удалить выбранные учётные записи">
                        Удалить
                    </button>
                </div>
                
                <div id="newuser" class="medium-width" style="float: right; margin: 0.5rem">
                    <table class="no-border">
                        <tbody>
                            <tr>
                                <td><input type="text" class="fat-elem fat-border no-margin" placeholder="Логин учётной записи"></td>
                                <td><input id="pw1" type="password" class="fat-elem fat-border no-margin" placeholder="Пароль"></td>
                                <td><input id="pw2" type="password" class="fat-elem fat-border no-margin" placeholder="Пароль (ещё раз)"></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn confirm-btn ok-btn medium-width more-padding" onclick="checkPW();" title="Записать учётную запись в базу данных">Создать</button>
                </div>
                
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody class="striped text-usual">
                        <tr>
                            <th class="lowly-advanced">
                                <button type="button" class="btn feedback-btn lowly" title="Выделить всё / снять выделение" style="float: left" onclick="mark('marks', 'orientmark');">Все</button>
                            </th>
                            <th>Пользователь</th>
                            <th>Новый пароль</th>
                        </tr>
                        <tr>
                            <td><input id="orientmark" type="checkbox" name="marks" value="1">1</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="2">2</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="3">3</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="4">4</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="5">5</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="6">6</td>
                            <td>Данные</td>
                            <td>
                                <input type="text" class="fat-elem fat-border no-margin" placeholder="Значение параметра">
                            </td>
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
            setPageLabel("Настройка связей с конфигурациями 1С");
            hideElem('newuser');
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}