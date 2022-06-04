<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<img src="<?php echo $_GET['source']; ?>">

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>