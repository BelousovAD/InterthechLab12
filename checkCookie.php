<?php
	if (!empty($_COOKIE['login']) and !empty($_COOKIE['pass'])) {
		$login = $_COOKIE['login']; 
		$password = $_COOKIE['pass'];

		include("includes/connection.php");

		$sql = 'SELECT * FROM users WHERE login="'.$login.'" AND password="'.$password.'"';
		$result = mysqli_fetch_all(mysqli_query($link, $query));
		mysqli_close($link);
		if (!empty($result)) {
			session_start(); 
			$_SESSION['auth'] = true;
			
			$_SESSION['login'] = $result['login'];
			$_SESSION['name'] = $result['name'];
			setcookie('login', $login, time() + 60 * 5);
			setcookie('pass', $password, time() + 60 * 5);
		}
		else {
			echo "<script>console.log('Cookie не корректно');</script>";
			header("location:login.php");
		}
	}
	else {
		echo "<script>console.log('Cookie не найдено');</script>";
		header("location:login.php");
	}
?>