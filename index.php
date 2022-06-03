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

</div>

<?php
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php');
?>