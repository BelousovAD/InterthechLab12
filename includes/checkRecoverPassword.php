<?php
  session_start();
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/Exception.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer.php');
	require_once ($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/SMTP.php');

	if (!empty($_POST['login'])) {
		$login = $_POST['login'];

		require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

		$result = mysqli_query($connect,
            "SELECT * FROM `users`
            WHERE `login`='$login'");
            mysqli_close($connect);

		if (mysqli_num_rows($result) > 0) {
      $result = mysqli_fetch_assoc($result);
			$mail = new PHPMailer();

			$mail->isSMTP();

			$mail->SMTPDebug = SMTP::DEBUG_SERVER;

			$mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
      $mail->Username = 'zhelamskije@yandex.ru';
      $mail->Password = '';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = 465;//25 465 587

			$mail->setFrom('zhelamskije@yandex.ru', 'lab12');

			$mail->addAddress($result['email']); // , $result['name']
      $mail->CharSet = 'UTF-8';

$mail->isHTML(true);

			$mail->Subject = 'Восстановление пароля в Лабораторной работе 12!';

			//$mail->msgHTML($body);
$mail->Body = '<strong>Логин: '.$login.'<br>Пароль: '.$result['password'].'</strong>';
			if (!$mail->send()) {
				$_SESSION['message'] = 'Ошибка при отправке. Ошибка:'.$mail->ErrorInfo;
                //header('location: ../recoverPassword.php');
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
