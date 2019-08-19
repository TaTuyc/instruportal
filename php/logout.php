<?php
	session_start();
	unset($_SESSION['instruportal_user']);
	header('Location: ../index.php');
?>