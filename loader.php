<?php include("includes/connection.php"); ?>
<?php session_start();
// Пути загрузки файлов
$path = 'i/';
$tmp_path = 'tmp/';
// Массив допустимых значений типа файла
$types = array('image/gif', 'image/png', 'image/jpeg');
// Максимальный размер файла
$size = 1024000;

// Обработка запроса
if (isset($_POST['pic'])) {

	// Функция изменения размера
	//	quality - качество изображения (по умолчанию 75%)
	function resize($file, $type = 1, $quality = null)
	{
		global $tmp_path;

		// Ограничение по ширине в пикселях
		$w = 200;

		// Качество изображения по умолчанию
		if ($quality == null)
			$quality = 75;

		$tt = '';
		// Cоздаём исходное изображение на основе исходного файла
		if ($file['type'] == 'image/jpeg') {
			$source = imagecreatefromjpeg($file['tmp_name']);
			$tt = '.jpg';
		} elseif ($file['type'] == 'image/png') {
			$source = imagecreatefrompng($file['tmp_name']);
			$tt = '.png';
		} elseif ($file['type'] == 'image/gif') {
			$source = imagecreatefromgif($file['tmp_name']);
			$tt = '.gif';
		} else
			return false;

		$src = $source;
		// Создание штампа(вотермарка)
		$stamp = imagecreatetruecolor(100, 70);
		imagestring($stamp, 5, 1, 20, $_SESSION["session_username"], 0x0000FF);
		// Установка полей для штампа и получение высоты/ширины штампа
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Определяем ширину и высоту изображения
		$w_src = imagesx($src);
		$h_src = imagesy($src);

		// Если ширина больше заданной
		if ($w_src > $w) {
			// Вычисление пропорций
			$ratio = $w_src / $w;
			$w_dest = round($w_src / $ratio);
			$h_dest = round($h_src / $ratio);

			// Создаём пустую картинку
			$dest = imagecreatetruecolor($w_dest, $h_dest);

			// Копируем старое изображение в новое с изменением параметров
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
			imagecopymerge($dest, $stamp, imagesx($dest) - $sx - $marge_right, imagesy($dest) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 75);

			$ttt = '_s';
			$ttt .= $tt;
			$tm = $file['name'];
			// Вывод картинки и очистка памяти
			$tm = str_replace($tt, $ttt, $file['name']);
			imagejpeg($dest, $tmp_path . $tm, $quality);
			imagedestroy($dest);
			imagedestroy($src);

			return $tm;
		} else {
			// Вывод картинки и очистка памяти
			imagejpeg($src, $tmp_path . $tm, $quality);
			imagedestroy($src);

			return $tm;
		}
	}
	if (!empty($_POST['name']) && !empty($_POST['description'])) {

		if (!in_array($_FILES['picture']['type'], $types))
			die('<p>Запрещённый тип файла. <a href="?">Попробовать другой файл?</a></p>');

		// Проверяем размер файла
		if ($_FILES['picture']['size'] > $size) {
			die('<p>Слишком большой размер файла. <a href="?">Попробовать другой файл?</a></p>');
		}
		$name = resize($_FILES['picture'], $_POST['file_type']);
		// Загрузка файла и вывод сообщения

		move_uploaded_file($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']);

		if (!@copy($tmp_path . $name, $path . $name)) {
			echo '<p>Что-то пошло не так.</p>';
		} else {
			$fowner = $_COOKIE['session'];
			$fname = $_POST['name'];
			$fdesc = $_POST['description'];
			$fimg_s = $name;
			$fimg = $_FILES['picture']['name'];

			$query = mysql_query("SELECT * FROM pics WHERE name='" . $fname . "'");
			$numrows = mysql_num_rows($query);

			if ($numrows == 0) {
				$sql = "INSERT INTO pics
				(owner, name, img, description, img_s) 
				VALUES('$fowner','$fname','$fimg','$fdesc','$fimg_s')";

				$result = mysql_query($sql);

				if ($result)
					$mess = 'Успешно загружено';
				else
					$mess = 'Не удалось загрузить';
			} else
				$mess = 'Такое имя уже есть в базе, выберите другое';
			unlink($tmp_path . $name);
		}
		// Удаляем временный файл
	} else {
		$mess = '<h2><br><br>Заполните все поля</h2>';
	}
}
?>

<?php include("includes/header.php"); ?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Загрузка изображения</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

	<!-- Изменить стиль в CSS -->

	<form method="post" enctype="multipart/form-data" id="welcome">

		<h1>Создание позиции</h1>
		<h2>Название</h2>

		<input type="text" name="name" class="input" value="">
		<br><br><h2>Описание</h2>
		<input type="text" name="description" class="input" value="">
		<br><br><br>
		<input type="file" name="picture">

		<input type="submit" name="pic" value="Загрузить">

		<?php echo $mess;
		if ($name != '')
			echo '<br><img src="i/' . $name . '" alt="img" height="200" width="250"/>';
		?>

	</form>
</body>

</html>

<?php include("includes/footer.php"); ?>