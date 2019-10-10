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
    function get_fs_tree_BACK($dirnow) {
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
                        $buff = get_fs_tree_BACK($fullfilename);
                        if (count($buff) > 1) {
                            $result[$key] = get_fs_tree_BACK($fullfilename);
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
    
    // Получить текущую дату
    function get_date() {
        return date("Y-m-d H:i:s", time());
    }
    
    // Получить дату в формате ДД-ММ-ГГ ЧЧ-ММ-СС
    function get_date_normal($date_string) {
        $date = strtotime($date_string);
        return date("H:i:s d-m-Y", $date);
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
    
    function get_user_id($pdo, $login) {
        $sql = "SELECT ID_user
            FROM User 
            WHERE login = ? LIMIT 1";
        $result = $pdo->prepare($sql);
        $result->execute(array($login));
        if ($result->rowCount() == 0) {
            return null;
        } else {
            foreach($result as $row) {
                return $row['ID_user'];
            }
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
        $result = $pdo->query($sql);
        
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
        $result = $pdo->query($sql);
        
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
    
    // Получение идентификатора корневой папки конфигурации
    function get_root_folder_id($pdo, $conf_id) {
        $sql = "SELECT ID_root_folder FROM Configuration WHERE ID_conf = " . $conf_id;
        $result = $pdo->query($sql);
        foreach($result as $row) {
            return $row['ID_root_folder'];
        }
    }
    
    // Получение списка дочерних файлов
    function get_child_files($pdo, $parent_arr, $parent_id) {
        $sql    = "SELECT ID_ins, ins_name FROM Instruction WHERE ID_fol = ?";
        $result = $pdo->prepare($sql);
        $result->execute(array($parent_id));
        if ($result->rowCount() != 0) {
            return set_child_file($pdo, $parent_arr, $result);
        } else {
            return $parent_arr;
        }
    }
    
    // Запись подробных данных о дочерних файлах
    function set_child_file($pdo, $parent_arr, $children) {
        foreach($children as $child) {
            $parent_arr["children"][] = array(
                "id"        => $child['ID_ins'],
                "type"      => 'file',
                "name"      => $child['ins_name']
            );
        }
        return $parent_arr;
    }
    
    // Получение списка дочерних папок
    function get_child_dirs($pdo, $parent_arr, $parent_id) {
        $sql       = "SELECT * FROM Folder WHERE ID_fol_parent = ?";
        $result    = $pdo->prepare($sql);
        $result->execute(array($parent_id));
        if ($result->rowCount() != 0) {
            return set_child_dir($pdo, $parent_arr, $result);
        } else {
            return $parent_arr;    
        }        
    }
    
    // Запись подробных данных о дочерних папках
    function set_child_dir($pdo, $parent_arr, $children) {
        foreach($children as $child) {
            $parent_arr["children"][] = array(
                "id"        => $child['ID_fol'],
                "type"      => 'dir',
                "name"      => $child['fol_name'],
                "children"  => NULL
            );
            end($parent_arr["children"]);
            $key = key($parent_arr["children"]);
            
            $parent_arr["children"][$key] = get_child_dirs($pdo, $parent_arr["children"][$key], $child['ID_fol']);
            $parent_arr["children"][$key] = get_child_files($pdo, $parent_arr["children"][$key], $child['ID_fol']);
        }
        return $parent_arr;
    }
    
    // Получение дерева каталога инструкций для отдельной конфигурации
    function get_conf_tree($pdo, $conf_id) {
        $ID_root_folder = get_root_folder_id($pdo, $conf_id);
        $sql    = "SELECT * FROM Folder WHERE ID_fol = ? LIMIT 1";
        $result = $pdo->prepare($sql);
        $result->execute(array($ID_root_folder));
        
        $tree = [];
        foreach($result as $row) {
            $tree[] = array(
                "id"        => $row['ID_fol'],
                "type"      => 'dir',
                "name"      => $row['fol_name'],
                "children"  => NULL
            );
            
            end($tree);
            $key = key($tree);
            
            $tree[$key] = get_child_dirs($pdo, $tree[$key], $row['ID_fol']);
            $tree[$key] = get_child_files($pdo, $tree[$key], $row['ID_fol']);
        }
        print json_encode($tree);
    }
    
    // Обновление/создание документа: запись в БД двоичных данных
    function set_doc($pdo, $table, $ins_id, $data) {
        $sql    = "INSERT INTO $table (ID_ins, data)
            VALUES ($ins_id, '$data')
            ON DUPLICATE KEY UPDATE ID_ins = $ins_id";
        $result = $pdo->query($sql);
    }
    
    // Обновление/создание директории
    // если указан режим ed (edit directory),   то id используется как собственный для обновления записи,
    // если указан режим nd (new directory),    то id используется как родительский для создания подчинённой папки
    function set_dir($pdo, $id, $mode, $dir_name) {
        switch($mode) {
            case 'ed':
                $sql    = "UPDATE Folder SET fol_name = '$dir_name' WHERE ID_fol = $id";
                $result = $pdo->query($sql);
                break;
            case 'nd':
                $sql    = "INSERT INTO Folder (ID_fol, fol_name, ID_fol_parent) VALUES (NULL, '$dir_name', $id)";
                $result = $pdo->query($sql);
                break;
        }
    }
    
    // Обновление/создание файла (инструкции, к которой можно прикреплять файлы)
    // если указан режим ef (edit file),    то id используется как собственный для обновления записи,
    // если указан режим nf (new file),     то id используется как родительский для создания инструкции в папке с этим id
    function set_file($pdo, $id, $mode, $file_name, $conf_id) {
        switch($mode) {
            case 'ef':
                $time   = get_date();
                $sql    = "UPDATE Instruction SET ins_name = '$file_name', ins_date = '$time' WHERE ID_ins = $id";
                
                try {
                    $pdo->beginTransaction();
                        $result = $pdo->query($sql);
                        
                        if (is_uploaded_file($_FILES['docoriginal']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docoriginal']['tmp_name']));
                            set_doc($pdo, 'Docoriginal', $id, $doc);
                        }                        
                        if (is_uploaded_file($_FILES['docreadonly']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docreadonly']['tmp_name']));
                            set_doc($pdo, 'Docreadonly', $id, $doc);
                        }
                        if (is_uploaded_file($_FILES['docreadonlyie']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docreadonlyie']['tmp_name']));
                            set_doc($pdo, 'Docreadonlyie', $id, $doc);
                        }
                    $pdo->commit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    echo "Запись не удалась. Ошибка: " . $e->getMessage();
                    exit();
                }
                
                break;
            case 'nf':
                $time   = get_date();
                $sql    = "INSERT INTO Instruction (ID_ins, ins_name, ID_fol, ins_date, ID_user_editor, ID_conf)
                    VALUES (NULL, '$file_name', $id, '$time', NULL, $conf_id)";
                try {
                    $pdo->beginTransaction();
                        $result = $pdo->query($sql);
                        $now_id = $pdo->lastInsertId();
                        
                        if (is_uploaded_file($_FILES['docoriginal']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docoriginal']['tmp_name']));
                            set_doc($pdo, 'Docoriginal', $now_id, $doc);
                        }                        
                        if (is_uploaded_file($_FILES['docreadonly']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docreadonly']['tmp_name']));
                            set_doc($pdo, 'Docreadonly', $now_id, $doc);
                        }                        
                        if (is_uploaded_file($_FILES['docreadonlyie']['tmp_name'])) {
                            $doc    = addslashes(file_get_contents($_FILES['docreadonlyie']['tmp_name']));
                            set_doc($pdo, 'Docreadonlyie', $now_id, $doc);
                        }
                    $pdo->commit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    echo "Запись не удалась. Ошибка: " . $e->getMessage();
                    exit();
                }
                
                break;
        }
    }
    
    // Запись сообщения об ошибке (неточности в инструкции)
    function set_feedback($pdo, $ins_id, $feedback) {
        $time   = get_date();
        $sql    = "INSERT INTO Feedback (ID_fb, ID_ins, ID_user_name, date, data, fixed)
            VALUES (NULL, $ins_id, NULL, '$time', '$feedback', 0)";
        $result = $pdo->query($sql);
        print json_encode('');
    }
    
    // Получение списка доступных конфигураций
    function get_conf_list($pdo) {
        $sql = "SELECT ID_conf, conf_name FROM Configuration";
        $result = $pdo->query($sql);
        $result_arr = [];
        foreach($result as $row) {
            $result_arr[] = array(
                'id'    => $row['ID_conf'],
                'name'  => $row['conf_name']
            );
        }
        print json_encode($result_arr);
    }
    
    // Получение id конфигурации по id инструкции
    function get_conf_id_by_ins_id($ins_id) {
        $pdo    = connect_db();
        $sql    = "SELECT ID_conf FROM Instruction WHERE ID_ins = $ins_id LIMIT 1";
        $result = $pdo->query($sql);
        foreach($result as $row) {
            return $row['ID_conf'];
        }
    }
    
    // Запись в журнал регистрации; операции с папками и инструкциями
    function write_log_ins_dir($pdo, $id, $mode) {
        $time = get_date();
        $login = htmlspecialchars($_SESSION['instruportal_user']);
        $user_id = get_user_id($pdo, htmlspecialchars($login));
        if ($user_id == null) {
            $user_id = 'NULL';
        }
        $sql = "INSERT INTO Logjournal (ID_log, log_date, log_name, ID_user)
            VALUES (NULL, '$time', '$mode" . "$id;', $user_id)";
        $result = $pdo->query($sql);
    }
    
    // Расшифровка события по его коду
    function unwrap_event($event) {
        $event_code = substr($event, 0, 2);
        $id         = substr($event, 2, -1);
        switch($event_code) {
            case 'nd':
                $mode_in_string = 'Создание папки, id родителя: ';
                break;
            case 'nf':
                $mode_in_string = 'Создание инструкции, id родителя: ';
                break;
            case 'ed':
                $mode_in_string = 'Переименование папки, id: ';
                break;
            case 'ef':
                $mode_in_string = 'Редактирование инструкции (переименование / перезагрузка файлов), id: ';
                break;
            case 'dd':
                $mode_in_string = 'Удаление папки, id: ';
                break;
            case 'df':
                $mode_in_string = 'Удаление инструкции, id: ';
                break;
            default:
                $mode_in_string = 'Неизвестное действие, id: ';
                break;
        }
        return $mode_in_string . $id;
    }
    
    /* Выборка из журнала регистрации;
     * если оба параметра пусты, сформируется первая страница журнала;
     * если есть параметр id (id инструкции), сформируется выборка из журнала, где будут все записи, связанные с этой инструкцией,
     * если есть параметр page, сформируется выбранная страница журнала.
     */
    function get_logj($pdo, $id, $page) {
        // Массив имён пользователей
        $users_buff = [];
        $sql        = "SELECT ID_user, login FROM User";
        $result     = $pdo->query($sql);
        $names      = [];
        foreach($result as $row) {
            $names[$row['ID_user']] = $row['login'];
        }
        
        if ($id != null) {
            $sql        = "SELECT * FROM Logjournal WHERE LOCATE('ef$id;', log_name)
                            UNION
                            SELECT * FROM Logjournal WHERE LOCATE('df$id;', log_name)";
            $result     = $pdo->query($sql);
            $result_arr = [];
            $counter    = 1;
            foreach($result as $row) {
                $result_arr[] = array(
                    'n'     => $counter,
                    'date'  => get_date_normal($row['log_date']),
                    'event' => unwrap_event($row['log_name']),
                    'user'  => $names[$row['ID_user']]
                );
                $counter++;
            }
            print json_encode($result_arr);
        } else {
            $portion_size   = 5;
            $min_cnt        = ($page - 1) * $portion_size;
            
            $sql        = "SELECT * FROM Logjournal LIMIT $min_cnt, $portion_size";
            $result     = $pdo->query($sql);
            $result_arr = [];
            // Инициализация номера следующей строки
            $counter    = ($page - 1) * $portion_size + 1;
            foreach($result as $row) {
                $result_arr[] = array(
                    'n'     => $counter,
                    'date'  => get_date_normal($row['log_date']),
                    'event' => unwrap_event($row['log_name']),
                    'user'  => $names[$row['ID_user']]
                );
                $counter++;
            }
            print json_encode($result_arr);
        }
    }
    
    // Удаление папки или инструкции (полностью)
    function delete_ins_dir($pdo, $type, $id) {
        switch($type) {
            case 'dir':
                $table          = 'Folder';
                $id_col_name    = 'ID_fol';
                break;
            case 'file':
                $table          = 'Instruction';
                $id_col_name    = 'ID_ins';
                break;
            default:
                exit;
        }
        $sql = "DELETE FROM $table WHERE $id_col_name = $id LIMIT 1";
        $result = $pdo->query($sql);
        
        $mode = $type == 'dir' ? 'dd' : 'df';
        write_log_ins_dir($pdo, $id, $mode);
        print json_encode('');
    }
    
    // Получение списка всех инструкций (для нахождения ответственного за последние изменения)
    function get_ins_list($pdo) {
        $sql = "SELECT ID_ins, ins_name FROM Instruction";
        $result = $pdo->query($sql);
        
        $result_arr = [];
        foreach($result as $row) {
            $result_arr[] = array(
                'id'    => $row['ID_ins'],
                'name'  => $row['ins_name']
            );
        }
        print json_encode($result_arr);
    }
    
    // --------------------------------------------------------------------------------------------------------
    // Ветви обработчиков форм
    // --------------------------------------------------------------------------------------------------------
    
    $pdo = connect_db();
    if (isset($_POST['nulogin'])) { // new user login
        create_user($pdo, htmlspecialchars($_POST['nulogin']), htmlspecialchars($_POST['nupw']));
    } elseif (isset($_POST['okbtnfordir'])) { // new directory
        $okbtnfordir    = htmlspecialchars($_POST['okbtnfordir']);
        $dirname        = htmlspecialchars($_POST['dirname']);
        
        $id             = substr($okbtnfordir, 2);
        $mode           = substr($okbtnfordir, 0, 2);
        set_dir($pdo, $id, $mode, $dirname);
        write_log_ins_dir($pdo, $id, $mode);
        header('Location: ../panel/instr/index.php');
    } elseif (isset($_POST['okbtnforfile'])) { // new file
        $okbtnforfile   = htmlspecialchars($_POST['okbtnforfile']);
        $filename       = htmlspecialchars($_POST['filename']);
        $rootdir        = htmlspecialchars($_POST['rootdir']);
        
        $id             = substr($okbtnforfile, 2);
        $mode           = substr($okbtnforfile, 0, 2);
        set_file($pdo, $id, $mode, $filename, $rootdir);
        write_log_ins_dir($pdo, $id, $mode);
        header('Location: ../panel/instr/index.php');
    }
?>