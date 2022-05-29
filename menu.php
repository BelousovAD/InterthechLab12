<?php include("includes/connection.php"); ?>
<?php session_start(); ?>

<?php include("includes/header.php"); ?>
<!doctype html>
<html>

<head>
  <title>Редактирование меню</title>
</head>

<body>
  <div id="welcome">

    <h1>Редактирование меню</h1>

    <table>

      <tr>
        <td>Название</td>
        <td>Позиция</td>
        <td>Ссылка</td>
        <td>Редактировать</td>
      </tr>

      <?php
      if (isset($_GET['ch_id'])) { //проверяем, есть ли переменная
        $id = $_GET['ch_id'];

        if (isset($_POST["brefr"])) {
          $pos = $_POST["pos"];
          $url = $_POST["url"];
          if (empty($url))
            echo '<p>Оба поля должны быть заполнены</p>';
          else
            if (!is_numeric($pos))
            echo '<p>Позиция должна быть числом</p>';
          else
            if ($pos < 0 || $pos > 4)
            echo '<p>Диапозон позиций: 0-4</p>';
          else {
            $result = mysql_query("UPDATE menus SET pos='$pos', url='$url' WHERE id = '$id' ");
            if ($result)
              echo '<p>Обновлено</p>';
            else
              echo '<p>Произошла ошибка</p>';
          }
        } else {

          $result = mysql_query("SELECT * FROM menus WHERE id = '$id' ");
          $row = mysql_fetch_array($result);

          echo '<form method="post">' .
            '<input type="text" name="pos" class="input" value="' . $row['pos'] . '">' .
            '<br><input type="text" name="url" class="input" value="' . $row['url'] . '">' .
            '<br><input type="submit" name="brefr" value="Обновить"></form>';
        }
      }
      ?>

      <?php
      $result = mysql_query("SELECT * FROM menus WHERE owner='" . $_SESSION["session_username"] . "' ");
      $num_result = mysql_num_rows($result);
      if ($num_result == 0)
        $mess = 'Ошибка';
      else
        for ($i = 0; $i < $num_result; $i++) {
          $row = mysql_fetch_array($result);
          echo '<tr>' .
            "<td>{$row['name']}</td>" .
            "<td>{$row['pos']}</td>" .
            "<td>{$row['url']}</td>" .
            "<td><a href='?ch_id={$row['id']}'>*</a></td>" .
            '</tr>';
        }
      ?>

      <?php
      if (isset($_POST['xmlb'])) {
        if ($_FILES['xml']['type'] == 'text/xml') {
          $data = implode("", file($_FILES['xml']['name']));
          $parser = xml_parser_create();
          xml_parse_into_struct($parser, $data, $values, $tags);
          xml_parser_free($parser);
          $size = count($values);
          // Находим имя таблицы и создание этой таблицы если её нет
          for ($i = 0; $i < $size; $i++) {
            if ($values[$i]['tag'] == 'TABLE')
              $table = $values[$i]['attributes']['NAME'];
            if (strpos($values[$i]['value'], 'CREATE TABLE'))
              $ct = $i;
            if (!empty($table))
              break;
          }
          // Ещё находим все записи
          $vals = array();
          for ($i = $ct + 1; $i < $size; $i++)
            if ($values[$i]['tag'] == 'COLUMN')
              array_push($vals, $i);

          // Еесли надо создаем таблицу
          mysql_query($values[$ct]['value']);

          // Получаем имена столбцов
          $result = mysql_query("SHOW COLUMNS FROM " . $table);
          if (!$result) {
            $mess = 'Ошибка при выполнении запроса: ' . mysql_error();
            exit;
          }
          if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
              $collumns = $collumns . $row['Field'] . ",";
              $c++;
            }
          }
          $collumns = substr($collumns, 0, -1);

          // Собираем все записи для запроса
          for ($i = 0; $i <= count($vals); $i++) {
            if ($i % $c == 0 && $i != 0) {
              $zap = substr($zap, 0, -1);
              $zapBody = $zapBody . "(" . $zap . ")" . ",";
              $zap = "";
            }
            $zap = $zap . "'" . $values[$vals[$i]]['value'] . "'" . ",";
          }
          $zapBody = substr($zapBody, 0, -1);

          // Формируем окончательный запрос
          $bzap = "INSERT INTO " . $table . " (" . $collumns . ") VALUES" . $zapBody;
          $fin = mysql_query($bzap);
          if (!$fin)
            $mess = 'Ошибка при выполнении запроса: ' . mysql_error();
          else
            $mess = 'Загрузка успешна';
        } else
          $mess = 'Только файлы xml';
      }
      ?>

    </table>

    <form method="post" enctype="multipart/form-data">
      <h1>Загрузка XML</h1>
      <input type="file" name="xml" class="input" value="">
      <input type="submit" name="xmlb" value="Загрузить">
    </form>
      
    <?php if (!empty($mess)) {
      echo "<p>" . "Сообщение: " . $mess . "</p>";
    }
    ?>

  </div>
  
</body>

</html>

<?php include("includes/footer.php"); ?>