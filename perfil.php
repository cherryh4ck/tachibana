<?php
    require "php/db/config.php";
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    session_start();
    $modo = "ver";
    if (isset($_GET["id"])){
        if (!is_numeric($_GET["id"])){
            header("Location: error.php?id=2");
            exit();
        }
    }
    else{
        if (isset($_SESSION["cuenta_usuario"])){
            $_GET["id"] = $_SESSION["cuenta_id"];
        }
        else{
            header("Location: login.php");
            exit();
        }
    }

    if (isset($_GET["editar"])){
        $modo = "editar";
    }

    try{
        $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $sql->execute([$_GET["id"]]);
        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
        if ($fetch){
            $nombre_usuario = $fetch["username"];
            $nickname = $fetch["nickname"];
            $descripcion = $fetch["descripcion"];
            $rol = $fetch["rol"];
            $fecha_creacion = $fetch["fecha_creacion"];
            $ultima_actividad = $fetch["ultima_actividad"];
            $avatar = "resources/avatars/" . $_GET["id"] . ".png";
        }
        else{
            header("Location: error.php?id=2");
            exit();
        }
    }
    catch (PDOException $e){
        header("Location: error.php?id=2");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<title> $nickname - @$nombre_usuario </title>";
    ?>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
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
    <header>
        <div class="perfil-div">
            <div class="perfil-banner">
                <?php
                    if ($modo == "ver"){
                        echo "<div class='perfil-banner-parte1'>";
                        if (file_exists($avatar)){
                            echo "<img src='$avatar' alt=''>";
                        }
                        else{
                            echo "<img src='resources/avatar.png' alt=''>";
                        }
                        echo "<div class='perfil-info'>";
                        echo "<p><b>$nickname</p></b>";
                        echo "<p id='contenido-perfil-bloque-info-username'>@$nombre_usuario</p>";
                        echo "<div class='perfil-info-avanzada'>";
                        // codigo más largo q no se ke xddd

                        // gracias chatgpt, ni sabía de esto kek
                        // por poco lo hago mucho más complicado :P
                        $tiempo_actual = new DateTime();
                        $tiempo_creado = new DateTime($fecha_creacion);
                        $diferencia = $tiempo_actual->diff($tiempo_creado);
                        $texto = "";

                        if ($diferencia->y > 0) {
                            if ($diferencia->y > 1){
                                $texto = "Se unió hace $diferencia->y años";
                            }
                            else{
                                $texto = "Se unió hace un año";
                            }
                        } elseif ($diferencia->m > 0) {
                            if ($diferencia->m > 1){
                                $texto = "Se unió hace $diferencia->m meses";
                            }
                            else{
                                $texto = "Se unió hace un mes";
                            }
                        } elseif ($diferencia->d > 0) {
                            if ($diferencia->d > 1){
                                $texto = "Se unió hace $diferencia->d días";
                            }
                            else{
                                $texto = "Se unió hace un día";
                            }
                        } elseif ($diferencia->h > 0) {
                            if ($diferencia->h > 1){
                                $texto = "Se unió hace $diferencia->h horas";
                            }
                            else{
                                $texto = "Se unió hace una hora";
                            }
                        } elseif ($diferencia->i > 0) {
                            if ($diferencia->i > 1){
                                $texto = "Se unió hace $diferencia->i minutos";
                            }
                            else{
                                $texto = "Se unió hace un minuto";
                            }
                        } else {
                            $texto = "Se unió hace unos segundos";
                        }

                        echo "<p>$texto <span id='viñeta'>•</span> Última vez hace ?</p>";
                        echo "</div>";  
                        echo "</div>";
                        echo "</div>";
                        if (isset($_SESSION["cuenta_id"])){
                            if ($_GET["id"] == $_SESSION["cuenta_id"]){
                                echo "<div class='perfil-banner-parte2'>";
                                echo '<button onclick="window.location.href=\'perfil.php?editar=1\'">Editar perfil</button>';
                                echo '<button onclick="window.location.href=\'php/db/logout.php\'">Cerrar sesión</button>';
                                echo "</div>";
                            }
                        }
                    }
                    else{
                        if (isset($_SESSION["cuenta_id"])){
                            if ($_GET["id"] == $_SESSION["cuenta_id"]){
                                
                            }
                            else{
                                header("Location: index.php");
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <?php
            if ($modo == "ver"){
                echo "<div class='perfil-div perfil-div-separacion'>";
                echo "<div class='perfil-descripcion'>";
                if (!empty($descripcion)){
                    $descripcion = str_replace(["<br>", "<br />"], "</p><p>", $descripcion);
                    $descripcion = "<p>$descripcion</p>";
                    $descripcion = preg_replace(
                        '/<p>\s*(&gt;|>)(.*)<\/p>/',
                        '<p id="post-comentarios-greentext">&gt;$2</p>',
                        $descripcion
                    );
                    echo $descripcion;
                }
                else{
                    echo "<p>No hay descripción.</p>";
                }
                echo "</div>";
            }
            else{
                echo <<<EOM
                <div class="perfil-div">
                <div class="perfil-banner">
                <div class="perfil-banner-parte1-modificado">
                <script src="js/perfil/editar.js" defer></script>
                <form action="php/account/editar.php" method="POST" enctype="multipart/form-data" onkeydown="if (event.keyCode === 13 && event.target.tagName !== 'TEXTAREA') {return false;}">
                <div class="perfil-banner-parte1-modificado-input">
                <p>Nickname</p>
                EOM;
                echo "<input type='text' name='nickname' id='nickname-input' value='$nickname' placeholder='Nickname...'>";
                echo <<<EOM
                </div>
                <div class="perfil-banner-parte1-modificado-input">
                <p>Descripción</p>
                EOM;
                echo "<textarea name='descripcion' id='descripcion-input' placeholder='Descripción...'>" . strip_tags($descripcion) . "</textarea>";
                echo <<<EOM
                </div>
                <div class="perfil-banner-parte1-modificado-input">
                <p>Avatar</p>
                <div class="perfil-banner-parte1-modificado-input-avatar">
                EOM;
                if (file_exists($avatar)){
                    echo "<img src='$avatar' alt='' id='avatar-img'>";
                }
                else{
                    echo "<img src='resources/avatar.png' alt='' id='avatar-img'>";
                }
                echo <<<EOM
                <input type="file" accept=".png, .jpg, .jpeg" name="avatar" id="avatar-file">
                </div>
                <div class="contenido-subir-formulario-error perfil-editar-mensaje">
                        <!-- div para mostrar errores / avisos mediante js/archivos.js -->
                        <p style="display: none;" id="mensaje-error"><span>Error al subir la imagen:</span> Test test</p>
                        <p style="display: none;" id="mensaje-aviso"><span id="mensaje-aviso2">Aviso:</span> El ancho y la altura del avatar no coinciden, por lo que puede verse estirado.</p>
                </div>
                </div>   
                <div class="perfil-banner-parte1-modificado-input perfil-banner-parte1-modificado-input-gap">
                <input type="submit" value="Guardar cambios" id="guardar-cambios">
                <input type="button" value="Volver" onclick="window.location.href='perfil.php'">
                </div>
                </form>
                </div>
                </div>
                </div>
                EOM;
            }
            // quitar descripcion
        ?>
    </header>
</body>
</html>
