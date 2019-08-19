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
            
            <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                <tbody class="striped text-usual">
                    <tr>
                        <th>№</th>
                        <th>Заголовок1</th>
                        <th>Заголовок2</th>
                        <th>Заголовок3</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Данные11</td>
                        <td>Данные12</td>
                        <td>Данные13</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Данные21</td>
                        <td>Данные22</td>
                        <td>Данные23</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Данные3(что за глюки с Komodo..)</td>
                        <td>Данные</td>
                        <td>Данные</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Данные11</td>
                        <td>Данные12</td>
                        <td>Данные13</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Данные21</td>
                        <td>Данные22</td>
                        <td>Данные23</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Данные</td>
                        <td>Данные</td>
                        <td>Данные</td>
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
        </script>
        <?php
            if (isset($_GET['report'])) {
                $report_num = htmlspecialchars($_GET['report']);
                if (is_numeric($report_num)) {
                    switch($report_num) {
                        case '1':
                            $report_name = '\"Самые используемые инструкции\"';
                            break;
                        case '2':
                            $report_name = '\"Устаревшие инструкции\"';
                            break;
                        default:
                            break;
                    }
                    if (isset($report_name)) {
                        echo '<script type="text/javascript">
                                setPageLabel("Отчёт ' . $report_name . '");
                            </script>';
                    }
                }
            }
        ?>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}