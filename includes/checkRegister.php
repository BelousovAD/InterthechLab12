<?php
    session_start();
    if (!empty($_POST['login']) and
        !empty($_POST['password']) and
        !empty($_POST['password_confirm']) and
        !empty($_POST['name']) and
        !empty($_POST['email'])
        ) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        if ($password === $password_confirm) {
            require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

            $isLoginFree = mysqli_query($connect,
                "SELECT * FROM `users`
                WHERE `login`='$login'");
            if (mysqli_num_rows($isLoginFree) == 0) {
                $result = mysqli_query($connect,
                    "INSERT INTO `users`
                    VALUES ('$login', '$password', '$name', '$email')");
                if (!$result) {
                    mysqli_close($connect);
                    $_SESSION['message'] = 'Произошла ошибка регистрации пользователя';
                    header('location: ../register.php');
                }
                else {
                    $result = mysqli_query($connect,
                        "INSERT INTO `menu` (`owner`, `name`, `url`, `pos`)
                        VALUES('$login', 'Главная', 'index.php', '0'),
                        ('$login', 'Галерея', 'gallery.php', '1'),
                        ('$login', 'Пользователи', 'users.php', '2'),
                        ('$login', 'Загрузить изображение', 'upload.php', '3')");
                        mysqli_close($connect);
                    if (!$result) {
                        $_SESSION['message'] = 'Произошла ошибка обновления настроек пользователя';
                        header('location: ../register.php');
                    }
                    else {
                        $_SESSION['message'] = 'Вы успешно зарегистрировались';
                        header('location: ../login.php');
                    }
                }
            }
            else {
                mysqli_close($connect);
                $_SESSION['message'] = 'Такой логин уже занят';
                header('location: ../register.php');
            }
        }
        else {
            $_SESSION['message'] = 'Пароли не совпадают';
            header('location: ../register.php');
        }
    }
    else {
        $_SESSION['message'] = 'Заполнены не все поля';
        header('location: ../register.php');
    }
?>