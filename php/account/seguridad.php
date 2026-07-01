<?php
    require "../db/config.php";
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    if (isset($_SESSION["cuenta_id"]) && isset($_SESSION["cuenta_usuario"])){
        try{
            $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_POST["actual"]) && isset($_POST["nueva"]) && isset($_POST["repetir"])){
                $actual = $_POST["actual"];
                $nueva = $_POST["nueva"];
                $repetir = $_POST["repetir"];

                if (empty($actual) || empty($nueva) || empty($repetir)){
                    header("Location: ../../perfil.php?seguridad=1&error=1");
                    exit();
                }

                if ($nueva !== $repetir){
                    header("Location: ../../perfil.php?seguridad=1&error=2");
                    exit();
                }

                if ((strlen($nueva) < 6) || (strlen($nueva) > 72)){
                    header("Location: ../../perfil.php?seguridad=1&error=3");
                    exit();
                }

                $sql = $conn->prepare("SELECT password FROM usuarios WHERE id = ?");
                $sql->execute([$_SESSION["cuenta_id"]]);
                $fetch = $sql->fetch(PDO::FETCH_ASSOC);

                if (!$fetch || !password_verify($actual, $fetch["password"])){
                    header("Location: ../../perfil.php?seguridad=1&error=4");
                    exit();
                }

                $nueva_hasheada = password_hash($nueva, PASSWORD_BCRYPT);
                $sql = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?;");
                $sql->execute([$nueva_hasheada, $_SESSION["cuenta_id"]]);

                header("Location: ../../perfil.php?seguridad=1&ok=1");
                exit();
            }

            header("Location: ../../perfil.php?seguridad=1");
            exit();
        }
        catch (PDOException $e){
            header("Location: ../../error.php?id=9");
            exit();
        }
    }
    else{
        header("Location: ../../index.php");
        exit();
    }
?>
