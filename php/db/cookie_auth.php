<?php
    if (isset($_COOKIE["auth"]) && !isset($_SESSION["cuenta_id"])){
        $auth = $_COOKIE["auth"];
        try{
            $conn_auth = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
            $conn_auth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql_auth = $conn_auth->prepare("SELECT * FROM usuarios WHERE auth_cookie = ?");
            $sql_auth->execute([$auth]);
            $fetch_auth = $sql_auth->fetch(PDO::FETCH_ASSOC);
            if ($fetch_auth){
                $_SESSION["cuenta_id"] = $fetch_auth["id"];
                $_SESSION["cuenta_usuario"] = $fetch_auth["username"];
            }
            else{
                // simplemente eliminamos el cookie auth para prevenir más solicitudes
                unset($_COOKIE["auth"]);
                setcookie("auth", ""); 
            }
        }
        catch (PDOException $e){
            exit();
        }
    }
?>
