<?php
    session_start();
    if (isset($_POST['login']) and isset($_POST['password'])) {
        $login = $_POST['login']; 
        $password = $_POST['password'];

        $connect = mysqli_connect('localhost', 'root', 'root', 'lab12');
        if (!$connect) {
            die('Error connect to DataBase'.mysqli_connect_error());
        }

        $result = mysqli_query($connect,
            "SELECT * FROM `users`
            WHERE `login`='$login' AND `password`='$password'");
            
        
        if (!$result) {
            $result = mysqli_fetch_assoc($result);
            mysqli_close($connect);
            $_SESSION['user'] = [
				"login" => $result['login'],
				"name" => $result['name']
			];       

            setcookie('login', $login, time() + 60 * 5);
            setcookie('pass', $password, time() + 60 * 5);
            
            header("location: ../index.php");
        }
        else {
            mysqli_close($connect);
            $_SESSION['message'] = 'Неверный логин или пароль';
            header('location: ../login.php');
        }
    }
    else {
        $_SESSION['message'] = 'Заполнены не все поля';
        header('location: ../login.php');
    }
?>