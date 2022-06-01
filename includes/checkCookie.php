<?php
	session_start();
	if (!empty($_COOKIE['login']) and !empty($_COOKIE['pass'])) {
		$login = $_COOKIE['login']; 
		$password = $_COOKIE['pass'];

		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

		$result = mysqli_query($connect,
			"SELECT * FROM `users`
			WHERE `login`='$login' AND `password`='$password'");
		mysqli_close($connect);
		
		if (mysql_num_rows($result) > 0) {
			$result = mysqli_fetch_assoc($result);
			$_SESSION['user'] = [
				"login" => $result['login'],
				"name" => $result['name']
			];
			
			setcookie('login', $login, time() + 60 * 5);
			setcookie('pass', $password, time() + 60 * 5);

			header("location: ../index.php");
		}
		else {
			header("location: ../login.php");
		}
	}
	else {
		header("location: ../login.php");
	}
?>