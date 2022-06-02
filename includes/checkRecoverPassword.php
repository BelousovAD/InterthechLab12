<?php
    session_start();
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/Exception.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/PHPMailer.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/SMTP.php');

	if (!empty($_POST['login'])) {
		$login = $_POST['login'];

		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

		$result = mysqli_query($connect,
            "SELECT * FROM `users`
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
			$mail->Password = '';

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