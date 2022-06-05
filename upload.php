<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<form method="post" enctype="multipart/form-data" action="includes/checkUpload.php" class="enter_system_form">
	<input type="text" name="name" placeholder="Наименование" class="upload_input">
	<input type="text" name="description" placeholder="Описание" class="upload_input">
	<input type="file" name="file" class="upload_input_file">
	<button type="submit" name="upload">Загрузить</button>
	<?php
		if (isset($_SESSION['message'])) {
			echo '<p class="msg">'.$_SESSION['message'].'</p>';
		}
		unset($_SESSION['message']);
	?>
</form>

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
