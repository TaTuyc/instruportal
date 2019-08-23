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
            case 'get_conf_tree':
                echo get_conf_tree($pdo, htmlspecialchars($_POST['ID_conf']));
                break;
            default:
                echo null;
                break;
        }
    // Совершение запрашиваемого действия
    } elseif (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'delete_users':
                echo delete_users($pdo, htmlspecialchars($_POST['users']));
                break;
            case 'update_users':
                echo update_users($pdo, htmlspecialchars($_POST['users']), htmlspecialchars($_POST['pws']));
                break;
            case 'update_settings':
                echo update_settings($pdo, htmlspecialchars($_POST['settings']));
                break;
            case 'reset_settings':
                echo reset_settings($pdo);
                break;
            case 'set_feedback':
                echo set_feedback($pdo, htmlspecialchars($_POST['ID_conf']), htmlspecialchars($_POST['ID_ins']), htmlspecialchars($_POST['feedback']));
                break;
            default:
                break;
        }
    }
?>