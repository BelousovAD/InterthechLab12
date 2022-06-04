<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<form method="post" enctype="multipart/form-data" action="includes/checkUpload.php">
	<input type="text" name="name" placeholder="Наименование">
	<input type="text" name="description" placeholder="Описание">
	<input type="file" name="file">
	<button type="submit" name="upload">Загрузить</button>
	<?php
		if (isset($_SESSION['message'])) {
			echo '<p class="msg">'.$_SESSION['message'].'</p>';
		}
		unset($_SESSION['message']);
	?>
</form>

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>