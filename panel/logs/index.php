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
            function getResponsible() {
                location = './index.php?id=' + document.getElementById('ins_list').value;
            }
            function getReadMe() {
                showHide('readme');
            }
            // Получение выборки записей из журнала логов
            function setLogJ(id, page) {
                if (id != null) {
                    var x = $.ajax({
                        type: 'POST',
                        url: '../../php/ajaxdata.php',
                        async: false,
                        data: {
                            fill:   'get_logj',
                            id:     id,
                            page:   page},
                        dataType: "json",
                        success: function(data) {
                            parent = document.getElementById('logj');
                            parent.innerHTML = '';
                            data.forEach(function(element) {
                                // Заполнение таблицы логов полученными данными, построчно
                                newNode =
                                `<tr>
                                    <td>` + element.n +     `
                                    <td>` + element.date +  `
                                    <td>` + element.event + `
                                    <td>` + element.user +  `
                                </tr>`;
                                parent.insertAdjacentHTML("beforeend", newNode);
                            });
                        }
                    }).responseText;
                    hideElem('morebtn');
                } else {
                    var x = $.ajax({
                        type: 'POST',
                        url: '../../php/ajaxdata.php',
                        async: false,
                        data: {
                            fill:   'get_logj',
                            id:     id,
                            page:   page},
                        dataType: "json",
                        success: function(data) {
                            parent = document.getElementById('logj');
                            // Если запрашиваемая страница первая, то нужно очистить таблицу, иначе -- дополнить снизу
                            var moreBtn = document.getElementById('morebtn');
                            if (page == 1) {
                                parent.innerHTML = '';
                                moreBtn.setAttribute('value', 2);
                            } else {
                                var nextPage = parseInt(document.getElementById('morebtn').getAttribute('value'), 10) + 1;
                                moreBtn.setAttribute('value', nextPage);
                            }
                            data.forEach(function(element) {
                                // Заполнение таблицы логов полученными данными, построчно
                                newNode =
                                `<tr>
                                    <td>` + element.n +     `
                                    <td>` + element.date +  `
                                    <td>` + element.event + `
                                    <td>` + element.user +  `
                                </tr>`;
                                parent.insertAdjacentHTML("beforeend", newNode);
                            });
                        }
                    }).responseText;
                }
            }
            function getMoreNotes() {
                setLogJ(null, document.getElementById('morebtn').getAttribute('value'));
            }
            function resetPage() {
                location = './index.php';
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
                    <button id="resetpage" type="button" class="btn feedback-btn report-btn" style="display: none" onclick="resetPage();" title="Нажмите, чтобы перейти ко всем записям">
                        Сброс фильтров
                    </button>
                    <button type="button" class="btn feedback-btn report-btn" onclick="getReadMe();" title="Нажмите, чтобы посмотреть/скрыть справку">
                        Справка
                    </button>
                    <button id="showsearch" type="button" class="btn feedback-btn report-btn" title="Поиск сотрудника, последним изменявшего инструкцию">
                        Поиск ответственного
                    </button>
                    <div id="search" class="new-dir-or-file" style="float: right">
                        <select id="ins_list" class="more-padding">
                        </select>
                        <button type="button" class="btn confirm-btn ok-btn medium-width more-padding" onclick="getResponsible();">Найти</button>
                    </div>
                </form>
            </div>
            
            <div id="readme" style="display: none">
                <p>В данном разделе доступен просмотр журнала логов, который регистрирует события, возникающие при изменении структуры и содержимого портала.
                К таким событиям относятся действия администратора:
                <ul>
                    <li>операции над инструкциями (переименование, перезагрузка прикреплённых файлов и удаление);</li>
                    <li>операции над папками (переименование, создание дочерних папок и инструкций, удаление со всем содержимым).</li>
                </ul>
            </div>
            
            <table class="text-char-middle text-center" style="width: 100%; margin: 0.5rem">
                <tbody class="striped text-usual">
                    <tr>
                        <th>№</th>
                        <th>Дата события</th>
                        <th>Событие</th>
                        <th>Пользователь</th>
                    </tr>
                </tbody>
                <tbody id="logj" class="striped text-usual">
                </tbody>
            </table>
            
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
            setPageLabel("Журнал логов");
            
            document.getElementById('wrapper').onclick = function(e) {
                id = e.target.id;
                
                switch(id) {
                    case 'showsearch':
                        // Получение списка инструкций для поиска ответственного за последние изменения
                        var x = $.ajax({
                            type: 'POST',
                            url: '../../php/ajaxdata.php',
                            async: false,
                            data: {
                                fill:   'get_ins_list'},
                            dataType: "json",
                            success: function(data) {
                                parent = document.getElementById('ins_list');
                                parent.innerHTML = '';
                                data.forEach(function(element) {
                                    // Заполнение выпадающего списка с инструкциями полученными данными, построчно
                                    newNode =
                                    '<option value="' + element.id +'">' + element.name + '</option>';
                                    parent.insertAdjacentHTML("beforeend", newNode);
                                });
                            }
                        }).responseText;
                        
                        showElem('search');
                        hideElem('showsearch');
                        break;
                    default:
                        break;
                }
            };
            
            <?php
                // id   - идентификатор инструкции, для которой необходимо найти все записи в журнале логов
                if (isset($_GET['id'])) {
                    echo 'setLogJ(' . htmlspecialchars($_GET['id']) . ', null);';
                    echo 'document.getElementById(\'resetpage\').style.display = \'block\';';
                } else {
                    // Отображение первой страницы всех логов при отсутствии id инструкции
                    echo 'setLogJ(null, 1);';
                }
            ?>
        </script>
    </body>
</html>
    <?php
} else {
    header('Location: ../../index.php');
}