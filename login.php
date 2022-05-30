<?php
    session_start();
    if ($_SESSION['user']) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Авторизация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form method="post" action="includes/checkLogin.php">
            <label>Логин:</label>
            <input type="text" name="login">
            <label>Пароль:</label>
            <input type="password" name="password">
            <p>
                <a href="recoverPassword.php">Восстановить пароль</a>
            </p>
            <p>
                <a href="register.php">Регистрация</a>
            </p>
            <button type="submit">Войти</button>
            <?php
                if ($_SESSION['message']) {
                    echo '<p class="msg">'.$_SESSION['message'].'</p>';
                }
                unset($_SESSION['message']);
            ?>
        </form>
    </body>
</html>