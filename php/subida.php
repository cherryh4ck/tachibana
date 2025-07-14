<?php
    // TODO TOTAL:
    // - más chequeos de sanidad (tamaño mínimo)
    // - mostrar mensajes de error más claros
    // - soporte para gifs

    error_reporting(E_ERROR | E_PARSE);

    $renombrado = "";
    $archivos = scandir("../galeria/");

    $mensaje = ""; // mensaje para el final
    
    // Por si existe el test.txt o no
    if (file_exists("../galeria/Test.txt")){
        $total_archivos = count($archivos) - 3;
    }
    else{
        $total_archivos = count($archivos) - 2;
    }

    $renombrado = strval($total_archivos) . ".jpg";
    $dir = "../galeria/";
    $fullsize = "../galeria/fullsize/";

    $archivo = $_FILES["archivo"];
    $info = pathinfo($archivo["name"]);

    $nombregenerado = strval(rand(0, 100000000000)) . ".jpg";
    if (!isset($archivo)){
        header("Location: ../error.php?id=3");
    }
    // chequeos de sanidad
    list($x, $y) = getimagesize($archivo["tmp_name"]);
    $tamaño = filesize($archivo["tmp_name"]);

    if ($x >= 400 and $y >= 300 and $tamaño < 5228792){
        if ($info["extension"] == "png"){
            $imagen = imagecreatefrompng($archivo["tmp_name"]);
        }
        else{
            $imagen = imagecreatefromjpeg($archivo["tmp_name"]);
        }
        if (!$imagen){
            header("Location: ../error.php?id=3");
        }
        else{
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
            $mensaje = "Imagen subida con éxito";
            $fullsizeimg = imagejpeg($imagen, $fullsize . $renombrado);
        }
    }
    else{
        if ($x < 400 or $y < 300){
            $mensaje = "La imagen debe tener una resolución mínima de 300x300 píxeles";
        }
        else if ($tamaño > 5228792){
            $mensaje = "El tamaño de la imagen debe ser menor a 5.2 MBs";
        }
    }
    // chdir("../galeria/");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <nav>
        <h1>test</h1>
        <ul>
            <li><a href="../galeria.php?pag=1">Galería</a></li>
            <li><a href="../subir.html">Subir</a></li>
            <li><a href="perfiles.php">Usuarios</a></li>
        </ul>
        <div class="nav-cuenta">
            <a href="php/cuenta.php" id="cuenta">Invitado</a>
        </div>
    </nav>
    <header>
        <?php
            echo "<h1>" . $mensaje . "</h1>";
        ?>
    </header>
</body>
</html>
