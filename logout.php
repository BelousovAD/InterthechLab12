<?php
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['name']);
    unset($_SESSION['auth']);
    session_destroy();
    setcookie('login', '', time());
    setcookie('pass', '', time());
    header("location:login.php");
?>
