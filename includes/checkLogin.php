<?php
    session_start();
    if ($_POST['login'] and $_POST['password']) {
        print_r($login);
        $login = $_POST['login']; 
        $password = $_POST['password'];

        require_once 'includes/connection.php';

        $result = mysqli_query($connect,
            "SELECT * FROM `users`
            WHERE `login`='$login' AND `password`='$password'");
        mysqli_close($connect);
        
        if (!$result) {
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
            $_SESSION['message'] = 'Неверный логин или пароль';
            header('location: ../login.php');
        }
    }
    else {
        $_SESSION['message'] = 'Заполнены не все поля';
        header('location: ../login.php');
    }
?>