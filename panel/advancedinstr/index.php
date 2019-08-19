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
                <tr class="table-header">
                    <td colspan="4">
                        <a href="./index.php#originals">
                            <p id="showo" class="text-char-larger" title="Нажмите, чтобы скрыть/развернуть">Оригиналы документов</p>
                        </a>
                    </td>
                </tr>
                <tbody id="originals" class="striped" name="originals">
                    <tr>
                        <th>Тип элемента</th>
                        <th>Название</th>
                        <th>Родительская папка</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>миу</td>
                        <td><select>
                            <option value="">миу1</option>
                            <option value="">миу2</option>
                            <option value="">миу3</option>
                        </select></td>
                        <td><button id="o0" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>мяу</td>
                        <td><select>
                            <option value="">мяу1</option>
                            <option value="">мяу2</option>
                            <option value="">мяу3</option>
                        </select></td>
                        <td><button id="o1" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Инструкция</td>
                        <td>моу</td>
                        <td><select>
                            <option value="">моу1</option>
                            <option value="">моу2</option>
                            <option value="">моу3</option>
                        </select></td>
                        <td><button id="o2" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                </tbody>
                
                <tr class="table-header">
                    <td colspan="4">
                        <a href="./index.php#readonly">
                            <p id="showp" class="text-char-larger" title="Нажмите, чтобы скрыть/развернуть">Файлы документов для чтения (pdf)</p>
                        </a>
                    </td>
                </tr>
                <tbody id="readonly" class="striped" name="readonly">
                    <tr>
                        <th>Тип элемента</th>
                        <th>Название</th>
                        <th>Родительская папка</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>миу</td>
                        <td><select>
                            <option value="">миу1</option>
                            <option value="">миу2</option>
                            <option value="">миу3</option>
                        </select></td>
                        <td><button id="o0" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>мяу</td>
                        <td><select>
                            <option value="">мяу1</option>
                            <option value="">мяу2</option>
                            <option value="">мяу3</option>
                        </select></td>
                        <td><button id="o1" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Инструкция</td>
                        <td>моу</td>
                        <td><select>
                            <option value="">моу1</option>
                            <option value="">моу2</option>
                            <option value="">моу3</option>
                        </select></td>
                        <td><button id="o2" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                </tbody>
                
                <tr class="table-header">
                    <td colspan="4">
                        <a href="./index.php#readonlyie">
                            <p id="showi" class="text-char-larger" title="Нажмите, чтобы скрыть/развернуть">Файлы документов для чтения в Internet Explorer (mhtml)</p>
                        </a>
                    </td>
                </tr>
                <tbody id="readonlyie" class="striped" name="readonlyie">
                    <tr>
                        <th>Тип элемента</th>
                        <th>Название</th>
                        <th>Родительская папка</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>миу</td>
                        <td><select>
                            <option value="">миу1</option>
                            <option value="">миу2</option>
                            <option value="">миу3</option>
                        </select></td>
                        <td><button id="o0" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Папка</td>
                        <td>мяу</td>
                        <td><select>
                            <option value="">мяу1</option>
                            <option value="">мяу2</option>
                            <option value="">мяу3</option>
                        </select></td>
                        <td><button id="o1" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
                    </tr>
                    <tr>
                        <td>Инструкция</td>
                        <td>моу</td>
                        <td><select>
                            <option value="">моу1</option>
                            <option value="">моу2</option>
                            <option value="">моу3</option>
                        </select></td>
                        <td><button id="o2" type="button" class="btn confirm-btn ok-btn lowly medium-width">ОК</button></td>
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
            setPageLabel("Управление инструкциями: изменение родительской папки");
            
            document.getElementById('wrapper').onclick = function(e) {
                id = e.target.id;
                normId = id.substring(1);
                
                switch(id.substring(0, 1)) {
                    // original
                    case 'o':
                        // TO DO
                        break;
                    case 'p':
                        // TO DO
                        break;
                    case 'i':
                        // TO DO
                        break;
                    default:
                        if (id.substring(0, 4) == 'show') {
                            switch(id.substring(4, 5)) {
                                case 'o':
                                    showHide('originals');
                                    break;
                                case 'p':
                                    showHide('readonly');
                                    break;
                                case 'i':
                                    showHide('readonlyie');
                                    break;
                                default:
                                    break;
                            }
                        }
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