<?php session_start();
if (!isset($_SESSION["session_username"]))
    header("location:login.php"); ?>

<?php include("includes/connection.php"); ?>

<?php include("includes/header.php"); ?>

<!doctype html>
<html>

<head>
    <title>Поиск</title>
</head>

<body>
    <div id="welcome">

        <h1>Поиск позиций</h1>

        <form class="searchBox" name="search" method="POST" action="">
            <input type="text" name="query" placeholder="Поиск">
            <button type="submit" name="find">Найти</button>
        </form>

        <?php
        if (isset($_POST["find"])) {
            if (!empty($_POST["query"])) {
                $txt = $_POST["query"];
                $result = mysql_query("SELECT * FROM pics WHERE name LIKE '" . $txt . "' 
                OR description LIKE '" . $txt . "' ");
                $num_result = mysql_num_rows($result);
                if ($num_result == 0)
                    echo 'Ничего не найдено';
                else
                    for ($i = 0; $i < $num_result; $i++) {
                        $row = mysql_fetch_array($result);
                        echo '<div><strong><h3><a href="page.php?id=' . $row["id"] . '">'
                            . $row["name"] . '</a></h3></strong>
                        <img src="i/' . $row["img_s"] . '" /><br>'
                            . $row["description"] . '</div>';
                    }
            } else
                echo 'Заполните поле';
        }
        ?>

    </div>
</body>

 <?php include("includes/footer.php"); ?>