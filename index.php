<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: includes/checkCookie.php");
	}

	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<div id="welcome">

	<h1>Главная страница</h1>

	<?php
	$sort_list = array(
		'login_asc'   => '`login`',
		'login_desc'  => '`login` DESC',
		'password_asc'  => '`password`',
		'password_desc' => '`password` DESC',
		'name_asc'   => '`name`',
		'name_desc'  => '`name` DESC',
		'email_asc'   => '`email`',
		'email_desc'  => '`email` DESC'
	);

	$order = "";

	if(isset($_GET['sort'])) {
		$sort = $_GET['sort'];
		if (array_key_exists($sort, $sort_list)) {
			$sort_sql = $sort_list[$sort];
		} else {
			$sort_sql = $sort_list['login_asc'];
		}
		$order = " ORDER BY '$sort_sql'";
	}
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

	$result= mysqli_query($connect,
		"SELECT * FROM `users`".$order);
	mysqli_close($connect);
	if (mysqli_num_rows($result) > 0) {
		$result = mysqli_fetch_assoc($result);
	}

	function sort_link($title, $asc, $desc) {
		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		
			if ($sort == $asc) {
				return '<a class="active" href="?sort='.$desc.'">'.$title.' <i>▲</i></a>';
			} elseif ($sort == $desc) {
				return '<a class="active" href="?sort='.$asc.'">'.$title.' <i>▼</i></a>';  
			} else {
				return '<a href="?sort='.$asc.'">'.$title.'</a>';  
			}
		}
		return '<a href="?sort='.$asc.'">'.$title.'</a>';  
	}
	?>

	<table>
		<thead>
			<tr>
				<th><?php echo sort_link('Логин', 'login_asc', 'login_desc'); ?></th>
				<th><?php echo sort_link('Пароль', 'password_asc', 'password_desc'); ?></th>
				<th><?php echo sort_link('Имя', 'name_asc', 'name_desc'); ?></th>
				<th><?php echo sort_link('E-mail', 'email_asc', 'email_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($result as $row): ?>
			<tr>
				<td><?php echo $row['login']; ?></td>
				<td><?php echo $row['password']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>
			</tr>
			<?php endforeach; ?>    
		</tbody>
	</table>

	<?php
	/*if (isset($_GET['id']))
		$page = $_GET['id'];
	else
		$page = 1;
	$quantity = 3;
	$limit = 2; // Количество цифр страниц с обоих сторон
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
		echo '<div><strong><h3><a href="page.php?id=' . $row["id"] . '">' . $row["name"] . '</a></h3></strong>
		<img src="i/' . $row["img_s"] . '" /><br>'
			. $row["description"] . '</div><hr>';
	}
	echo '<div>Страниц: ' . $pages . '</div>';
	if ($page >= 1)
		echo '<a href="main.php?id=' . $page . '">< </a> &nbsp; ';

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
		echo '<a href="main.php?id=' . ($page + 2) . '"> ></a> &nbsp; ';*/
	?>

</div>

<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php');
?>