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
            case 'get_conf_list':
                echo get_conf_list($pdo);
                break;
            case 'get_logj':
                echo get_logj($pdo, htmlspecialchars($_POST['id']), htmlspecialchars($_POST['page']));
                break;
            case 'get_ins_list':
                echo get_ins_list($pdo);
                break;
            case 'get_fb_messages':
                echo get_fb_messages($pdo, htmlspecialchars($_POST['page']));
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
            case 'set_feedback':
                echo set_feedback($pdo, htmlspecialchars($_POST['ID_ins']), htmlspecialchars($_POST['feedback']));
                break;
            case 'delete_dir':
                echo delete_ins_dir($pdo, 'dir', htmlspecialchars($_POST['id']));
                break;
            case 'delete_file':
                echo delete_ins_dir($pdo, 'file', htmlspecialchars($_POST['id']));
            case 'check_logj':
                echo check_logj($pdo, htmlspecialchars($_POST['page']));
                break;
            case 'check_fb_messages':
                echo check_fb_messages($pdo, htmlspecialchars($_POST['page']));
                break;
            case 'delete_fb_messages':
                echo delete_fb_messages($pdo, $_POST['fbmes']);
                break;
            case 'change_status_fb_messages':
                echo change_status_fb_messages($pdo, $_POST['fbmes']);
                break;
            default:
                break;
        }
    }
?>