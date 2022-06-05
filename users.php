<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: includes/checkCookie.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<div id="welcome">

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

		if (isset($_POST['find'])) {
			$_SESSION['query'] = $_POST['query'];
			$txt = $_POST['query'];

			$find = " WHERE `login` LIKE '%".$txt.
				"%' OR `password` LIKE '%".$txt.
				"%' OR `name` LIKE '%".$txt.
				"%' OR `email` LIKE '%".$txt."%' ";
		}
		else {
			if (isset($_SESSION['query'])) {
				$txt = $_SESSION['query'];

				$find = " WHERE `login` LIKE '%".$txt.
				"%' OR `password` LIKE '%".$txt.
				"%' OR `name` LIKE '%".$txt.
				"%' OR `email` LIKE '%".$txt."%' ";
			}
			else {
				$txt = "";
				$find = "";
			}
		}

		if (!empty($_GET['page'])) {
			$page = $_GET['page'];
		}
		else {
			$page = 1;
		}

		$num_rows_per_page = 3;

		$last_row_from_prev_page = ($page - 1) * $num_rows_per_page;

		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		}
		else {
			$sort = 'login_asc';
		}

		if (array_key_exists($sort, $sort_list)) {
			$sort_sql = $sort_list[$sort];
		}

		require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

		$result = mysqli_query($connect,
			"SELECT `login` FROM `users`".$find);

		$num_rows = mysqli_num_rows($result);

		if ($num_rows == 0) {
			mysqli_close($connect);
			$_SESSION['message'] = 'Записи в БД отсутствуют';
			unset($_SESSION['query']);
			header('location: users.php');
			die;
		}

		$num_pages = intdiv($num_rows, $num_rows_per_page) + boolval($num_rows % $num_rows_per_page);

		$result = mysqli_query($connect,
			"SELECT * FROM `users`".$find.
			"ORDER BY ".$sort_sql.
			" LIMIT ".$num_rows_per_page." OFFSET ".$last_row_from_prev_page);

		$num_rows = mysqli_num_rows($result);

		if ($num_rows == 0) {
			mysqli_close($connect);
			$_SESSION['message'] = 'Записи в БД отсутствуют';
			unset($_SESSION['query']);
			header('location: users.php');
			die;
		}
		mysqli_close($connect);

		function sort_link($title, $asc, $desc) {
			if(!empty($_GET['sort']) and !empty($_GET['page'])) {
				$sort = $_GET['sort'];
				$page = $_GET['page'];

				if ($sort == $asc) {
					return '<a class="active" href="?sort='.$desc.'&page='.$page.'">'.$title.' <i>▲</i></a>';
				} elseif ($sort == $desc) {
					return '<a class="active" href="?sort='.$asc.'&page='.$page.'">'.$title.' <i>▼</i></a>';
				} else {
					return '<a href="?sort='.$asc.'&page='.$page.'">'.$title.'</a>';
				}
			}
			return '<a href="?sort='.$asc.'&page=1">'.$title.'</a>';
		}
	?>

	<form method="POST" action="users.php" class="search">
		<input type="text" name="query" placeholder="Поиск" class="search_input">
		<button type="submit" name="find" class="page_button">Найти</button>
	</form>

	<table class="table_style_default">
		<thead>
			<tr>
				<th><?php echo sort_link('Логин', 'login_asc', 'login_desc'); ?></th>
				<th><?php echo sort_link('Пароль', 'password_asc', 'password_desc'); ?></th>
				<th><?php echo sort_link('Имя', 'name_asc', 'name_desc'); ?></th>
				<th><?php echo sort_link('E-mail', 'email_asc', 'email_desc'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo $row['login']; ?></td>
				<td><?php echo $row['password']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<div class="page_stat-button">
		<span class="page_name">Страница:</span>
		<br>
		<?php
			if ($page != 1) {
				echo '<a href="users.php?sort='.$sort.'&page='.($page - 1).'" class="page_button">Предыдущая</a>';
			}
			echo ' '.$page.'/'.$num_pages.' ';
			if ($page != $num_pages) {
				echo '<a href="users.php?sort='.$sort.'&page='.($page + 1).'" class="page_button">Следующая</a>';
			}
		?>
	</div>
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
