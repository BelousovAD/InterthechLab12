<?php
    $link = new mysqli('localhost', 'root', 'root', 'lab12', 3306);
    if (!$link){
        die("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
?>