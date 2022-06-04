<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Восстановление пароля</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
		<form method="post" action="includes/checkRecoverPassword.php">
			<label>Логин:</label><br>
			<input type="text" name="login"><br><br>
			<a href="login.php">Вернуться обратно</a>
			<input type="submit" name="submit" value="Отправить">
			<?php
				if (isset($_SESSION['message'])) {
					echo '<p class="msg">'.$_SESSION['message'].'</p>';
				}
				unset($_SESSION['message']);
			?>
		</form>
    </body>
</html>