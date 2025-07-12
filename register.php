<?php
    // Por hacer!!
    session_start();
    if (isset($_SESSION["logueado"])){
        header("Location: galeria.php");
    }
?>
