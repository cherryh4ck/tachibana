<?php
    // TODO: Sistema de busqueda ?
    // Sistema de indexado (Yo creo que estaría feo mostrar las imágenes borradas como inaccesibles)
    // Arreglar lo de que si el ID 1 no existe, colapsa todo el sistema xd
    session_start();
    require "php/db/config.php";

    if ($conn_test == 1){
        try{
            if (isset($_GET["categoria"]) && !($_GET["categoria"] == "all")){
                $categoria = $_GET["categoria"];
                $sql = $conn->prepare("SELECT * from categorias WHERE nombre = ?");
                $sql->execute([$categoria]);
                $fetch_categoria = $sql->fetch(PDO::FETCH_ASSOC);
                if ($fetch_categoria){
                    $id_categoria = $fetch_categoria["id"];
                }
                else{
                    $id_categoria = 1;
                }

                if (isset($_GET["q"]) && !(empty($_GET["q"]))){
                    $query = "%" . $_GET["q"] . "%";
                    $sql = $conn->prepare("SELECT * from posts WHERE id_categoria = ? AND lower(titulo) LIKE ?");
                    $sql->execute([$id_categoria, $query]);
                    $fetch_posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                else{
                    $sql = $conn->prepare("SELECT * from posts WHERE id_categoria = ?");
                    $sql->execute([$id_categoria]);
                    $fetch_posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            else{
                $categoria = "all";

                if (isset($_GET["q"]) && !(empty($_GET["q"]))){
                    $query = "%" . $_GET["q"] . "%";
                    $sql = $conn->prepare("SELECT * from posts WHERE lower(titulo) LIKE ?");
                    $sql->execute([$query]);
                    $fetch_posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                else{
                    $sql = $conn->prepare("SELECT * from posts");
                    $sql->execute();
                    $fetch_posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            $sql = $conn->prepare("SELECT * FROM tags ORDER BY usos DESC LIMIT 5");
            $sql->execute();
            $fetch_tags = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            // mostrar error
        }
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
            <li><a href="index.php">Inicio</a></li>
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
                <form action="index.php" method="GET">
                    <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
                    <input type="text" name="q" placeholder="Buscar..." id="input-busqueda" <?php if (isset($_GET["q"]) && !(empty($_GET["q"]))){ echo "value='" . htmlspecialchars($_GET["q"]) . "'";} ?>>
                </form>
                <?php
                    if ($fetch_tags){
                        echo "<h4>Tags populares</h4>";
                        echo "<div class='galeria-tags-populares'>";
                        if ($fetch_tags){
                            foreach ($fetch_tags as $tag){
                                echo "<span id='input-tag'>" . $tag["nombre"] . "<b>" . $tag["usos"] . "</b></span>";
                            }
                        }
                        else{
                            echo "<p id='sin-resultados'>No hay resultados</p>";
                        }
                        echo "</div>";
                    }
                ?>
                <h4>Categoría seleccionada</h4>
                <div class="galeria-categoria-seleccionada">
                    <select name="categoria" id="categoria-input-index" size="1">
                                <option value="all" <?php if ($categoria == "all"){ echo "selected";} ?>>Todos los posts</option>
                                <option value="any" <?php if ($categoria == "any"){ echo "selected";} ?>>General - /any/</option>
                                <option value="anime" <?php if ($categoria == "anime"){ echo "selected";} ?>>Anime - /anime/</option>
                                <option value="manga" <?php if ($categoria == "manga"){ echo "selected";} ?>>Manga - /manga/</option>
                                <option value="games" <?php if ($categoria == "games"){ echo "selected";} ?>>Videojuegos - /games/</option>
                                <option value="pol" <?php if ($categoria == "pol"){ echo "selected";} ?>>Política - /pol/</option>
                                <option value="tech" <?php if ($categoria == "tech"){ echo "selected";} ?>>Tecnología - /tech/</option>
                                <option value="music" <?php if ($categoria == "music"){ echo "selected";} ?>>Música - /music/</option>
                                <option value="movie" <?php if ($categoria == "movie"){ echo "selected";} ?>>Películas - /movie/</option>
                                <option value="coding" <?php if ($categoria == "coding"){ echo "selected";} ?>>Programación - /coding/</option>
                    </select>
                    <?php
                        echo "<span id='input-tag-rojo-index'>/$categoria/</span>";
                    ?>
                </div>
            </div>
        </div>
        <div class="galeria-panel2">
            <?php
                if (!$fetch_posts){
                    echo "<div class='galeria-imagenes-sin-posts'>";
                    echo "<p id='sin-resultados-post'>No se han encontrado resultados</p>";
                }
                else{
                    echo "<div class='galeria-imagenes'>";
                    foreach ($fetch_posts as $post){
                        if (file_exists("galeria/" . $post["id"] . ".jpg")){
                            try {
                                $sql = $conn->prepare("SELECT * FROM posts WHERE id = ?");
                                $sql->execute([$post["id"]]);
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
                                echo "<p>(Eliminado)</p>";
                                echo "</div>";
                                // ?????? que es esto
                            }
                            echo "<div class='contenido-bloque'>";
                            echo "<div class='contenido-bloque-categoria'>";
                            echo "<span id='input-tag-rojo'>/$post_categoria/</span>";
                            echo "</div>";
                            echo "<a href='post.php?id=" . $post["id"] . "'><img src='galeria/" . $post["id"] . ".jpg' alt=''></a>";
                            echo "<p>$post_titulo</p>";
                            echo "</div>";
                        }
                        /*else if ($id <= $end_id){
                            echo "<div class='contenido-bloque contenido-bloque-phantom'>";
                            echo "<a href='error.php?id=4'><img src='resources/notfound.jpg' alt=''></a>";
                            echo "<p>Post #" . $id . " (Eliminado)</p>";
                            echo "</div>";
                        }*/
                    }
                }
            ?>
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
