<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
	<head>
        <title>Регистрация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/main_dop.css">
        <style  type="text/css">
          body {background-color: white;}
        </style>
    </head>
    <body>
		<form method="post" action="includes/checkRegister.php" class="enter_system_form">
      <p class="enter_system_name">Регистрация</p>
			<label>Логин:</label>
			<input type="text" name="login" class="enter_system_input">
			<label>Пароль:</label>
			<input type="password" name="password" class="enter_system_input">
			<label>Подтверждение пароля:</label>
			<input type="password" name="password_confirm" class="enter_system_input">
			<label>Имя:</label>
			<input type="text" name="name" class="enter_system_input">
			<label>Почта:</label>
			<input type="email" name="email" class="enter_system_input">
			<p>
				<a href="login.php" class="enter_a">У меня уже есть аккаунт</a>
			</p>
			<button type="submit" class="enter_system_button">Зарегистрироваться</button>
			<?php
				if (isset($_SESSION['message'])) {
					echo '<p class="msg">'.$_SESSION['message'].'</p>';
				}
				unset($_SESSION['message']);
			?>
		</form>
    </body>
</html>
