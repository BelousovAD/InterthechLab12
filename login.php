<!DOCTYPE html>
<html>
    <head>
        <title>Авторизация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div>
                <h1>Вход</h1>
                <form method="post" action="checkLogin.php">
                    <label>Логин:</label><br>
                    <input type="text" name="userLogin"><br><br>
                    <label>Пароль:</label><br>
                    <input type="password" name="userPass"><br><br>
                    <a href="recoverPassword.php">Восстановить пароль</a>
                    <a href="register.php">Регистрация</a>
                    <input type="submit" name="login" value="Войти">
                </form>
                <?php if (!empty($_COOKIE['message'])) {
                    echo "<p>Сообщение: ".$_COOKIE['message']."</p>";
                }
                ?>
            </div>
        </div>
    </body>
</html>