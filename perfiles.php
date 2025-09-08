<?php
    session_start();
    require "php/db/config.php";

    if (isset($_GET["q"])){
        if ((strlen($_GET["q"]) > 2) && !(empty($_GET["q"]))){
            $query = "%" . $_GET["q"] . "%";
            try{
                $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $conn->prepare("SELECT * FROM usuarios WHERE lower(username) LIKE ?");
                $sql->execute([$query]);
                $fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e){
                header("Location: error.php?id=9");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <script src="js/subir_modal.js" defer></script>
    <script src="js/perfiles/q_check.js" defer></script>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
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
    <div class="contenido-perfiles">
        <p>Buscar un usuario</p>
        <form action="perfiles.php" method="GET" id="formulario-buscar-usuario">
            <input type="text" name="q" placeholder="Introducir el nombre de usuario..." id="nombreUsuario">
        </form>
    </div>
    <div class="contenido-perfiles-usuarios">
        <?php
            if (isset($fetch)){
                echo "<p>Usuarios</p>";
                if (count($fetch) == 0){
                    echo "<p id='no-se-ha-encontrado'>No se han encontrado usuarios.</p>";
                }
                else{
                    echo "<div class='contenido-perfiles-usuarios-lista'>";
                    foreach ($fetch as $usuario){
                        $avatar = "resources/avatars/" . $usuario["id"] . ".png";
                        echo "<div class='contenido-perfil-bloque' onclick=\"location.href='perfil.php?id=" . $usuario["id"] . "'\">";
                        if (file_exists($avatar)){
                            echo "<img src='$avatar?v=" . filemtime($avatar) . "alt=''>";
                        }
                        else{
                            echo "<img src='resources/avatar.png' alt=''>";
                        }
                        echo "<div class='contenido-perfil-bloque-info'>";
                        echo "<div class='perfil-info-nickname-tags'>";
                        echo "<p><b>" . $usuario["nickname"] . "</b></p>";
                        if ($usuario["rol"] == "admin"){
                            echo "<span id='input-tag-admin' class='comentar-input-tag-op'>ADMIN</span>";
                        }
                        echo "</div>";
                        echo "<p id='contenido-perfil-bloque-info-username'>@" . htmlspecialchars($usuario["username"]) . "</p>";
                        if (!empty($usuario["descripcion"])){
                            echo "<p>" . strip_tags($usuario["descripcion"]) . "</p>";
                        }
                        else{
                            echo "<p>No hay descripción.</p>";
                        }
                        echo "</div></div>";
                    }
                    echo "</div>";
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
</body>
</html>
