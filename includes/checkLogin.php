<?php
    session_start();
    if (!empty($_POST['login']) and !empty($_POST['password'])) {
        $login = $_POST['login']; 
        $password = $_POST['password'];

        require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

        $result = mysqli_query($connect,
            "SELECT * FROM `users`
            WHERE `login`='$login' AND `password`='$password'");
        mysqli_close($connect);
        
        if (mysqli_num_rows($result) > 0) {
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