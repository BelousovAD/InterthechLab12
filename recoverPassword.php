<?php 
require_once '/PHPMailer/src/Exception.php';
require_once '/PHPMailer/src/PHPMailer.php';
require_once '/PHPMailer/src/SMTP.php'; ?>

<?php
if (isset($_POST["submit"]))
	if (!empty($_POST['userLogin'])) {
		$login = $_POST['userLogin'];

		include("includes/connection.php");

		$sql = mysqli_query('SELECT (password, name, email) FROM users WHERE login="'.$login.'"');
		$result = mysqli_fetch_all(mysqli_query($link, $sql));
		if (!empty($result)) {
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';

			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 0;

			$mail->Host = 'ssl://smtp.yandex.ru';
			$mail->Port = 465;
			$mail->Username = 'ya.belousow-lesha2015@yandex.ru';
			$mail->Password = 'vzqheiinsftmucsc';

			$mail->setFrom('no_reply-lab12@yandex.ru', 'No_reply');

			$mail->addAddress($result['email'], $result['name']);

			$mail->Subject = 'Восстановление пароля в Lab12';

			$body = '<strong>Логин: '.$login.'<br>Пароль: '.$result['password'].'</strong>';
			$mail->msgHTML($body);
			
			if (!$mail->send()) {
				$message = "Ошибка при отправке. Ошибка:" . $mail->ErrorInfo;				
			}
			else {
				$message = "На ваш почтовый ящик было отправлено письмо с паролем";
			}
		}
		else {
			$message = "Пользователя с таким логином не существует";
		}
	}
	else {
		$message = "Заполните все поля";
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Восстановление пароля</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div>
                <h1>Восстановление пароля</h1>
                <form method="post" action="pass.php">
                    <label>Логин:</label><br>
                    <input type="text" name="userLogin"><br><br>
                    <a href="login.php">Вернуться обратно</a>
                    <input type="submit" name="submit" value="Отправить">
                </form>
                <?php if (!empty($message)) {
                    echo "<p>Сообщение: ".$message."</p>";
                }
                ?>
            </div>
        </div>
    </body>
</html>