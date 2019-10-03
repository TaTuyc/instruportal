<?php
    include_once './php/common.php';
    include_once './php/iface.php';
    //$fs = get_fs_tree('/home/gull/vm/Лабы/5С/Сети/2');
    //echo print_r($fs);
    /*?>
    <p>А сейчас посмотрим список доступных драйверов!
    <p>
    <?php
    echo print_r(PDO::getAvailableDrivers());
    ?>
    <p>Содержимое переменной $_SERVER
    <?php
    echo var_dump($_SERVER);*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Портал инструкций</title>
        <link rel="stylesheet" href="./css/bootstrap.css">
        <script type="text/javascript" src="./js/const.js"></script>
        <script type="text/javascript" src="./js/common.js"></script>
        <script type="text/javascript" src="./jquery/jquerymin.js"></script>
        <script type="text/javascript">
            function sendFeedback(str_default) {
                usranswer = prompt('Введите краткое описание ошибки в инструкции с указанием пункта:', str_default);
                if (usranswer != '' && usranswer != null) {
                    if (usranswer.length > const_feedback_length) {
                        alert('Слишком длинное сообщение (больше ' + const_feedback_length + ' символов). Пожалуйста, введите ещё раз.');
                        sendFeedback(usranswer.substring(0, 535));
                    } else {
                        insId = document.getElementById('insid').value;
                        var x = $.ajax({
                            type: 'POST',
                            url: './php/ajaxdata.php',
                            async: false,
                            data: {
                                action:     'set_feedback',
                                ID_ins:     insId,
                                feedback:   usranswer},
                            dataType: "json",
                            success: function(data) {
                                alert("Сообщение передано! Спасибо за отзыв!");
                            }
                        }).responseText;
                    }
                }
            }
            
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
            
            function open_ins(id, is_ie) {
                // Перезагрузка ресурса для фрейма
                document.getElementById('ins_content').setAttribute('src', './binarydata.php?id=' + id + '&ie=' + is_ie);
                // Запись служебных данных, id инструкции (необходимо для отправки Соообщения об ошибке)
                document.getElementById('insid').value = String(id);
                // Установка заголовка инструкции на странице
                var newHeader = document.getElementById('a' + id).innerHTML;
                document.getElementById('ins_header').innerHTML = newHeader;
                // Разблокировка кнопки "Сообщить об ошибке"
                showElem('feedbackbtn');
            }
            
            function unwrapElem(element, parentId, display, is_ie) {
                var parent = document.getElementById(parentId);
                var newNode = '';
                
                var id          = element.id;
                var name        = element.name;
                var children    = element.children;
                
                switch(element.type) {
                    case 'dir':
                        newNode =
                            `<a href="#" onclick="showHide('c` + id +`');">` + name + `</a>
                            <ul id="c` + id + `" style="display: ` + display + `" name="` + name + `"></ul><br>`;
                        parent.insertAdjacentHTML("beforeend", newNode);
                        
                        if (children != null) {
                            children.forEach(function(el) {
                                unwrapElem(el, 'c' + id, 'none', is_ie);
                            });
                        }
                        break;
                    case 'file':
                        newNode =
                            `<li id="li` + id + `"><a id="a` + id + `" onclick="open_ins(` + id + `,` + is_ie + `);" title="Нажмите, чтоб открыть инструкцию">` + name + `</a>
                            </li>`;
                        parent.insertAdjacentHTML("beforeend", newNode);
                        break;
                }
            }
            
            function getConfTree(idConf, is_ie) {
                var x = $.ajax({
                    type: 'POST',
                    url: './php/ajaxdata.php',
                    async: false,
                    data: {
                        fill:    'get_conf_tree',
                        ID_conf: idConf},
                    dataType: "json",
                    success: function(data) {
                        
                        data.forEach(function(element) {
                            // Разворачивание дерева от корневого каталога инструкций конфигурации (Configuration tree)
                            unwrapElem(element, 'conftree', 'block', is_ie);
                        });
                    }
                }).responseText;
            }
            
            // Получение списка доступных конфигураций
            function getConfList() {
                var x = $.ajax({
                    type: 'POST',
                    url: './php/ajaxdata.php',
                    async: false,
                    data: {
                        fill: 'get_conf_list'},
                    dataType: "json",
                    success: function(data) {
                        var parent  = document.getElementById('confisemptyselect');
                        var newNode = '';
                        data.forEach(function(element) {
                            newNode = '<option value="' + element.id + '">' + element.name;
                            parent.insertAdjacentHTML("beforeend", newNode);
                        });
                        showElem('confisempty');
                        hideElem('feedbackbtn');
                    }
                }).responseText;
            }
            
            // Определение конфигурации, разворачивание её дерева
            function setConfAndGetConfTree() {
                var confId = document.getElementById('confisemptyselect').value;
                getConfTree(confId, document.getElementById('isie').value);
                hideElem('confisempty');
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(1);
            ?>
            
            <table class="bhi text-char-middle" style="width: 100%">
                <tbody style="text-align: justify; vertical-align: top">
                    <tr>
                        <td id="conftree" style="width: 30%; padding-right: 1rem !important">
                            <!-- Блок выбора конфигурации из списка существующих -->
                            <div id="confisempty" style="display: none">
                                <p class="warning-info">Конфигурация не определена!<br>Выберите из списка:</p>
                                <select id="confisemptyselect" class="text-char-middle">
                                </select>
                                <button class="btn confirm-btn ok-btn medium-width" onclick="setConfAndGetConfTree();">ОК</button>
                            </div>
                            
                            <input id="insid" type="hidden" value="<?php
                                if (isset($_GET['id'])) {
                                    echo htmlspecialchars($_GET['id']);
                                }
                            ?>">
                            <input id="isie" type="hidden" value="<?php
                                $is_ie = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11:0') !== false;
                                if ($is_ie) {
                                    echo 'true';
                                } else {
                                    echo 'false';
                                }
                            ?>">
                        </td>
                        
                        <td>
                            <p id="ins_header" class="text-char-larger text-center text-add-padding"></p>
                            <iframe id="ins_content" src="./binarydata.php<?php
                                if (isset($_GET['id'])) {
                                    $id = htmlspecialchars($_GET['id']);
                                    echo "?id=$id";
                                    $is_ie = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11:0') !== false;
                                    if ($is_ie) {
                                        echo '&ie=true';
                                    } else {
                                        echo '&ie=false';
                                    }
                                }
                            ?>" style="width: 100%; height: 29.8cm"></iframe>
                            <a id="videoins"></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <?php
                draw_footer(1);
            ?>
        </div>
        <script type="text/javascript">
            setByConst();
            <?php
                if (isset($_GET['id'])) {
                    $ins_id     = htmlspecialchars($_GET['id']);
                    $conf_id    = get_conf_id_by_ins_id($ins_id);
                    echo 'getConfTree(' . $conf_id . ', ';
                    if (isset($is_ie)) {
                        if ($is_ie) {
                            echo 'true';
                        } else {
                            echo 'false';
                        }
                    } else {
                        $is_ie = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11:0') !== false;
                        if ($is_ie) {
                            echo 'true';
                        } else {
                            echo 'false';
                        }
                    }
                    echo ');';
                } else {
                    echo 'getConfList();';
                }
            ?>
        </script>
    </body>
</html>