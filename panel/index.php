<?php
include_once '../php/iface.php';
include_once '../php/common.php';

if (isset($_POST['instruportal_logout'])) {
    unset($_SESSION['instruportal_user']);
    header('Location: ../index.php');
}
if (isset($_SESSION['instruportal_user'])) {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Портал инструкций</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script type="text/javascript" src="../js/const.js"></script>
        <script type="text/javascript" src="../js/common.js"></script>
        <script type="text/javascript">
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(2);
            ?>
            
            <div class="text-center">
                <a href="./instr/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Выгрузка оригиналов для изменения, загрузка новых инструкций, создание папок">
                        Управление инструкциями
                    </button>
                </a>
                <a href="./logs/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Все создания и изменения папок / инструкций, построение отчётов">
                        Журнал логов
                    </button>
                </a>
                <a href="./views/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Просмотры инструкций сотрудниками, построение отчётов">
                        Журнал просмотров
                    </button>
                </a>
                <a href="./feedback/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Просмотр сообщений о неточностях в инструкциях, управление списком сообщений">
                        Сообщения об ошибках
                    </button>
                </a>
                <a href="./settings/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Настройка параметров работы портала (ведение логов, поддержка IE6 и др.)">
                        Настройки портала
                    </button>
                </a>
                <a href="./sync/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Настройка связей инструкций с объектами конфигурации">
                        Синхронизация с 1С
                    </button>
                </a>
                <a href="./users/index.php">
                    <button type="button" class="btn confirm-btn panel-btn" title="Обновление паролей и удаление учётных записей">
                        Управление учётными записями
                    </button>
                </a>
            </div>
            
            <?php
                draw_footer(2);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            addLogoutBtn(2);
        </script>
    </body>
</html>
<?php
} else {
    header('Location: ../index.php');
}