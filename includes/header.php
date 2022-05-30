<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Лабораторная работа №12</title>
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <header class="header">
		<div>
			<div class="container-list">
				<h1 class="animation"> Лабораторная работа №1</h1>
        <div>
          Пользователь: <?php echo $_SESSION['name']; ?>
          <a href="logout.php">Выйти</a>
        </div>
			</div>
		</div>
	</header>
    <nav class = "navigation">
        <?php
        include("includes/connection.php");
    
        $sql = 'SELECT * FROM menu WHERE owner="'.$_SESSION['login'].'" ORDER BY pos ASC';
        $result = mysqli_fetch_all(mysqli_query($link, $query));
        if (!$result)
          echo 'Ошибка';
        else
          while ($row = mysqli_fetch_array($result)) {
            echo "<a href=\"".$row['url']."\">".$row['name'] . "</a>";
          }
        ?>
        <a href='menu.php'>Настройка меню</a>   
    </nav>
