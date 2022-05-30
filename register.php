<?php
    session_start();
    if ($_SESSION['user']) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
	<head>
        <title>Регистрация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
		<form method="post" action="includes/checkRegister.php">
			<label>Логин:</label>
			<input type="text" name="login">
			<label>Пароль:</label>
			<input type="password" name="password">
			<label>Подтверждение пароля:</label>
			<input type="password" name="password_confirm">
			<label>Имя:</label>
			<input type="text" name="name">
			<label>Почта:</label>
			<input type="email" name="email">
			<p>
				<a href="login.php">У меня уже есть аккаунт</a>
			</p>
			<button type="submit">Зарегистрироваться</button>
			<?php
				if ($_SESSION['message']) {
					echo '<p class="msg">'.$_SESSION['message'].'</p>';
				}
				unset($_SESSION['message']);
			?>
		</form>
    </body>
</html>