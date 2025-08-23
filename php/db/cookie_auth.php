<?php
    if (isset($_COOKIE["auth"]) && !isset($_SESSION["cuenta_id"])){
        $auth = $_COOKIE["auth"];
        try{
            $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("SELECT * FROM usuarios WHERE auth_cookie = ?");
            $sql->execute([$auth]);
            $fetch = $sql->fetch(PDO::FETCH_ASSOC);
            if ($fetch){
                $_SESSION["cuenta_id"] = $fetch["id"];
                $_SESSION["cuenta_usuario"] = $fetch["username"];
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
