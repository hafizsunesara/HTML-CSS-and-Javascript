<?php
    session_start();
    session_destroy();
    $username = $_SESSION['username'];
    header("Location:signin.php");
    die;
?>