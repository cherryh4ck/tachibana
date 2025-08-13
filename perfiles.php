<?php
    // por hacer: todooooo
    // falta bastante
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
    <div class="contenido-perfiles">
        <p>Buscar un usuario</p>
        <input type="text" name="nombreUsuario" placeholder="Introducir el nombre de usuario..." id="nombreUsuario">
    </div>
    <div class="contenido-perfiles-usuarios">
        <p>Usuarios</p>
        <div class="contenido-perfiles-usuarios-lista">
            <div class="contenido-perfil-bloque" onclick="location.href='perfil.php?id=1'">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
            <div class="contenido-perfil-bloque">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
            <div class="contenido-perfil-bloque">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
            <div class="contenido-perfil-bloque">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
            <div class="contenido-perfil-bloque">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
            <div class="contenido-perfil-bloque">
                <img src="resources/avatar.png" alt="">
                <div class="contenido-perfil-bloque-info">
                    <p><b>Display name</b></p>
                    <p id="contenido-perfil-bloque-info-username">@usuario</p>
                    <p>Pequeña biografía dalfslalkfkalkflkalkfalklkslkf</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
