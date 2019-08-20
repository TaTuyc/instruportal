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
            default:
                echo null;
                break;
        }
    } elseif (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'delete_users':
                echo delete_users($pdo, $_POST['users']);
                break;
            default:
                break;
        }
    }
?>