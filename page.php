<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
    echo $_POST['source'];
?>

<img src="<?php echo $_POST['source']; ?>">

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>