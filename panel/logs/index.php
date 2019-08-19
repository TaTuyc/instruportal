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
            function getResponsible() {
                // TO DO найти того, кто последний редактировал инструкцию
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            <div class="text-center">
                <form>
                    <button id="showsearch" type="button" class="btn feedback-btn report-btn" title="Поиск сотрудника, последним изменявшего инструкцию">
                        Поиск ответственного
                    </button>
                    <div id="search" class="new-dir-or-file" style="float: right">
                        <select class="more-padding">
                            <option value="">Раз инструкция</option>
                            <option value="">Два инструкция</option>
                            <option value="">Три инструкция</option>
                        </select>
                        <button type="button" class="btn confirm-btn ok-btn medium-width more-padding" onclick="getResponsible">Найти</button>
                    </div>
                </form>
            </div>
            
            <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                <tbody class="striped text-usual">
                    <tr>
                        <th>№</th>
                        <th>Дата события</th>
                        <th>Событие</th>
                        <th>Пользователь</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>13.08.2019</td>
                        <td>Зашёл, посидел, поседел и ушёл</td>
                        <td>Гость</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>14.08.2019</td>
                        <td>Зашёл, посидел</td>
                        <td>Гость</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>15.08.2019</td>
                        <td>Зашёл</td>
                        <td>Гость</td>
                    </tr>
                </tbody>
            </table>
            
            <?php
                draw_footer(3);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            addLogoutBtn(3);
            setPageLabel("Журнал логов");
            
            document.getElementById('wrapper').onclick = function(e) {
                id = e.target.id;
                
                switch(id) {
                    case 'showsearch':
                        showElem('search');
                        hideElem('showsearch');
                        break;
                    default:
                        break;
                }
            };
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}