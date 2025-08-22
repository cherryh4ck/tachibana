<?php
    // TODO: Sistema de busqueda ?
    // Sistema de indexado (Yo creo que estaría feo mostrar las imágenes borradas como inaccesibles)
    // Arreglar lo de que si el ID 1 no existe, colapsa todo el sistema xd
    session_start();
    require "php/db/config.php";

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

    try{
        $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e){
        // mostrar error
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <script src="js/index/categorias.js" defer></script>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="galerias">
    <nav>
        <p id="nav-logo">Tachibana</p>
        <ul>
            <li><a href="index.php?pag=1">Inicio</a></li>
            <li><a href="subir.php">Publicar</a></li>
            <li><a href="perfiles.php">Usuarios</a></li>
        </ul>
        <div class="nav-cuenta">
            <?php
                if (!isset($_SESSION["cuenta_usuario"])){
                    echo "<a href='php/cuenta.php' id='cuenta'>Anónimo</a>"; 
                }
                else{
                    echo "<a href='php/cuenta.php' id='cuenta'>" . $_SESSION["cuenta_usuario"] . "</a>"; 
                }
            ?>
        </div>
    </nav>
    <div class="galeria">
        <div class="galeria-panel">
            <div class="galeria-herramientas">
                <h2>Búsqueda</h2>
                <input type="text" placeholder="Buscar...">
                <h4>Tags populares</h4>
                <div class="galeria-tags-populares">
                    <span id="input-tag">csgo<b>7</b></span>
                    <span id="input-tag">counter strike<b>6</b></span>
                    <span id="input-tag">dark souls<b>5</b></span>
                    <span id="input-tag">left 4 dead 2<b>4</b></span>
                    <span id="input-tag">bocchi the rock<b>3</b></span>
                    <span id="input-tag">asfafasgasgagasfasf<b>2</b></span>
                    <span id="input-tag">counter strike 2<b>1</b></span>
                </div>
                <h4>Categoría</h4>
                <div class="galeria-categoria-seleccionada">
                    <select name="categoria" id="categoria-input-index" size="1">
                                <option value="any">General - /any/</option>
                                <option value="anime">Anime - /anime/</option>
                                <option value="manga">Manga - /manga/</option>
                                <option value="games">Videojuegos - /games/</option>
                                <option value="pol">Política - /pol/</option>
                                <option value="tech">Tecnología - /tech/</option>
                                <option value="music">Música - /music/</option>
                                <option value="movie">Películas - /movie/</option>
                                <option value="coding">Programación - /coding/</option>
                    </select>
                    <span id="input-tag-rojo-index">/any/</span>
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
                            try {
                                $sql = $conn->prepare("SELECT * FROM posts WHERE id = ?");
                                $sql->execute([$id]);
                                $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                                if ($fetch){
                                    $post_id_categoria = $fetch["id_categoria"];
                                    $post_titulo = $fetch["titulo"];

                                    $sql = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
                                    $sql->execute([$post_id_categoria]);
                                    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
                                    if ($fetch){
                                        $post_categoria = $fetch["nombre"];
                                    }
                                }
                            }
                            catch (PDOException $e){
                                echo "<div class='contenido-bloque contenido-bloque-phantom'>";
                                echo "<a href='error.php?id=4'><img src='resources/notfound.jpg' alt=''></a>";
                                echo "<p>Post #" . $id . " (Eliminado)</p>";
                                echo "</div>";
                            }
                            echo "<div class='contenido-bloque'>";
                            // acá iría el tag
                            echo "<div class='contenido-bloque-categoria'>";
                            echo "<span id='input-tag-rojo'>/$post_categoria/</span>";
                            echo "</div>";
                            echo "<a href='post.php?id=" . $id . "'><img src='galeria/" . $id . ".jpg' alt=''></a>";
                            echo "<p>$post_titulo</p>";
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
                        if (file_exists("galeria/" . 1 + (12*($pagina-1)) . ".jpg")){
                            if ($pagina > 1){
                                echo "<a class='boton' href='galeria.php?pag=" . $pagina-1 . "'>Anterior Pág.</a>";
                            }
                            else{
                                echo "<button class='boton' disabled>Anterior Pág.</button>";
                            }
                        }
                    ?>
                </div>
                <div class="galeria-botones-derecha">
                    <?php
                        if (file_exists("galeria/" . 1 + (12*($pagina-1)) . ".jpg")){
                            if (file_exists("galeria/" . 1 + (12*($pagina)) . ".jpg")){
                                echo "<a class='boton' href='galeria.php?pag=" . $pagina+1 . "'>Siguiente Pág.</a>";      
                            }
                            else{
                                echo "<button class='boton' disabled>Siguiente Pág.</button>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
