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
            function getDeleteConfirmation() {
                var answer = confirm("Удалить выбранные сообщения?\nОтменить это действие будет невозможно.");
                if (answer) {
                    console.log(id + ' --- ' + type);
                    // TO DO удалить
                }
            }
            function getChangeStatusConfirmation() {
                var answer = confirm("Сменить статус выбранных сообщений?");
                if (answer) {
                    console.log(id + ' --- ' + type);
                    // TO DO сменить
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
                <div class="text-center">
                    <button type="button" class="btn feedback-btn report-btn" onclick="getChangeStatusConfirmation();" title="Пометить как исправленные / неисправленные">
                        Сменить статус
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" onclick="getDeleteConfirmation();" title="Удалить выбранные сообщения">
                        Удалить
                    </button>
                </div>
                
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody class="striped text-usual">
                        <tr>
                            <th class="lowly-advanced">
                                <button type="button" class="btn feedback-btn" title="Выделить всё / снять выделение" style="float: left" onclick="mark('marks', 'orientmark');">Все</button>
                            </th>
                            <th>Инструкция</th>
                            <th>Пользователь</th>
                            <th>Дата сообщения</th>
                            <th>Статус</th>
                        </tr>
                        <tr>
                            <td><input id="orientmark" type="checkbox" name="marks" value="1">1</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="2">2</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="3">3</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="4">4</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="5">5</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marks" value="6">6</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
                            <td>Данные</td>
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
            setPageLabel("Сообщения о неточностях в инструкциях");
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}