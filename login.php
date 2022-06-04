<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Авторизация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/main_dop.css">
        <style  type="text/css">
          body {background-color: white;}
        </style>
    </head>
    <body>
        <form method="post" action="includes/checkLogin.php" class="enter_system_form">
            <p class="enter_system_name">Вход в систему</p>
            <label>Логин:</label>
            <input type="text" name="login" class="enter_system_input">
            <label>Пароль:</label>
            <input type="password" name="password" class="enter_system_input">
            <p>
                <a href="recoverPassword.php" class="enter_a">Восстановить пароль</a>
            </p>
            <p>
                <a href="register.php" class="enter_a">Регистрация</a>
            </p>
            <button type="submit" class="enter_system_button">Войти</button>
            <?php
                if (isset($_SESSION['message'])) {
                    echo '<p class="msg">'.$_SESSION['message'].'</p>';
                }
                unset($_SESSION['message']);
            ?>
        </form>
    </body>
</html>
