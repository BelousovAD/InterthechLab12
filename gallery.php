<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: includes/checkCookie.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');
?>

<div class="gallery">

	<?php
		$sort_list = array(
            'id_asc'   => '`id`',
			'id_desc'  => '`id` DESC',
			'owner_asc'   => '`owner`',
			'owner_desc'  => '`owner` DESC',
			'name_asc'  => '`name`',
			'name_desc' => '`name` DESC',
			'description_asc'   => '`description`',
			'description_desc'  => '`description` DESC',
		);

		if (isset($_POST['find'])) {
			$_SESSION['query'] = $_POST['query'];
			$txt = $_POST['query'];

			$find = " WHERE `id` LIKE '%".$txt.
                "%' OR `owner` LIKE '%".$txt.
				"%' OR `name` LIKE '%".$txt.
				"%' OR `description` LIKE '%".$txt."%' ";
		}
		else {
			if (isset($_SESSION['query'])) {
				$txt = $_SESSION['query'];

				$find = " WHERE `id` LIKE '%".$txt.
                "%' OR `owner` LIKE '%".$txt.
				"%' OR `name` LIKE '%".$txt.
				"%' OR `description` LIKE '%".$txt."%' ";
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
			$sort = 'id_asc';
		}

		if (array_key_exists($sort, $sort_list)) {
			$sort_sql = $sort_list[$sort];
		}

		require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

		$result = mysqli_query($connect,
			"SELECT `id` FROM `images`".$find);

		$num_rows = mysqli_num_rows($result);

		if ($num_rows == 0) {
			mysqli_close($connect);
			$_SESSION['message'] = 'Записи в БД отсутствуют';
			unset($_SESSION['query']);
			header('location: gallery.php');
			die;
		}

		$num_pages = intdiv($num_rows, $num_rows_per_page) + boolval($num_rows % $num_rows_per_page);

		$result = mysqli_query($connect,
			"SELECT * FROM `images`".$find.
			"ORDER BY ".$sort_sql.
			" LIMIT ".$num_rows_per_page." OFFSET ".$last_row_from_prev_page);

		$num_rows = mysqli_num_rows($result);

		if ($num_rows == 0) {
			mysqli_close($connect);
			$_SESSION['message'] = 'Записи в БД отсутствуют';
			unset($_SESSION['query']);
			header('location: gallery.php');
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

	<form method="POST" action="gallery.php" class="search">
		<div class="search_div">
			<input type="text" name="query" placeholder="Поиск" class="search_input">
			<button type="submit" name="find" class="page_button">Найти</button>
		</div>
	</form>

	<table class="table_style_default">
		<thead>
			<tr>
                <th><?php echo sort_link('№', 'id_asc', 'id_desc'); ?></th>
                <th>Фото</th>
				<th><?php echo sort_link('Наименование', 'name_asc', 'name_desc'); ?></th>
				<th><?php echo sort_link('Описание', 'description_asc', 'description_desc'); ?></th>
                <th><?php echo sort_link('Владелец', 'owner_asc', 'owner_desc'); ?></th>
				<th>Действия</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
                <td><?php echo '<img src="'.$row['marked_little'].'" class="gallery_img">'; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['description']; ?></td>
                <td><?php echo $_SESSION['user']['login'] == $row['owner'] ? 'Вы' : $row['owner']; ?></td>
				<td><form action="page.php" method="GET">
                        <button type="submit" name="source" value="<?php echo $row['original']; ?>" class="page_button">Оригинал</button>
                        <button type="submit" name="source" value="<?php echo $row['marked']; ?>" class="page_button">WaterMark</button>
                    </form>
                    <?php echo $_SESSION['user']['login'] == $row['owner'] ?
                        '<form action="includes/checkDelete.php" method="POST">
                            <button type="submit" name="delete" value="'.$row['id'].'" class="page_button">Удалить</button>
                        </form>' : '';
                    ?>
                </td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<div class="page_stat-button">
		<span class="page_name">Страница:</span>
		<br>
		<?php
			if ($page != 1) {
				echo '<a href="gallery.php?sort='.$sort.'&page='.($page - 1).'" class="page_button">Предыдущая</a>';
			}
			echo ' '.$page.'/'.$num_pages.' ';
			if ($page != $num_pages) {
				echo '<a href="gallery.php?sort='.$sort.'&page='.($page + 1).'" class="page_button">Следующая</a>';
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
