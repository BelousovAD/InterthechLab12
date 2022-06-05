<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>
<div class="page_div">
	<img src="<?php echo $_GET['source']; ?>" class="page_img">
</div>

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
