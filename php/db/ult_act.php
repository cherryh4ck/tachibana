<?php
    if (isset($_SESSION["cuenta_id"]) && isset($_COOKIE["ult_act"]) && !isset($_COOKIE["ult_act_timer"])){
        if ($_COOKIE["ult_act"] == "1"){
            $sql = $conn->prepare("UPDATE usuarios SET ult_act = CURRENT_TIMESTAMP WHERE id = ?;");
            $sql->execute([$_SESSION["cuenta_id"]]);
            setcookie("ult_act_timer", "1", time() + 60, "/"); 
        }
    }
?>