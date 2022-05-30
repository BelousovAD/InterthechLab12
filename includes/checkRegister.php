<?php
    if ($_POST['login'] and
        $_POST['password'] and
        $_POST['password_confirm'] and
        $_POST['name'] and
        $_POST['email']
        ) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        if ($password === $password_confirm) {
            $connect = mysqli_connect('localhost', 'root', 'root', 'lab12');
            if (!$connect) {
                die('Error connect to DataBase'.mysqli_connect_error());
            }

            $isLoginFree = mysqli_fetch_assoc(mysqli_query($connect,
                "SELECT * FROM `users`
                WHERE `login`='$login'"));

            if (!$isLoginFree) {
                $sql = '';
                $result = mysqli_query($connect,
                    "INSERT INTO `users`
                    VALUES ('$login.', '$password', '$name', '$email')");
                if (!$result) {
                    mysqli_close($connect);
                    $_SESSION['message'] = 'Произошла ошибка регистрации пользователя';
                    header('location: ../register.php');
                }
                else {
                    $result = mysqli_query($connect,
                        "INSERT INTO `menu` (`owner`, `name`, `url`, `pos`)
                        VALUES('$login', Загрузить, loader.php, 0),
                        ('$login', Смотреть, main.php, 1),
                        ('$login', Удалить, editor.php, 2),
                        ('$login', Поиск, finder.php, 3)");
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