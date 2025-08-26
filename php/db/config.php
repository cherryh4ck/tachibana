<?php
    $configuracion_ini = parse_ini_file(__DIR__ . "\config.ini", true);

    // posts
    $chequeo_estricto_imagen = $configuracion_ini["posts"]["chequeo_estricto_imagen"];

    // bd
    $host = $configuracion_ini["network"]["host"];
    $puerto = $configuracion_ini["network"]["puerto"];
    $user = $configuracion_ini["network"]["username"];
    $pass = $configuracion_ini["network"]["password"];
    $db = $configuracion_ini["network"]["database"];

    require "cookie_auth.php";
?>
