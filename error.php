<?php
    $errores = [
        "No hay contenido en esta página.",
        "No se ha encontrado el contenido solicitado.", // Ya no se usa!
        "La imagen está corrupta o no es válida.",
        "No se ha encontrado el contenido solicitado porque fue eliminado por el usuario.",
        "No se ha encontrado el contenido solicitado porque fue moderado."
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/archivos.js" defer></script>
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
    <header>
        <h1>Ups, hubo un problema...</h1>
        <?php
            if ((isset($_GET["id"])) && (is_numeric($_GET["id"]) && ($_GET["id"] > 0) && ($_GET["id"] < (count($errores) + 1)))) {
                echo "<p id='error'>" . $errores[$_GET["id"] - 1] . "</p>";
            }
        ?>
        <p id="disculpas"><b>Pedimos disculpas.</b></p>
    </header>
</body>
</html>
