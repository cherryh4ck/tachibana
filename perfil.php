<?php
    session_start();
    if (isset($_GET["id"])){
        // Mostrar cuenta si es que existe
        $nombreDeUsuario = "Default";
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
        echo "<title>" . $nombreDeUsuario . "</title>";
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
                <p>User</p>
            </div>
        </div>
    </header>
</body>
</html>
