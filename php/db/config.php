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

    // seguridad
    $mantenimiento = $configuracion_ini["seguridad"]["mantenimiento"];
    $debug = $configuracion_ini["seguridad"]["debug"];

    if ($debug == 0){
        error_reporting(E_ERROR | E_PARSE);
    }

    $conn_test = 0;
    try{
        $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn_test = 1;
    }
    catch (PDOException $e){
        $conn_test = 0;
    }

    if ($conn_test == 1){
        require "cookie_auth.php";
        require "ult_act.php";
    }
?>
