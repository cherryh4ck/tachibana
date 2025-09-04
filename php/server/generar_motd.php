<?php
    if (isset($_SESSION["cuenta_usuario"])){
        if ($_SESSION["cuenta_rol"] == 'admin'){
            // como va a ser esto??
        }
    }
    else{
        header("Location: ../../index.php");
    }
?>