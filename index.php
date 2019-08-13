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
        <script type="text/javascript">
            function showhide(id) {
                if (document.getElementById(id).style.display == 'none') {
                    document.getElementById(id).style.display = 'block';
                } else {
                    document.getElementById(id).style.display = 'none';
                }
            }
            
            function sendfeedback(str_default) {
                usranswer = prompt('Введите краткое описание ошибки в инструкции с указанием пункта:', str_default);
                if (usranswer != '' && usranswer != null) {
                    if (usranswer.length > const_feedback_length) {
                        alert('Слишком длинное сообщение (больше ' + const_feedback_length + ' символов). Пожалуйста, введите ещё раз.');
                        sendfeedback(usranswer.substring(0, 535));
                    } else {
                        // TO DO здесь брать переменную и отправлять на запись
                        console.log(usranswer);
                    }
                }
            }
            
            function setbyconst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
        </script>
    </head>
    
    <body>
        <div id="wrapper">
            <div class="table-responsive text-center">
                <table class="bhi" style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 551px" class="text-center"><a href="#"><img src="./img/genlogo.png" alt="Лого" width="551px" height="62px" title="Перейти на главную страницу"></a></td>
                            <td class="text-center text-char-header">Портал инструкций по работе с АСРН-2</td>
                            <td>
                                <button type="button" class="btn feedbackbtn" onclick="sendfeedback('');" title="Сообщить о неточностях в инструкции">Сообщить об ошибке</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <table class="bhi text-char-middle" style="width: 100%">
                <tbody style="text-align: justify; vertical-align: top">
                    <tr>
                        <td style="width: 25%">
                            <p class="text-char-larger">Разделы</p>
                            <ul>
                                <li>Пункт</li>
                                <a href="#" onclick="showhide('meow');">Папка</a>
                                <ul id='meow' style="display: none">
                                    <li>Пункт в папке</li>
                                    <li>Пункт в папке!</li>
                                    <a href="#" onclick="showhide('meowwaf');">Папка в папке</a>
                                    <ul id='meowwaf' style="display: none">
                                        <li>Пункт в папке в папке</li>
                                        <li>Пункт в папке в папке</li>
                                    </ul>
                                    <li>Пункт в папке</li>
                                </ul>
                                <li>Пункт</li>
                                <li>Пункт</li>
                            </ul>
                            <div id="confisempty" style="display: none">
                                <p class="warning-info">Конфигурация не указана!<br>Выберите название из списка:</p>
                                <select class="text-char-middle">
                                    <option value="">АСРН-2
                                    <option value="">АСУСЭиРП
                                </select>
                                <button class="btn confirmbtn okbtn">ОК</button>
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
            
            <table class="bhi text-char-small extra-info" style="margin-left: 25%; width: 75%; text-align: right">
                <tbody style="text-align: center">
                    <tr>
                        <td style="text-align: left">
                            <a id="copyright">©  ООО «Иркутская Энергосбытовая компания», 2019 г. 0+</a>
                        </td>
                        <td style="text-align: right">
                            <a href="./login/index.php">
                                <img src="./img/adminLogin.png" title="Вход для администраторов и контент-менеджеров">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            setbyconst();
        </script>
    </body>
</html>