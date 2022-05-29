<?php include("includes/connection.php"); ?>
<?php session_start(); ?>

<?php include("includes/header.php"); ?>
<!doctype html>
<html>

<head>
  <title>Удаление</title>
</head>

<body>
  <div id="welcome">

    <h1>Удаление постов</h1>

    <?php
    if (isset($_GET['del_id'])) { //Проверяем, есть ли переменная
      //Удаляем строку из таблицы
      $id = $_GET['del_id'];

      $result = mysql_query("SELECT * FROM pics WHERE id = '$id' ");
      $row = mysql_fetch_array($result);
      $files = realpath('i/');
      unlink($files . '/' . $row["img"]);
      unlink($files . '/' . $row["img_s"]);

      $result = mysql_query("DELETE FROM pics WHERE id = '$id' ");
      if ($result) {
        echo '<p>Удалено</p>';
      } else {
        echo '<p>Произошла ошибка</p>';
      }
    }
    ?>

    <table>
      <tr>
        <td>Наименование</td>
        <td>Описание</td>
        <td>Удаление</td>
      </tr>

      <?php
      $result = mysql_query("SELECT * FROM pics WHERE owner='" . $_SESSION["session_username"] . "' ");
      $num_result = mysql_num_rows($result);
      if ($num_result == 0)
        echo 'Ничего не найдено';
      else
        for ($i = 0; $i < $num_result; $i++) {
          $row = mysql_fetch_array($result);
          echo '<tr>' .
            "<td>{$row['name']}</td>" .
            "<td>{$row['description']}</td>" .
            "<td><a href='?del_id={$row['id']}'>Удалить</a></td>" .
            '</tr>';
        }
      ?>

    </table>
  </div>
</body>

</html>

<?php include("includes/footer.php"); ?>