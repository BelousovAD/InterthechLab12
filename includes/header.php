<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Лабораторная работа №12</title>
  <link href="css/main.css" rel="stylesheet">
</head>
<body>
  <header class="header">
		<div>
			<div class="container-list">
				<h1 class="animation"> Лабораторная работа №12</h1>
        <div>
          Пользователь: <?php echo $_SESSION['user']['name']; ?>
          <a href="includes/logout.php">Выйти</a>
        </div>
			</div>
		</div>
	</header>
