<?php
    // TODO TOTAL:
    // - más chequeos de sanidad (tamaño mínimo)
    // - soporte para gifs

    $maxSize = 6228792;

    error_reporting(E_ERROR | E_PARSE);

    $renombrado = "";
    $archivos = scandir("../galeria/");
    
    // Por si existe el test.txt o no
    if (file_exists("../galeria/Test.txt")){
        $total_archivos = count($archivos) - 3;
    }
    else{
        $total_archivos = count($archivos) - 2;
    }

    $archivo = $_FILES["archivo"];
    $info = pathinfo($archivo["name"]);

    $renombrado = strval($total_archivos) . ".jpg";
    if ($info["extension"] == "gif"){
        $fullRenombrado = strval($total_archivos) . ".gif";
    }
    else{
        $fullRenombrado = $renombrado;
    }
    $dir = "../galeria/";
    $fullsize = "../galeria/fullsize/";


    $nombregenerado = strval(rand(0, 100000000000)) . ".jpg";
    if (!isset($archivo)){
        header("Location: ../error.php?id=3");
        exit();
    }
    // chequeos de sanidad
    list($x, $y) = getimagesize($archivo["tmp_name"]);
    $tamaño = filesize($archivo["tmp_name"]);

    if ($x >= 400 and $y >= 300){
        if ($info["extension"] == "png"){
            $imagen = imagecreatefrompng($archivo["tmp_name"]);
        }
        else if ($info["extension"] == "jpg" or $info["extension"] == "jpeg"){
            $imagen = imagecreatefromjpeg($archivo["tmp_name"]);
        }
        else if ($info["extension"] == "gif"){
            $imagen = imagecreatefromgif($archivo["tmp_name"]);
            $maxSize = 26228792;
        }

        if (!$imagen){
            header("Location: ../error.php?id=3");
            exit();
        }
        else{
            if (!($tamaño < $maxSize)){
                header("Location: ../error.php?id=8");
                exit();
            }
            $miniatura_w = 400;
            $miniatura_h = 300;

            $width = imagesx($imagen);
            $height = imagesy($imagen);

            $aspecto_original = $width / $height;
            $aspecto_miniatura = $miniatura_w / $miniatura_h;

            if ( $aspecto_original >= $aspecto_miniatura )
            {
                $nueva_height = $miniatura_h;
                $nueva_width = $width / ($height / $miniatura_h);
            }
            else
            {
                $nueva_width = $miniatura_w;
                $nueva_height = $height / ($width / $miniatura_w);
            }

            $miniatura = imagecreatetruecolor( $miniatura_w, $miniatura_h );

            imagecopyresampled($miniatura,
                            $imagen,
                            0 - ($nueva_width - $miniatura_w) / 2, 
                            0 - ($nueva_height - $miniatura_h) / 2, 
                            0, 0,
                            $nueva_width, $nueva_height,
                            $width, $height);
            imagejpeg($miniatura, $dir . $renombrado , 80);
            if ($info["extension"] == "gif"){
                rename($archivo["tmp_name"], $fullsize . $fullRenombrado);
            }
            else{
                $fullsizeimg = imagejpeg($imagen, $fullsize . $fullRenombrado);
            }
            header("Location: ../post.php?id=" . strval($total_archivos));
            exit();
        }
    }
    else{
        header("Location: ../error.php?id=7");
        exit();
    }
    // chdir("../galeria/");
?>
