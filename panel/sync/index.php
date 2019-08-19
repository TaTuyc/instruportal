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
            
            function insertNewSelect(idParent) {
                parent = document.getElementById(idParent);
                if (parent != null) {
                    id = getIdForInsElem(idParent, parent.innerHTML);
                    newSelect = '<select class="more-padding big-width"><option value="">Данные</option></select>\n';
                    newDelBtn = '<button type="button" class="btn remove-btn small-width-less lowly-advanced" onclick="removeElem(\'' + id + '\');">Открепить</button>';
                    content = '<div id="' + id + '">' + newSelect + newDelBtn + '</div>';
                    parent.insertAdjacentHTML("beforeend", content);
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
                    <button type="submit" class="btn feedback-btn report-btn" name="saverelations" title="Сохранить внесённые изменения">
                        Сохранить
                    </button>
                </div>
                
                <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                    <tbody class="striped text-usual left-upper">
                        <tr>
                            <th>№</th>
                            <th>Инструкция</th>
                            <th>Объекты назначения</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Данные</td>
                            <td id="ins1">
                                <button type="button" class="btn confirm-btn medium-width-less lowly-advanced more-margin narrow" onclick="insertNewSelect('ins1');">Добавить объект</button>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Данные</td>
                            <td id="objfor2">Данные</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Данные</td>
                            <td id="objfor3">Данные</td>
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
            setPageLabel("Настройка связей с конфигурациями 1С");
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}