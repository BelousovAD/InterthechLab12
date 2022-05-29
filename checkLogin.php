<?php
	if (isset($_POST['login'])) {
        if (!empty($_POST['userLogin']) and !empty($_POST['userPass'])) {
            $login = $_POST['userLogin']; 
            $password = $_POST['userPass'];

            require "includes/connection.php";
            
            $result = mysqli_query($link, "SELECT * FROM users WHERE login=`$login` AND password=`$password`");
            echo "<script>console.log(`$result`);</script>";
            
            echo "<script>console.log('Запрос отправлен' );</script>";
            if (!empty($result)) {
                $rows = mysqli_fetch_all($result);
                echo "<script>console.log(`$rows`);</script>";
                session_start();
                $_SESSION['auth'] = true;
    
                $_SESSION['login'] = $result['login']; 
                $_SESSION['name'] = $result['name'];            
                setcookie('login', $login, time() + 60 * 5);
                setcookie('pass', $password, time() + 60 * 5);
                mysqli_close($link);
                header("location:index.php");
            }
            else {
                echo "<script>console.log('Пользователь не найден' );</script>";
                $_COOKIE['message'] = 'Неверный логин или пароль';
                header('location:login.php');
            }
        }
        else {
            echo "<script>console.log('Заполнены не все поля' );</script>";
            $_COOKIE['message'] = 'Заполните все поля';
            header('location:login.php');
        }
    }
    else {
        echo "<script>console.log('Проблемы с отправкой формы');</script>";
    }
?>