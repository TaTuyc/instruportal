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
        <script type="text/javascript" src="../../jquery/jquerymin.js"></script>
        <script type="text/javascript">
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
            
            function getSettings() {
                var x = $.ajax({
                    type: 'POST',
                    url: '../../php/ajaxdata.php',
                    async: false,
                    data: {
                        fill: 'get_settings'},
                    dataType: "json",
                    success: function(data) {
                        var parent  = document.getElementById("allsettingstbody");
                        var content = '';
                        var num     = 0;
                        var id      = '';
                        data.forEach(function(item, i, data) {
                            num = item[0];
                            id = num;
                            content = `<tr>
                                <td>` + (i + 1) + `</td>
                                <td>` + item[1] + `</td>
                                <td>
                                    <input id="value` + id + `" type="text" class="fat-elem fat-border no-margin" name="values" value="` + item[2] + `" placeholder="Значение">
                                </td>
                            </tr>`;
                            parent.insertAdjacentHTML("beforeend", content);
                        });
                    }
                }).responseText;
            }
            
            function getResetSettingConfirmation() {
                var answer = confirm("Сбросить все настройки к значениям по умолчанию?\nОтменить это действие будет невозможно.");
                if (answer) {
                    var x = $.ajax({
                        type: 'POST',
                        url: '../../php/ajaxdata.php',
                        async: false,
                        data: {
                            action: 'reset_settings'},
                        dataType: "json",
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            }
                        
            function saveSettings() {
                var values      = document.getElementsByName('values');
                var newSettings = [];
                values.forEach(function(value) {
                    newSettings.push([
                        value.id.substring(5),
                        value.value
                    ]);
                });
                var x = $.ajax({
                    type: 'POST',
                    url: '../../php/ajaxdata.php',
                    async: false,
                    data: {
                        action:     'update_settings',
                        settings:   JSON.stringify(newSettings)},
                    dataType: "json",
                    success: function(data) {
                        location.reload();
                    }
                });
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
                    <button type="button" class="btn feedback-btn report-btn" name="savesettings" onclick="saveSettings()" title="Сохранить внесённые изменения">
                        Сохранить
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" onclick="getResetSettingConfirmation();" title="Сбросить настройки к значениям по умолчанию">
                        Сбросить
                    </button>
                </div>
                
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody id="allsettingstbody" class="striped text-usual">
                        <tr>
                            <th></th>
                            <th>Параметр</th>
                            <th>Значение</th>
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
            setPageLabel("Настройки портала инструкций");
            
            getSettings();
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}