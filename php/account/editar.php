<?php
    require "../db/config.php";
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    // pequeño algoritmo sacado de https://stackoverflow.com/questions/14649645/resize-image-in-php :3
    function resize_image($file, $w, $h) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
         } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

    if (isset($_SESSION["cuenta_id"]) && isset($_SESSION["cuenta_usuario"])){
        try{
            $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (isset($_POST["nickname"])){
                $sql = $conn->prepare("UPDATE usuarios SET nickname = ? WHERE id = ?;");
                $sql->execute([htmlspecialchars($_POST["nickname"]), $_SESSION["cuenta_id"]]);
            }
            if (isset($_POST["descripcion"])){
                $sql = $conn->prepare("UPDATE usuarios SET descripcion = ? WHERE id = ?;");
                $sql->execute([nl2br(htmlspecialchars($_POST["descripcion"])), $_SESSION["cuenta_id"]]);
            }
            if (isset($_FILES["avatar"])){
                $avatar = $_FILES["avatar"];
                $info = pathinfo($avatar["name"]);
                if (!empty($info["extension"])){
                    if (!($info["extension"] == "png")){
                        $imagen = imagecreatefromjpeg($avatar["tmp_name"]);
                    }

                    if ($imagen){
                        imagepng($imagen, "../../resources/avatars/" . $_SESSION["cuenta_id"] . ".png");
                        resize_image("../../resources/avatars/" . $_SESSION["cuenta_id"] . ".png", 498, 498);
                    }
                    else{
                        header("Location: ../../error.php?id=3");
                        exit();
                    }
                }
            }

            header("Location: ../../perfil.php");
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
