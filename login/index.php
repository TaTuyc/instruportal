<?php
	include_once '../php/iface.php';
    // TO DO авторизацию закодить
    /*$data = $_POST;
    if (isset($data['log_in'])) {
		$user = $data['usr'];
		if (find_user($pdo, $user)) {
			//логин существует
			if (password_hash($data['pswrd'], PASSWORD_DEFAULT) == find_password($pdo, $user)) {
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				if (!isset($_SESSION['portion_size'])) {
					$_SESSION['portion_size'] = 20;
				}
				session_write_close();
                // TO DO Перенаправление не на главную, а на страницу администратора
				header('Location: ../index.php');
				exit();
			} else {
				$errors[] = 'Неверный пароль!';
			}
		} else {
			$errors[] = 'Пользователь не найден!';
		}
	}*/
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
                    <input id="username" name="usr" type="text" placeholder="Логин" autofocus required>
                    <input id="password" name="pswrd" type="password" placeholder="Пароль" required>
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