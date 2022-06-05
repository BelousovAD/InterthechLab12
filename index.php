<?php
	session_start();

	if (!$_SESSION['user']) {
		header("location: includes/checkCookie.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<div id="welcome">

	<h1>Главная страница</h1>
	<form action="includes/checkImportTable.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
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