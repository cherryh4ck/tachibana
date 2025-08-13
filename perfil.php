<?php
    require "php/db/config.php";
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    session_start();
    if (isset($_GET["id"])){
        if (!is_numeric($_GET["id"])){
            header("Location: error.php?id=2");
        }
    }
    else{
        if (isset($_SESSION["cuenta_usuario"])){
            $_GET["id"] = $_SESSION["cuenta_id"];
        }
        else{
            header("Location: login.php");
        }
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
        }
        else{
            header("Location: error.php?id=2");
        }
    }
    catch (PDOException $e){
        header("Location: error.php?id=2");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<title>" . $nickname . " - " . $nombre_usuario . "</title>";
    ?>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/archivos.js" defer></script>
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
                <div class="perfil-banner-parte1">
                    <img src="resources/avatar.png" alt="">
                    <div class="perfil-info">
                        <?php 
                            echo "<p><b>$nickname</p></b>";
                            echo "<p id='contenido-perfil-bloque-info-username'>@$nombre_usuario</p>";
                        ?>
                        <div class="perfil-info-avanzada">
                            <?php
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

                                echo "<p>$texto <span id='viñeta'>•</span> Última vez hace ?"
                            ?>
                        </div>  
                    </div>
                </div>
                <?php
                    if ($_GET["id"] === $_SESSION["cuenta_id"]){
                        echo "<div class='perfil-banner-parte2'>";
                        echo "<button>Editar perfil</button>";
                        echo "<button onclick=" . "window.location.href=" . 'php/db/logout.php' . ">Cerrar sesión</button>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
        <div class="perfil-div perfil-div-separacion">
            <div class="perfil-descripcion">
                <?php
                    if (!empty($descripcion)){
                        echo "<p>$descripcion</p>";
                    }
                    else{
                        echo "<p>No hay descripción.</p>";
                    }
                ?>
        </div>
    </header>
</body>
</html>
