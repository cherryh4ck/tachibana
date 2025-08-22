<?php
    session_start();
    session_unset();
    session_destroy();
    unset($_COOKIE["auth"]);
    setcookie("auth", ""); 
    
    header("Location: ../../index.php");
?>
