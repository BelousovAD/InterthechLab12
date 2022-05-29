<?php session_start();
if (!isset($_COOKIE['session']))
	header("location:login.php"); ?>

<?php include("includes/connection.php"); ?>

<?php include("includes/header.php"); ?>

<div id="welcome">

	<h1>Главная страница</h1>

	<form action="" method="POST">

		<!-- Поправить кнопку -->

		<h2>Сортировка</h2>
		
		Название (<input type="radio" name="name" value="up" />возрастание
		<input type="radio" name="name" value="down" />убывание)<br>
		Описание (<input type="radio" name="description" value="up" />возрастание
		<input type="radio" name="description" value="down" />убывание)<br>
		<input type="submit" name="sort" value="Сортировать" /><br>
	</form>

</div>

	<?php
	if (isset($_GET['id']))
		$page = $_GET['id'];
	else
		$page = 1;
	$quantity = 3;
	$limit = 2; // количество цифр страниц с обоих сторон
	if ($page < 1) $page = 1;

	$result2 = mysql_query("SELECT * FROM pics");
	$num = mysql_num_rows($result2);
	$pages = $num / $quantity;
	$pages = ceil($pages);

	if (!isset($list)) $list = 0;
	$list = --$page * $quantity;

	$zap = "SELECT * FROM pics ";
	if ($_POST['name'] == "up")
		$ssort1 = "name ASC";
	if ($_POST['name'] == "down")
		$ssort1 = "name DESC";
	if ($_POST['description'] == "up")
		$ssort2 = "description ASC";
	if ($_POST['description'] == "down")
		$ssort2 = "description DESC";
	if (!empty($ssort1) && empty($ssort2))
		$zap = $zap . "ORDER BY " . $ssort1 . " ";
	if (empty($ssort1) && !empty($ssort2))
		$zap = $zap . "ORDER BY " . $ssort2 . " ";
	if (!empty($ssort1) && !empty($ssort2))
		$zap = $zap . "ORDER BY " . $ssort1 . "," . $ssort2 . " ";
	$zap = $zap . "LIMIT $quantity OFFSET $list";

	$result = mysql_query($zap);
	$num_result = mysql_num_rows($result);
	for ($i = 0; $i < $num_result; $i++) {
		$row = mysql_fetch_array($result);
		echo '<div id =  "welcome"> <strong><h1><a href="page.php?id=' . $row["id"] . '">' . $row["name"] . '</a></h1></strong>
		<img src="i/' . $row["img_s"] . '" /><br>'
			. $row["description"] . '</div>';
	}
	//echo '<div id = "welcome" > Страниц: ' . $pages;
	if ($page >= 0)
		echo '<div id = "welcome"<a href="main.php?id=' . $page . '">< </a> &nbsp; ';

	$start = ($page + 1) - $limit;
	$end = ($page + 1) + $limit;
	for ($j = 1; $j <= $pages; $j++) {
		if ($j >= $start && $j <= $end) {
			if ($j == ($page + 1)) echo '<a href="main.php?id=' . $j .
				'"><strong style="color: #df0000">' . $j .
				'</strong></a> &nbsp; ';

			// Ссылки на остальные страницы
			else echo '<a href="main.php?id=' . $j . '">' . $j . '</a> &nbsp; ';
		}
	}
	if ($j > $page && ($page + 2) < $j)
		echo '<a href="main.php?id=' . ($page + 2) . '"> ></a> &nbsp; </div> ';
		
	?>

<?php include("includes/footer.php"); ?>