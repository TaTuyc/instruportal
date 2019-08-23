<?php
include_once './php/common.php';
    $pdo = connect_db();
    if (isset($_GET['id'])) {
        $value  = htmlspecialchars($_GET['id']);
        $is_ie  = (htmlspecialchars($_GET['ie']) == 'true');
        if ($is_ie) {
            $sql    = "SELECT data FROM Docreadonlyie WHERE ID_ins = $value LIMIT 1";
            $result = $pdo->query($sql);
            foreach($result as $row) {
                header("Content-type: message/rfc822");
                echo $row['data'];
            }
        } else {
            $sql    = "SELECT data FROM Docreadonly WHERE ID_ins = $value LIMIT 1";
            $result = $pdo->query($sql);
            foreach($result as $row) {
                header("Content-type: application/pdf");
                echo $row['data'];
            }
        }
    }
?>