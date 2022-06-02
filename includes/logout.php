<?php
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['query']);
    session_destroy();
    setcookie('login', '', time());
    setcookie('pass', '', time());
    header("location: ../login.php");
?>
