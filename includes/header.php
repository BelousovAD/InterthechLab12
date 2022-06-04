<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Лабораторная работа №12</title>
  <link href="css/main.css" rel="stylesheet">
  <link href="css/main_dop.css" rel="stylesheet">
</head>
<body>
  <header class="header">
    <div class="lab_name">
      <h1>Лабораторная работа №12</h1>
    </div>
    <div class="user_active">
      Пользователь: <?php echo $_SESSION['user']['name']; ?><br>
      <a href="includes/logout.php" class="enter_a">Выйти</a>
    </div>
	</header>
