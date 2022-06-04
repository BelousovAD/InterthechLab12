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
        <link rel="stylesheet" href="css/main_dop.css">
        <style  type="text/css">
          body {background-color: white;}
        </style>
    </head>
    <body>
		<form method="post" action="includes/checkRecoverPassword.php" class="enter_system_form">
      <p class="enter_system_name enter_system_name_recover">Восстановление пароля</p>
      <label>Логин:</label><br>
			<input type="text" name="login" class="enter_system_input"><br><br>
			<a href="login.php" class="enter_a">Вернуться обратно</a>
			<input type="submit" value="Отправить"  class="enter_system_button">
			<?php
				if (isset($_SESSION['message'])) {
					echo '<p class="msg">'.$_SESSION['message'].'</p>';
				}
				unset($_SESSION['message']);
			?>
		</form>
    </body>
</html>
