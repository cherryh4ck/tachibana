<?php
    if (isset($_COOKIE["auth"]) && !isset($_SESSION["cuenta_id"])){
        $auth = $_COOKIE["auth"];
        try{
            $sql_auth = $conn->prepare("SELECT * FROM usuarios WHERE auth_cookie = ?");
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
