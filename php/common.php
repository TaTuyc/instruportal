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
    // Вспомогательные функции
    // --------------------------------------------------------------------------------------------------------
    
    // Получить столбец из результата запроса
    function get_column($result, $column) {
        $arr = array();
        while ($row = $result->fetch()) {
            $arr[] = htmlentities($row[$column]);
        }
        return $arr;
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
        $sql = "SELECT ID_user
            FROM User 
            WHERE login = ? LIMIT 1";
        $result = $pdo->prepare($sql);
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
            return $row['password'];
        }
    }
    
    function check_password($pdo, $login, $pw) {
        if (password_verify($pw, find_password($pdo, $login))) {
            return true;
        } else {
            return false;
        }
    }
    
    // Создание учётной записи пользователя
    function create_user($pdo, $login, $pw) {
        $sql    = "INSERT INTO User (ID_user, login, password) VALUES (NULL, ?, ?)";
        $result = $pdo->prepare($sql);
        $result->execute(array(
            $login,
            password_hash($pw, PASSWORD_DEFAULT)
        ));
        header('Location: ../panel/users/index.php');
    }
    
    // Чтение списка учётных записей
    function get_users_list($pdo) {
        $sql = "SELECT ID_user, login FROM User";
        $result = $pdo->prepare($sql);
        $result->execute();
        
        $result_array = array();
        foreach($result as $row) {
            $result_array[] = [
                $row['ID_user'],
                $row['login']
            ];
        }
        print json_encode($result_array);
        //print json_encode(get_column($result, 'login'));
    }
    
    // Удаление учётных записей пользователей
    function delete_users($pdo, $users_json) {
        $users  = json_decode($users_json);
        $sql    = "DELETE FROM User WHERE ID_user = ?";
        $result = $pdo->prepare($sql);
        
        foreach($users as $user) {
            $result->execute(array($user));
        }
        print json_encode('');
    }
    
    // Обновление учётных записей пользователей
    function update_users($pdo, $users_json, $pws_json) {
        $users  = json_decode($users_json);
        $pws    = json_decode($pws_json);
        $sql    = "UPDATE User SET password = ? WHERE ID_user = ?";
        $result = $pdo->prepare($sql);
        
        for ($i = 0, $l = count($users); $i < $l; $i++) {
            $result->execute(array(
                password_hash($pws[$i], PASSWORD_DEFAULT),
                $users[$i]
            ));
        }
        print json_encode('');
    }
    
    // Чтение списка настроек портала
    function get_settings_list($pdo) {
        $sql    = "SELECT ID_set, set_key, set_value
            FROM Setting";
        $result = $pdo->prepare($sql);
        $result->execute();
        
        $result_array = array();
        foreach($result as $row) {
            $result_array[] = [
                $row['ID_set'],
                $row['set_key'],
                $row['set_value']
            ];
        }
        print json_encode($result_array);
    }
    
    // Обновление значений настроек портала
    function update_settings($pdo, $settings_json) {
        $settings  = json_decode($settings_json);
        $sql       = "UPDATE Setting SET set_value = ? WHERE ID_set = ?";
        $result    = $pdo->prepare($sql);
        
        foreach($settings as $setting) {
            $result->execute(array(
                $setting[1],
                $setting[0]
            ));
        }
        print json_encode('');
    }
    
    // Сброс значений настроек портала к значениям по умолчанию
    function reset_settings($pdo) {
        $sql = "SELECT ID_set, set_key, set_default
            FROM Setting";
        $result = $pdo->prepare($sql);
        $result->execute();
        
        $sql_upd = "UPDATE Setting SET set_value = ? WHERE ID_set = ?";
        $result_upd = $pdo->prepare($sql_upd);
        foreach($result as $row) {
            $result_upd->execute(array(
                $row['set_default'],
                $row['ID_set']
            ));
        }
        print json_encode('');
    }
    
    // --------------------------------------------------------------------------------------------------------
    // Ветви обработчиков форм
    // --------------------------------------------------------------------------------------------------------
    
    $pdo = connect_db();
    if (isset($_POST['nulogin'])) { // new user login
        create_user($pdo, htmlspecialchars($_POST['nulogin']), htmlspecialchars($_POST['nupw']));
    }
?>