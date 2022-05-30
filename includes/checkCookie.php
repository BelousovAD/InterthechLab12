<?php
	session_start();
	if ($_COOKIE['login'] and $_COOKIE['pass']) {
		$login = $_COOKIE['login']; 
		$password = $_COOKIE['pass'];

		$connect = mysqli_connect('localhost', 'root', 'root', 'lab12');
        if (!$connect) {
            die('Error connect to DataBase'.mysqli_connect_error());
        }

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