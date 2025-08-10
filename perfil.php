<?php
    session_start();
    if (isset($_GET["id"])){
        // Mostrar cuenta si es que existe
        $nick = "Nombre de usuario";
        $username = "@username";
    }
    else{
        if (isset($_SESSION["logueado"])){
            // Mostrar perfil propio
        }
        else{
            header("Location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<title>" . $nick . " - " . $username . "</title>";
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
            <a href="php/cuenta.php" id="cuenta">Anónimo</a>
        </div>
    </nav>
    <header>
        <div class="perfil-div">
            <div class="perfil-banner">
                <img src="resources/avatar.png" alt="">
                <div class="perfil-info">
                    <p><b>Nombre de usuario</b></p>
                    <p id="contenido-perfil-bloque-info-username">@username</p>
                    <div class="perfil-info-avanzada">
                        <p>Se unió hace dos años <span id="viñeta">•</span> Última vez hace 30 minutos</p>
                    </div>  
                </div>
            </div>
        </div>
        <div class="perfil-div perfil-div-separacion">
            <div class="perfil-descripcion">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus totam quaerat quod nulla enim, praesentium a quos, eum deserunt asperiores in assumenda natus esse officiis unde, aut nesciunt saepe. Temporibus?</p>
            </div>
        </div>
    </header>
</body>
</html>
