<?php
    // por hacer: todooooo
    // falta bastante
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
        <h1>test</h1>
        <ul>
            <li><a href="galeria.php?pag=1">Galería</a></li>
            <li><a href="subir.php">Subir</a></li>
            <li><a href="perfiles.php">Usuarios</a></li>
        </ul>
        <div class="nav-cuenta">
            <a href="php/cuenta.php" id="cuenta">Invitado</a>
        </div>
    </nav>
    <div class="contenido-perfiles">
        <p>Buscar un usuario</p>
        <input type="text" name="nombreUsuario" placeholder="Nombre de usuario..." id="nombreUsuario">
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
                <p>jejejejej</p>
            </div>
            <div class="contenido-perfil-bloque">
                <p>jejejejej</p>
            </div>
            <div class="contenido-perfil-bloque">
                <p>jejejejej</p>
            </div>
            <div class="contenido-perfil-bloque">
                <p>jejejejej</p>
            </div>
            <div class="contenido-perfil-bloque">
                <p>jejejejej</p>
            </div>
        </div>
    </div>
</body>
</html>
