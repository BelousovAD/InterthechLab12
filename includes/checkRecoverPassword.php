<?php
require '/PHPMailer/src/Exception.php';
require '/PHPMailer/src/PHPMailer.php';
require '/PHPMailer/src/SMTP.php';
?>

<?php
    start_session();
	if ($_POST['login']) {
		$login = $_POST['login'];

		$connect = mysqli_connect('localhost', 'root', 'root', 'lab12');
        if (!$connect) {
            die('Error connect to DataBase'.mysqli_connect_error());
        }

		$result = mysqli_query($link,
            "SELECT (`password`, `name`, `email`) FROM `users`
            WHERE `login`='$login'");
            mysqli_close($connect);

		if (mysqli_num_rows($result) > 0) {
            $result = mysqli_fetch_assoc($result);
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
				$_SESSION['message'] = 'Ошибка при отправке. Ошибка:'.$mail->ErrorInfo;
                header('location: ../recoverPassword.php');			
			}
			else {
				$_SESSION['message'] = 'На ваш почтовый ящик было отправлено письмо с паролем';
                header('location: ../login.php');	
			}
		}
		else {
			$_SESSION['message'] = 'Пользователя с таким логином не существует';
            header('location: ../recoverPassword.php');	
		}
	}
	else {
		$_SESSION['message'] = 'Заполните все поля';
        header('location: ../recoverPassword.php');	
	}
?>