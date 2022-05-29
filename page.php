<?php session_start();
if (!isset($_COOKIE['session']))
    header("location:login.php"); ?>

<?php include("includes/connection.php"); ?>

<?php include("includes/header.php"); ?>

<!doctype html>
<html>

<head>
    <title>Редактирование</title>
</head>

<body>
    <div id="page">
        <?php
        $id = $_GET['id'];
        $result = mysql_query("SELECT * FROM pics WHERE id = '" . $id . "' ");
        $row = mysql_fetch_array($result);
        echo '<h2>Owner:' . $row["owner"] . '</h2>
    <strong><h1>' . $row["name"] . '</h1></strong>
        <center><img src="i/' . $row["img"] . '" /></center><br>
        <h3>' . $row["description"] . '</h3>';
        ?>
    </div>
</body>

<?php include("includes/footer.php"); ?>