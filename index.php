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
    <script src="js/subir_modal.js" defer></script>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="galerias">
    <nav>
        <p id="nav-logo">Tachibana</p>
        <ul>
            <li><a href="index.php?pag=1">Inicio</a></li>
            <?php
                if (isset($_SESSION["cuenta_usuario"])){
                    echo "<li><a href='#' id='subir-boton-modal'>Publicar</a></li>";
                }
            ?>
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
                                echo "<a class='boton' href='index.php?pag=" . $pagina-1 . "'>Anterior Pág.</a>";
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
                                echo "<a class='boton' href='index.php?pag=" . $pagina+1 . "'>Siguiente Pág.</a>";      
                            }
                            else{
                                echo "<button class='boton' disabled>Siguiente Pág.</button>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <dialog style="display: none;" class="contenido-subir">
            <script src="js/archivos.js" type="module" defer></script>
            <script src="js/tags.js" type="module" defer></script>
            <img src="" alt="" id="image-preview" style="display: none;">
            <div class="contenido-subir-formulario">
                <form action="php/subida.php" method="POST" enctype="multipart/form-data" id="formulario-subir" onkeydown="if (event.keyCode === 13 && event.target.tagName !== 'TEXTAREA') {return false;}">
                    <input type="hidden" name="tags" id="tags-value" value="">
                    <div class="contenido-subir-formulario-fila1">
                        <div class="contenido-subir-formulario-fila1-input">
                            <p>Título</p>
                            <input type="text" name="titulo" id="titulo-input" placeholder="Título del post..." required>
                        </div> 
                        <div class="contenido-subir-formulario-fila1-input">
                            <p>Categoría</p>
                            <select name="categoria" id="categoria-input" size="1">
                                <option value="1">General - /any/</option>
                                <option value="2">Anime - /anime/</option>
                                <option value="3">Manga - /manga/</option>
                                <option value="4">Videojuegos - /games/</option>
                                <option value="5">Política - /pol/</option>
                                <option value="6">Tecnología - /tech/</option>
                                <option value="7">Música - /music/</option>
                                <option value="8">Películas - /movie/</option>
                                <option value="9">Programación - /coding/</option>
                            </select>
                        </div> 
                    </div>
                    <div class="contenido-subir-formulario-fila1">
                        <div class="contenido-subir-formulario-fila1-input-allspace">
                            <p>Descripción</p>
                            <textarea name="descripcion" id="descripcion-input" placeholder="Descripción del post..." rows="7" cols="60"></textarea>
                        </div>
                    </div>
                    <div class="contenido-subir-formulario-fila1-input-checkbox">
                        <input type="checkbox" name="anonimo" id="anonimo-checkbox">
                        <label for="anonimo">Publicar de forma anónima</label>
                    </div>
                    <div class="contenido-subir-formulario-fila1">
                        <div class="contenido-subir-formulario-fila1-input">
                            <p>Tags</p>
                            <div class="contenido-subir-formulario-fila1-input-tags" id="insert-tags">
                                <p id="no-hay-tags">Añade un tag...</p>
                            </div>
                        </div>
                        <div class="contenido-subir-formulario-fila1-input">
                            <p>Insertar tags</p>
                            <input type="text" id="tags-input" placeholder="Tag... (máx. 4)">
                        </div>
                    </div>
                    <div class="contenido-subir-formulario-fila-subir">
                        <input type="file" accept=".png, .jpg, .jpeg, .gif" name="archivo" id="archivo-file" class="subir-archivo">
                        <div class="contenido-subir-formulario-fila-subir-textos">
                            <p id="imagen-texto">Imagen no seleccionada</p>
                            <div class="contenido-subir-formulario-fila-subir-textos-estado">
                                <p id="imagen-tamano"></p>
                                <p id="imagen-res"></p>
                            </div>
                        </div>
                    </div>
                    <div class="contenido-subir-formulario-error">
                        <!-- div para mostrar errores / avisos mediante js/archivos.js -->
                        <p style="display: none;" id="mensaje-error"><span>Error al subir la imagen:</span> Test test</p>
                        <p style="display: none;" id="mensaje-aviso"><span id="mensaje-aviso2">Aviso:</span> Tu ID de usuario se seguirá guardando en la base de datos como identificación, pero esto es solamente visible para administradores.</p>
                    </div>
                    <input type="submit" value="Subir" id="btn-enviar" disabled>
                </form>
            </div>
        </dialog>
    </div>
</body>
</html>
