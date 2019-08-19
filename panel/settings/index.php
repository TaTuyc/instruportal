<?php
    include_once '../../php/iface.php';
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
            function getResetSettingConfirmation() {
                var answer = confirm("Сбросить выделенные настройки к значениям по умолчанию?\nОтменить это действие будет невозможно.");
                if (answer) {
                    console.log(id + ' --- ' + type);
                    // TO DO сбросить
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
                    <button type="submit" class="btn feedback-btn report-btn" name="savesettings" title="Сохранить внесённые изменения">
                        Сохранить
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" onclick="getResetSettingConfirmation();" title="Сбросить настройки к значениям по умолчанию">
                        Сбросить
                    </button>
                </div>
                
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody class="striped text-usual">
                        <tr>
                            <th class="lowly-advanced">
                                <button type="button" class="btn feedback-btn lowly" title="Выделить всё / снять выделение" style="float: left" onclick="mark('marks', 'orientmark');">Все</button>
                            </th>
                            <th>Параметр</th>
                            <th>Значение</th>
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
            <?php
                draw_footer(3);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            setPageLabel("Настройки портала инструкций");
            hideElem('feedbackbtn');
        </script>
    </body>
</html>