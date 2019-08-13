<?php
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
            function setbyconst() {
                document.getElementById('copyright').innerHTML = const_copyright;
            }
        </script>
	</head>

	<body>
        <div id="wrapper">
            <div class="table-responsive text-center">
                <table class="bhi" style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 551px" class="text-center"><a href="../index.php"><img src="../img/genlogo.png" alt="Лого" width="551px" height="62px" title="Перейти на главную страницу"></a></td>
                            <td class="text-center text-char-header">Портал инструкций по работе с АСРН-2</td>
                            <td>
                                <button type="button" class="btn feedbackbtn" style="color: transparent; background-color: transparent">Сообщить об ошибке</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
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
            
            <div id="footer" class="text-char-small extra-info">
                <a id="copyright">©  ООО «Иркутская Энергосбытовая компания», 2019 г. 0+</a>
            </div>
        </div>
        <script type="text/javascript">
            setbyconst();
        </script>
	</body>
</html>