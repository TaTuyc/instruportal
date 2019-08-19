<?php
	include_once '../php/iface.php';
	include_once '../php/common.php';
	$pdo = connect_db();
	
	$data = $_POST;
	$errors = array();
    if (isset($data['log_in'])) {
		$login	= $data['login'];
		$pw		= $data['password'];
		if (find_user($pdo, $login)) {
			//логин существует
			if (check_password($pdo, $login, $pw)) {
				//если пароль совпадает, то авторизовать пользователя
				$_SESSION['instruportal_user'] = $login;
				session_write_close();
                header('Location: ../panel/index.php');
				exit();
			} else {
				$errors[] = 'Неверный пароль!';
			}
		} else {
			$errors[] = 'Пользователь не найден!';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Вход</title>
		<link rel="stylesheet" href="../css/login.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script type="text/javascript" src="../js/const.js"></script>
        <script type="text/javascript">
            function setByConst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
        </script>
	</head>

	<body>
        <div id="wrapper">
            <?php
				draw_header(2);
			?>
            
            <form id="login" action="index.php" method="post">
                <h1>Вход в систему</h1>
                <?php
					if (!empty($errors)) {
                        echo "<p style = \"color: red; font-size: 14pt; margin: 0; padding: 0\">" . array_shift($errors);
                    }
                ?>
                <fieldset id="inputs">
                    <input id="username" name="login" type="text" placeholder="Логин" autofocus required>
                    <input id="password" name="password" type="password" placeholder="Пароль" required>
                </fieldset>
                <fieldset id="actions">
                    <input id="submit" type="submit" name="log_in" value="Войти">
                </fieldset>
            </form>
            
            <?php
				draw_footer(2);
			?>
        </div>
        <script type="text/javascript">
            setByConst();
        </script>
	</body>
</html>