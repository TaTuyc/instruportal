<?php
    // Процедурная отрисовка элементов на странице
    
    // Отрисовка шапки для страниц в зависимости от уровня (1 - корневой, 2 - внутри корня, 3 - внутри 2)
    function draw_header($level) {
        switch($level) {
            case 1:
                ?>
                <div class="table-responsive text-center">
                    <table class="bhi" style="width: 100%">
                        <tr>
                            <td style="width: 551px" class="text-center"><a href="#"><img src="./img/genlogo.png" alt="Лого" width="551px" height="62px" title="Перейти на главную страницу"></a></td>
                            <td id="pagelabel" class="text-center text-char-header">Портал инструкций по работе с АСРН-2</td>
                            <td>
                                <button type="button" class="btn feedback-btn" onclick="sendFeedback('');" title="Сообщить о неточностях в инструкции">Сообщить об ошибке</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                break;
            case 2:
                ?>
                <div class="table-responsive text-center">
                    <table class="bhi" style="width: 100%">
                        <tr>
                            <td style="width: 551px" class="text-center"><a href="../index.php"><img src="../img/genlogo.png" alt="Лого" width="551px" height="62px" title="Перейти на главную страницу"></a></td>
                            <td id="pagelabel" class="text-center text-char-header">Портал инструкций по работе с АСРН-2</td>
                            <td id="btncontainer">
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                break;
            case 3:
                ?>
                <div class="table-responsive text-center">
                    <table class="bhi" style="width: 100%">
                        <tr>
                            <td style="width: 551px" class="text-center"><a href="../../index.php"><img src="../../img/genlogo.png" alt="Лого" width="551px" height="62px" title="Перейти на главную страницу"></a></td>
                            <td id="pagelabel" class="text-center text-char-header">Портал инструкций по работе с АСРН-2</td>
                            <td id="btncontainer">
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                break;
        }
    }
    
    // Отрисовка подвала для страниц в зависимости от уровня (1 - корневой, 2 - внутри корня, 3 - внутри 2)
    function draw_footer($level) {
        switch($level) {
            case 1:
                ?>
                <table class="bhi text-char-small extra-info" style="margin-left: 25%; width: 75%; text-align: right">
                    <tr style="text-align: center">
                        <td style="text-align: left">
                            <a id="copyright"></a>
                        </td>
                        <td style="text-align: right">
                            <a href="./login/index.php">
                                <img src="./img/adminLogin.png" title="Вход для администраторов и контент-менеджеров">
                            </a>
                        </td>
                    </tr>
                </table>
                <?php
                break;
            case 2:
                ?>
                <div id="footer">
                    <table class="bhi text-char-small extra-info footer-in-table">
                        <tr style="text-align: center">
                            <td style="text-align: left">
                                <a id="copyright"></a>
                            </td>
                            <td style="text-align: right">
                                <a href="../login/index.php">
                                    <img src="../img/adminLogin.png" title="Вход для администраторов и контент-менеджеров">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                break;
            case 3:
                ?>
                <div id="footer">
                    <table class="bhi text-char-small extra-info footer-in-table">
                        <tr style="text-align: center">
                            <td style="text-align: left">
                                <a id="copyright"></a>
                            </td>
                            <td style="text-align: right">
                                <a href="../../login/index.php">
                                    <img src="../../img/adminLogin.png" title="Вход для администраторов и контент-менеджеров">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                break;
        }        
    }
?>