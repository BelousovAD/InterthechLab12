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
		Меню расположенно сверху.
	</div>
</div>

<?php
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php');
?>
