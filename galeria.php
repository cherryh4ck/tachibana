<?php
    // TODO: Sistema de busqueda ?
    // Sistema de indexado (Yo creo que estaría feo mostrar las imágenes borradas como inaccesibles)
    // Arreglar lo de que si el ID 1 no existe, colapsa todo el sistema xd
    if (!isset($_GET["pag"])){
        $pagina = 1;
    }
    else{
        $pagina = $_GET['pag'];
    }

    if ($pagina != 1){
        if (is_numeric($pagina) == false or $pagina < 1 or file_exists("galeria/" . 1 + (12*($pagina-1)) . ".jpg") == false){
            header("Location: error.php?id=2");
            exit();
        }
    }
    else if (file_exists("galeria/" . 1 + (12*($pagina-1)) . ".jpg") == false){
        header("Location: error.php?id=1");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/archivos.js" defer></script>
    <script src="js/tags.js" defer></script>
</head>
<body class="galerias">
    <nav>
        <h1>test</h1>
        <ul>
            <li><a href="galeria.php?pag=1">Galería</a></li>
            <li><a href="subir.php">Subir</a></li>
        </ul>
        <div class="nav-cuenta">
            <a href="php/cuenta.php" id="cuenta">Invitado</a>
        </div>
    </nav>
    <div class="galeria">
        <div class="galeria-panel">
            <div class="galeria-herramientas">
                <h2>Busqueda</h2>
                <input type="text">
                <h4>Tags populares</h4>
                <div class="galeria-tags-populares">
                    <span id="input-tag">csgo</span>
                    <span id="input-tag">counter strike</span>
                    <span id="input-tag">dark souls</span>
                    <span id="input-tag">left 4 dead 2</span>
                    <span id="input-tag">bocchi the rock</span>
                    <span id="input-tag">asfafasgasgagasfasf</span>
                    <span id="input-tag">counter strike 2</span>
                </div>
            </div>
        </div>
        <div class="galeria-panel2">
            <div class="galeria-imagenes">
                <?php
                    $imagenes = scandir("galeria/");
                    if (file_exists("galeria/Test.txt")){
                        $end_id = count($imagenes) - 4;
                    }
                    else{
                        $end_id = count($imagenes) - 3;
                    }

                    for ($i = 0; $i < 12; $i++){
                        $id = 1 + (12*($pagina-1)) + $i;
                        if (file_exists("galeria/" . $id . ".jpg")){
                            echo "<div class='contenido-bloque'>";
                            echo "<a href='post.php?id=" . $id . "'><img src='galeria/" . $id . ".jpg' alt=''></a>";
                            echo "<p>Post #" . $id . "</p>";
                            echo "</div>";
                        }
                        else if ($id <= $end_id){
                            echo "<div class='contenido-bloque contenido-bloque-phantom'>";
                            echo "<a href='error.php?id=4'><img src='resources/notfound.jpg' alt=''></a>";
                            echo "<p>Post #" . $id . " (Eliminado)</p>";
                            echo "</div>";
                        }
                    }
                ?>
            </div>
            <div class="galeria-botones">
                <div class="galeria-botones-izquierda">
                    <?php
                        if ($pagina > 1){
                            echo "<a class='boton' href='galeria.php?pag=" . $pagina-1 . "'>Anterior Pág.</a>";
                        }
                        else{
                            echo "<button class='boton' disabled>Anterior Pág.</button>";
                        }
                    ?>
                </div>
                <div class="galeria-botones-derecha">
                    <?php
                        if (file_exists("galeria/" . 1 + (12*($pagina)) . ".jpg")){
                            echo "<a class='boton' href='galeria.php?pag=" . $pagina+1 . "'>Siguiente Pág.</a>";      
                        }
                        else{
                            echo "<button class='boton' disabled>Siguiente Pág.</button>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
