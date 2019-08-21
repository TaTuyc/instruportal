<?php
    include_once './common.php';
    $pdo = connect_db();
    
    // --------------------------------------------------------------------------------------------------------
    // Ветви обработчиков форм
    // --------------------------------------------------------------------------------------------------------
    
    // Возврат запрашиваемых данных
    if (isset($_POST['fill'])) {
        switch($_POST['fill']) {
            case 'get_users':
                echo get_users_list($pdo);
                break;
            case 'get_settings':
                echo get_settings_list($pdo);
                break;
            default:
                echo null;
                break;
        }
    // Совершение запрашиваемого действия
    } elseif (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'delete_users':
                echo delete_users($pdo, $_POST['users']);
                break;
            case 'update_users':
                echo update_users($pdo, $_POST['users'], $_POST['pws']);
                break;
            case 'update_settings':
                echo update_settings($pdo, $_POST['settings']);
                break;
            case 'reset_settings':
                echo reset_settings($pdo);
                break;
            default:
                break;
        }
    }
?>