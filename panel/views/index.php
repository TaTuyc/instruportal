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
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            <div class="text-center">
                <a href="../report/index.php?report=1">
                    <button type="submit" class="btn feedback-btn report-btn" title='Построение отчёта "Самые используемые инструкции"'>
                        Используемые
                    </button>
                </a>
                <a href="../report/index.php?report=2">
                    <button type="submit" class="btn feedback-btn report-btn" title='Построение отчёта "Устаревшие инструкции"'>
                        Устаревшие
                    </button>
                </a>
            </div>
            
            <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                <tbody class="striped text-usual">
                    <tr>
                        <th>№</th>
                        <th>Дата просмотра</th>
                        <th>Пользователь</th>
                        <th>Инструкция</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>13.08.2019</td>
                        <td>Гость</td>
                        <td>))</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>14.08.2019</td>
                        <td>Гость</td>
                        <td>)))</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>15.08.2019</td>
                        <td>Гость</td>
                        <td>))))</td>
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
            setPageLabel("Журнал просмотров");
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}