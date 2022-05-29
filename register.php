<?php
	if (isset($_POST['register'])) {
		if (
			!empty($_POST['userLogin']) and
			!empty($_POST['userPass']) and
			!empty($_POST['userName']) and
			!empty($_POST['userEmail'])
		) {
			$login = $_POST['userLogin'];
			$password = $_POST['userPass'];
			$name = $_POST['userName'];
			$email = $_POST['userEmail'];

			include("includes/connection.php");

			$sql = 'SELECT * FROM users WHERE login="'.$login.'"';
			$isLoginFree = mysqli_fetch_all(mysqli_query($link, $sql));

			if (empty($isLoginFree)) {
				$sql = 'INSERT INTO users SET login="'.$login.'", 
					password="'.$password.'", name="'.$name.'", email="'.$email.'"';
				$result = mysqli_query($link, $sql);
				if (!$result) {
					print("Произошла ошибка при выполнении запроса 1");
				}
				else {
					$userLogin = mysqli_insert_id($link);
					$sql = 'INSERT INTO menu (owner, name, url, pos)
					VALUES('.$userLogin.',\'Загрузить\',\'loader.php\', 0),
					('.$userLogin.',\'Смотреть\',\'main.php\', 1),
					('.$userLogin.',\'Удалить\',\'editor.php\', 2),
					('.$userLogin.',\'Поиск\',\'finder.php\', 3)';
					$result = mysqli_query($link, $sql);
					mysqli_close($link);
					if (!$result) {
						print("Произошла ошибка при выполнении запроса 2");
					}
					else {
						$message = "Вы успешно зарегистрировались, вернитесь к авторизации";
					}
				}
			}
			else {
				$message = "Такой логин уже занят";
			}
		}
		else {
			$message = "Заполните все поля";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
        <title>Регистрация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div>
                <h1>Регистрация</h1>
                <form method="post" action="/login.php">
                    <label>Логин:</label><br>
                    <input type="text" name="userLogin"><br><br>
                    <label>Пароль:</label><br>
                    <input type="password" name="userPass"><br><br>
					<label>Имя:</label><br>
                    <input type="text" name="userName"><br><br>
                    <label>Почта:</label><br>
                    <input type="email" name="userEmail"><br><br>
                    <a href="login.php">У меня уже есть аккаунт</a>
                    <input type="submit" name="register" value="Регистрация">
                </form>
                <?php if (!empty($message)) {
                    echo "<p>Сообщение: ".$message."</p>";
                }
                ?>
            </div>
        </div>
    </body>
</html>