<?php
    $connect = mysqli_connect('localhost', 'root', 'root', 'lab12');
    if (!$connect) {
        die('Error connect to DataBase'.mysqli_connect_error());
    }
?>