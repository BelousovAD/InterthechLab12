<?php
    session_start();
    unset($_SESSION['user']);
    session_destroy();
    setcookie('login', '', time());
    setcookie('pass', '', time());
    header("location: ../login.php");
?>
