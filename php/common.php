<?php
    // Проверка расширения имени файла; в дерево файловой системы в web-интерфейсе включаются только каталоги и html-файлы
    function check_extension($filename) {
        if (substr($filename, -5) == '.html') {
            return true;
        } elseif (substr($filename, -4) == '.htm') {
            return true;
        } else {
            return false;
        }
    }
    
    // Очистка массива от пустых массивов рекурсивно
    function get_pure_array($arr) {
        foreach($arr as $key => $value) {
            if (is_array($arr[$key])) {
                if (count($arr[$key]) <= 1) {
                    unset($arr[$key]);
                } else {
                    // узнаем, можно ли удалять этот элемент
                    $del = get_pure_array($arr[$key]);
                    if ($del === true) {
                        unset($arr[$key]);
                    }
                }
            }
        }
        if ($arr === Array()) {
            return true;
        } else {
            return $arr;
        }
    }
    
    // Получение дерева файловой системы, отобразимого в web-интерфейсе, из каталогов и файлов-инструкций в html
    function get_fs_tree($dirnow) {
        if (substr($dirnow, -1) == '/') {
            $dirnow = substr($dirnow, 0, -1);
        }
        
        if ($dirnow == NULL) {
            return '';
        } elseif ($dirnow == '') {
            return '';
        }
        
        $result = scandir($dirnow);
        foreach($result as $key => $value) {
            switch($value) {
                case '.':
                    unset($result[$key]);
                    break;
                case '..':
                    unset($result[$key]);
                    break;
                default:
                    $fullfilename = $dirnow . '/' . $value;
                    if (is_dir($fullfilename)) {
                        $buff = get_fs_tree($fullfilename);
                        if (count($buff) > 1) {
                            $result[$key] = get_fs_tree($fullfilename);
                        } else {
                            unset($result[$key]);
                        }
                        unset($buff);
                    } elseif (!check_extension($fullfilename)) {
                        unset($result[$key]);
                    }
            }            
        }
        $result['cd'] = $dirnow;
        return $result;
    }
    
    // --------------------------------------------------------------------------------------------------------
    // Функции для работы с БД
    // --------------------------------------------------------------------------------------------------------
    
    session_start();
    
    // Соединение с базой данных путём создания PDO-объекта
    function connect_db () {
        try {
            $pdo = new PDO('mysql:host=localhost; dbname=Instruportal; charset=utf8', 'root', '62996326');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Подключение не удалось. Код ошибки: ' . $e->getMessage());
        }
    }
    
    // Аутентификация
    function find_user ($pdo, $login) {
        $result = $pdo->prepare("SELECT ID_user
            FROM User 
            WHERE login = ? LIMIT 1");
        $result->execute(array($login));
        if ($result->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    function find_password($pdo, $login) {
        $sql = "SELECT password 
            FROM User 
            WHERE login = ? LIMIT 1";
        $result = $pdo->prepare($sql);
        $result->execute(array($login));
        foreach($result as $row) {
            return htmlspecialchars($row['password']);
        }
    }
    
    function check_password($pdo, $login, $pw) {
        if (password_verify($pw, find_password($pdo, $login))) {
            return true;
        } else {
            return false;
        }
    }
?>