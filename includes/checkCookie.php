<?php
	session_start();
	if ($_COOKIE['login'] and $_COOKIE['pass']) {
		$login = $_COOKIE['login']; 
		$password = $_COOKIE['pass'];

		require_once 'includes/connection.php';

		$result = mysqli_query($connect,
			"SELECT * FROM `users`
			WHERE `login`='$login' AND `password`='$password'");
		mysqli_close($connect);
		if ($result) {
			$result = mysqli_fetch_assoc($result);
			$_SESSION['user'] = [
				"login" => $result['login'],
				"name" => $result['name']
			];
			
			setcookie('login', $login, time() + 60 * 5);
			setcookie('pass', $password, time() + 60 * 5);
		}
		else {
			header("location: ../login.php");
		}
	}
	else {
		header("location: ../login.php");
	}
?>