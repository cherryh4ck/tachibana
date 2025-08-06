<?php
    // Por hacer!!
    // también estaría bueno mostrar un mensaje de error y no hacer un alert
    session_start();
    if (isset($_SESSION["logueado"])){
        header("Location: galeria.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/register/verify.js" defer></script>
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
    <nav>
        <p id="nav-logo">Tachibana</p>
        <ul>
            <li><a href="index.php?pag=1">Inicio</a></li>
            <li><a href="subir.php">Subir</a></li>
            <li><a href="perfiles.php">Usuarios</a></li>
        </ul>
        <div class="nav-cuenta">
            <a href="php/cuenta.php" id="cuenta">Anónimo</a>
        </div>
    </nav>
    <div class="contenido-menu">
        <form action="php/register.php" method="post" id="formulario">
            <p id="texto-centrado">Registrarse</p>
            <input type="text" name="user" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" id="contraseña" required>
            <input type="password" name="verifyPassword" placeholder="Repetir contraseña" id="repetirContraseña" required>
            <input type="submit" value="Registrarse">
        </form>
        <p id="registrate">¿Tenés cuenta? Iniciá sesión <a href="login.php">acá</a></p>
    </div>
</body>
</html>
