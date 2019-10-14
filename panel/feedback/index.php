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
        <script type="text/javascript" src="../../js/fbmessages.js"></script>
        <script type="text/javascript" src="../../jquery/jquerymin.js"></script>
        <script type="text/javascript">
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            <div class="text-center">
                <button type="button" class="btn feedback-btn report-btn" onclick="getChangeStatusConfirmation();" title="Пометить как исправленные / неисправленные">
                    Сменить статус
                </button>
                <button type="button" class="btn feedback-btn report-btn" onclick="getDeleteConfirmation();" title="Удалить выбранные сообщения">
                    Удалить
                </button>
            </div>
            
            <form id="allfbmform" method="post" action="../../php/common.php">
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody>
                        <tr>
                            <th class="lowly-advanced">
                                <button id="markallbtn" type="button" class="btn feedback-btn" title="Выделить всё / снять выделение" style="float: left">Все</button>
                            </th>
                            <th>Инструкция</th>
                            <th>Пользователь</th>
                            <th>Дата сообщения</th>
                            <th>Текст сообщения</th>
                            <th>Статус</th>
                        </tr>
                    </tbody>
                    <tbody id="allfbmtbody" class="striped text-usual">
                    </tbody>
                </table>
            </form>
            
            <div class="text-center">
                <button id="morebtn" class="btn confirm-btn ok-btn small-width more-padding" onclick="getMoreNotes();" value="null">
                    Загрузить ещё
                </button>
            </div>
            
            <?php
                draw_footer(3);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            addLogoutBtn(3);
            setPageLabel("Сообщения о неточностях в инструкциях");
            
            // При загрузке страницы отобразить в таблице сообщений первую страницу результатов
            getFBMessages(1);
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}