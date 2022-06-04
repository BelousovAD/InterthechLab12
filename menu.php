<?php
	session_start();
	if (!$_SESSION['user']) {
		header("location: index.php");
	}

	require ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php');

  $login = $_SESSION['user']['login'];

  require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

  $result = mysqli_query($connect,
			"SELECT * FROM `menu`
      WHERE `owner`='$login'
      ORDER BY `pos`");
		
	$num_rows = mysqli_num_rows($result);

  if ($num_rows == 0) {
    mysqli_close($connect);
    die('<p>Записи в БД отсутствуют</p>');
  }
?>

  <div id="welcome">
    <table>
      <thead>
        <tr>
          <td>Позиция</td>
          <td>Название</td>
          <td>Ссылка</td>
          <td>Действия</td>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_array($result)): ?>
          <tr>
            <form method="POST">
              <td><?php echo '<input type="text" name="pos" value="'.$row['pos'].'">'; ?></td>
              <td><?php echo '<input type="text" name="name" value="'.$row['name'].'">'; ?></td>
              <td><?php echo '<input type="text" name="url" value="'.$row['url'].'">'; ?></td>
              <td>
                <?php
                  echo '<input type="hidden" name="num_rows" value="'.$num_rows.'">
                    <input type="hidden" name="row_pos" value="'.$row['pos'].'">
                    <button type="submit" formaction="includes/checkUpdate.php" name="update" value="'.$row['id'].'">Обновить</button>
                    <button type="submit" formaction="includes/checkDrop.php" name="delete" value="'.$row['id'].'">Удалить</button>';
                ?>
              </td>
            </form>
          </tr>
        <?php endwhile; ?>
        <tr>
          <form action="includes/checkUpdate.php" method="POST">
            <td></td>
            <td><input type="text" name="name"></td>
            <td><input type="text" name="url"></td>
            <td><button type="submit" name="add" value="<?php echo $num_rows; ?>">Добавить</button></td>
          </form>
        </tr>
      </tbody>
    </table>
    <?php
      if (isset($_SESSION['message'])) {
        echo '<p class="msg">'.$_SESSION['message'].'</p>';
      }
      unset($_SESSION['message']);
    ?>
  </div>

<?php require ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>