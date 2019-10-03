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
            
            function unwrapElem(element, parentId, display) {
                var parent = document.getElementById(parentId);
                var newNode = '';
                
                var id          = element.id;
                var name        = element.name;
                var children    = element.children;
                
                switch(element.type) {
                    case 'dir':
                        newNode =
                            `<a href="#" onclick="showHide('c` + id +`');">` + name + `</a>
                                <img id="ed` + id + `" src="../../img/pendir.png" class="img-ico" name="` + name + `" title="Переименовать папку">
                                <img id="nd` + id + `" src="../../img/plusdir.png" class="img-ico" name="` + name + `" title="Создать вложенную папку">
                                <img id="dd` + id + `" src="../../img/del.png" class="img-ico" name="` + name + `" title="Удалить папку">
                                |<img id="nf` + id + `" src="../../img/plusfile.png" class="img-ico" name="` + name + `" title="Создать вложенную инструкцию">
                            <ul id="c` + id + `" style="display: ` + display + `" name="` + name + `"></ul><br>`;
                        parent.insertAdjacentHTML("beforeend", newNode);
                        
                        if (children != null) {
                            children.forEach(function(el) {
                                unwrapElem(el, 'c' + id, 'none');
                            });
                        }
                        break;
                    case 'file':
                        newNode =
                            `<li id="li` + id + `">` + name + `
                                <img id="ef` + id + `" src="../../img/penfile.png" class="img-ico" name="` + name + `" title="Переименовать инструкцию, прикрепить файлы">
                                <img id="df` + id + `" src="../../img/del.png" class="img-ico" name="` + name + `" title="Удалить инструкцию вместе с её файлами">
                            </li>`;
                        parent.insertAdjacentHTML("beforeend", newNode);
                        break;
                }
            }
            
            function getConfTree() {
                var idConf = 1;
                var x = $.ajax({
                    type: 'POST',
                    url: '../../php/ajaxdata.php',
                    async: false,
                    data: {
                        fill:    'get_conf_tree',
                        ID_conf: idConf},
                    dataType: "json",
                    success: function(data) {
                        
                        data.forEach(function(element) {
                            // Разворачивание дерева от корневого каталога инструкций конфигурации (Configuration tree)
                            unwrapElem(element, 'conftree', 'block');
                        });
                    }
                }).responseText;
                document.getElementById('rootdirfordir').value  = idConf;
                document.getElementById('rootdirforfile').value = idConf;
            }
            
            function createElem(where, what) {
                showElem(where);
                switch(what) {
                    case 'dir':
                        hideElem('newfile');
                        showElem('newdir');
                        document.getElementById('dlabel').innerHTML = 'Создание папки';
                        break;
                    case 'file':
                        hideElem('newdir');
                        showElem('newfile');
                        document.getElementById('flabel').innerHTML = 'Создание инструкции';
                        break;
                    default:
                        break;
                }
            }
            
            // Получение полного пути к объекту (папка/файл) и его запись в поле "Полный путь к родительской папке" соответствующей формы
            function setFullPath(id, type, ignoreId) {
                var nowId   = id;
                var path    = (ignoreId) ? '' : document.getElementById(nowId).name;
                var parent  = null;
                var s       = 0;
                
                while(nowId != 'conftree') {
                    buff = document.getElementById(nowId);
                    if (buff != null) {
                        parent      = buff.parentNode;
                        nowId       = parent.id;
                        parentName  = parent.getAttribute('name');
                        if (parentName != null) {
                            path    = (path == '') ? parentName : parentName + '/' + path;
                        }
                    }
                    
                    s++;
                    if (s > 100) {
                        console.log('Счётчик в цикле вычисления полного пути до родителя превысил 100');
                        break;
                    }
                }
                
                path = "/" + path;
                switch(type) {
                    case 'dir':
                        document.getElementById('fullpathfordir').value     = path;
                        document.getElementById('dirname').value            = document.getElementById(id).name;
                        document.getElementById('okbtnfordir').value        = id;
                        break;
                    case 'file':
                        document.getElementById('fullpathforfile').value    = path;
                        document.getElementById('filename').value           = document.getElementById(id).name;
                        document.getElementById('okbtnforfile').value       = id;
                        break;
                }
            }
            
            function setContent(id, type) {
                // TO DO заполнить форму данными из БД с этим id, элемент - этого типа
                
                switch(type) {
                    case 'dir':
                        document.getElementById('dlabel').innerHTML = 'Редактирование папки';
                        break;
                    case 'file':
                        document.getElementById('flabel').innerHTML = 'Редактирование инструкции';
                        break;
                    default:
                        break;
                }
            }
            
            function getDeleteConfirmation(id, type) {
                var answer = confirm("Удалить элемент?");
                if (answer) {
                    var x = $.ajax({
                        type: 'POST',
                        url: '../../php/ajaxdata.php',
                        async: false,
                        data: {
                            action:    'delete_' + type,
                            id: id},
                        dataType: "json",
                        success: function(data) {
                            document.location.reload(true);
                        }
                    }).responseText;
                }
            }
            
            function getReadMe() {
                if (document.getElementById('readme').style.display == 'none') {
                    hideElem('newfile')
                    showElem('readme');
                } else {
                    hideElem('readme');
                    showElem('newfile');
                }
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <?php
                draw_header(3);
            ?>
            
            <table class="bhi text-char-middle" style="width: 100%">
                <tbody style="text-align: justify; vertical-align: top">
                    <tr>
                        <td id="conftree" style="width: 60%">
                            <!-- TO DO Обработка, конфигурация не указана -->
                            <div id="confisempty" style="display: none">
                                <p class="warning-info">Конфигурация не указана!<br>Выберите название из списка:</p>
                                <select class="text-char-middle">
                                    <option value="">АСРН-2
                                    <option value="">АСУСЭиРП
                                </select>
                                <button class="btn confirm-btn ok-btn">ОК</button>
                            </div>
                        </td>
                        
                        <td>
                            <button type="button" class="btn feedback-btn" style="float: left" onclick="getReadMe();" title="Нажмите, чтобы посмотреть/скрыть справку">Справка</button>
                            <a href="../advancedinstr/index.php" style="width: 100%">
                                <button type="button" class="btn feedback-btn" style="float: right" title="Изменить родителя для инструкции или папки">Дополнительные действия</button>
                            </a>
                            <br>
                            <br>
                            <hr class="corp-primary-color">
                            <!-- Форма создания папки -->
                            <form id="newdir" class="new-dir-or-file" action="../../php/common.php" method="post">
                                <p id="dlabel" class="text-char-larger">Создание папки</p>
                                <input id="fullpathfordir" type="text" class="fat-elem fat-border" value="/" readonly="" title="Полный путь к родительской папке">
                                <input id="rootdirfordir" type="hidden" name="rootdir" value="">
                                <input id="dirname" type="text" class="fat-elem fat-border" name="dirname" placeholder="Название папки" required="" maxlength="535" title="Название папки">
                                <button id="okbtnfordir" type="submit" class="btn confirm-btn ok-btn small-width more-padding" name="okbtnfordir" value="">ОК</button>
                            </form>
                            <!-- Форма создания инструкции -->
                            <form id="newfile" enctype="multipart/form-data" class="new-dir-or-file" action="../../php/common.php" method="post">
                                <p id="flabel" class="text-char-larger">Создание инструкции</p>
                                <input id="fullpathforfile" type="text" class="fat-elem fat-border" value="/" readonly="" title="Полный путь к родительской папке">
                                <input id="rootdirforfile" type="hidden" name="rootdir" value="">
                                <input id="filename" type="text" class="fat-elem fat-border" name="filename" placeholder="Название инструкции" required="" maxlength="535" title="Название инструкции">
                                <p class="text-char-middle">Оригинал (doc/docx)</p>
                                <input type="file" class="fat-elem" name="docoriginal">
                                <p class="text-char-middle">Файл для чтения (pdf)</p>
                                <input type="file" class="fat-elem" name="docreadonly">
                                <p class="text-char-middle">Файл для чтения в IE (mhtml)</p>
                                <input type="file" class="fat-elem" name="docreadonlyie">
                                <button id="okbtnforfile" type="submit" class="btn confirm-btn ok-btn small-width more-padding" name="okbtnforfile" value="">ОК</button>
                            </form>
                            <div id="readme" style="display: none">
                                <p>Данный раздел предназначен для администрирования дерева с доступными инструкциями, которое увидит пользователь портала.
                                Дерево состоит из корневой папки, дочерних папок и инструкций. К каждой инструкции может быть прикреплено 3 файла:
                                <ul>
                                    <li>оригинал (для скачивания администратором, последующей модификации и загрузки обратно на портал);</li>
                                    <li>файл для чтения в .pdf (для браузеров, в которых есть средство просмотра файлов такого типа);</li>
                                    <li>файл для чтения в .mhtml (для Internet Explorer, где, как предполагается, плагинов не установлено).</li>
                                </ul>
                                <p>Для папок доступны следующие операции:
                                <ul>
                                    <li>переименование;</li>
                                    <li>создание дочерней папки;</li>
                                    <li>удаление папки со всем её содержимым;</li>
                                    <li>создание инструкции в этой папке.</li>
                                </ul>
                                <p>Для инструкций доступно:
                                <ul>
                                    <li>переименование;</li>
                                    <li>перезагрузка прикреплённых файлов: если файл прикреплён, он заменяется, иначе остаётся прежним;</li>
                                    <li>удаление инструкции со всеми прикреплёнными файлами.</li>
                                </ul>
                            </div>
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
            addLogoutBtn(3);
            setPageLabel("Управление инструкциями");
            // Форма создания инструкции
            createElem(null, 'file');
            // Дерево инструкций конфигурации
            getConfTree();
            document.getElementById('wrapper').onclick = function(e) {
                id = e.target.id;
                normId = id.substring(2);
                
                switch(id.substring(0, 2)) {
                    // new directory (folder)
                    case 'nd':
                        showElem('c' + normId);
                        createElem(normId, 'dir');
                        setFullPath(id, 'dir');
                        break;
                    // new file (instruction)
                    case 'nf':
                        createElem(normId, 'file');
                        setFullPath(id, 'file');
                        break;
                    // edit directory (folder)
                    case 'ed':
                        createElem(normId, 'dir');
                        setContent(normId, 'dir');
                        setFullPath(id, 'dir');
                        break;
                    // edit file (instruction)
                    case 'ef':
                        createElem(normId, 'file');
                        setContent(normId, 'file');
                        setFullPath(id, 'file', true);
                        break;
                    // delete directory
                    case 'dd':
                        getDeleteConfirmation(normId, 'dir');
                        break;
                    // delete file
                    case 'df':
                        getDeleteConfirmation(normId, 'file');
                        break;
                    default:
                        //console.log(e.target.id);
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