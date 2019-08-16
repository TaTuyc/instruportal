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
        <script type="text/javascript">
            function sendFeedback(str_default) {
                usranswer = prompt('Введите краткое описание ошибки в инструкции с указанием пункта:', str_default);
                if (usranswer != '' && usranswer != null) {
                    if (usranswer.length > const_feedback_length) {
                        alert('Слишком длинное сообщение (больше ' + const_feedback_length + ' символов). Пожалуйста, введите ещё раз.');
                        sendFeedback(usranswer.substring(0, 535));
                    } else {
                        // TO DO здесь брать переменную и отправлять на запись
                        console.log(usranswer);
                    }
                }
            }
            
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
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
                        <td style="width: 25%">
                            <p class="text-char-larger">Разделы</p>
                            <ul>
                                <li>Пункт</li>
                                <a href="#" onclick="showHide('meow');">Папка</a>
                                <ul id='meow' style="display: none">
                                    <li>Пункт в папке</li>
                                    <li>Пункт в папке!</li>
                                    <a href="#" onclick="showHide('meowwaf');">Папка в папке</a>
                                    <ul id='meowwaf' style="display: none">
                                        <li>Пункт в папке в папке</li>
                                        <li>Пункт в папке в папке</li>
                                    </ul>
                                    <li>Пункт в папке</li>
                                </ul>
                                <li>Пункт</li>
                                <li>Пункт</li>
                            </ul>
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
                            <p id="ins_header" class="text-char-larger text-center text-add-padding">Как оформлять курсовую работу по дисциплине "Теория автоматов"?</p>
                            <iframe id="ins_content" src="./ta.pdf" style="width: 100%; height: 29.8cm"></iframe>
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
        </script>
    </body>
</html>