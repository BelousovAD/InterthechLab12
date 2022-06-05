<?php
	session_start();

	if (!$_SESSION['user']) {
		header("location: includes/checkCookie.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<div class="main_page_site">
	<h1>Главная страница</h1>
	<div class="main_page_site_discription">
		Это главная страница данного сайта.<br>
		С помощью навигационного меню, вы можете пользоваться всеми ресурсами данного сайта.<br>
		Меню расположенно сверху.<br>
		Ниже вы можете добавить записи в базу данных.
	</div>
	<form action="includes/checkImportTable.php" method="POST" enctype="multipart/form-data" class="enter_system_form">
		<input type="file" name="file" class="upload_input_file form_xml">
		<button type="submit" name="uploadXML">Загрузить XML</button>
	</form>
	<?php
		if (isset($_SESSION['message'])) {
			echo '<p class="msg">'.$_SESSION['message'].'</p>';
		}
		unset($_SESSION['message']);
	?>
</div>

<?php
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php');
?>
