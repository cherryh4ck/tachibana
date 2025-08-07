<?php
    // TODO: Hacer sistema de tags
    // Añadir opción para borrar los tags
    // Añadir input de descripción y categoría

    // REWORK EN PROGRESO!!
    // por el momento todo el diseño se está puliendo para luego convertirlo en ventana modal
    // y así no requiere de una página aparte
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar un post</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/archivos.js" type="module" defer></script>
    <script src="js/tags.js" type="module" defer></script>
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
    <header>
        <div class="contenido-subir">
            <div class="contenido-subir-divisores">
                <div class="contenido-subir-preview">
                    <img src="https://placehold.co/400x300" alt="" id="image-preview">
                </div>
            </div>
            <div class="contenido-subir-divisores">
                <div class="contenido-subir-formulario">
                    <form action="php/subida.php" method="POST" enctype="multipart/form-data" id="formulario-subir" onkeydown="if (event.keyCode === 13) {return false;}">
                        <div class="contenido-subir-formulario-fila1">
                            <div class="contenido-subir-formulario-fila1-input">
                                <p>Título</p>
                                <input type="text" name="titulo" id="titulo-input" placeholder="Título del post..." required>
                            </div> 
                            <div class="contenido-subir-formulario-fila1-input">
                                <p>Categoría</p>
                                <select name="categoria" id="categoria-input" size="1">
                                    <option value="any">General - /any/</option>
                                    <option value="anime">Anime - /anime/</option>
                                    <option value="games">Videojuegos - /games/</option>
                                    <option value="pol">Política - /pol/</option>
                                    <option value="tecno">Tecnología - /tecno/</option>
                                </select>
                            </div> 
                        </div>
                        <div class="contenido-subir-formulario-fila1">
                            <div class="contenido-subir-formulario-fila1-input-allspace">
                                <p>Descripción</p>
                                <textarea name="descripcion" id="descripcion-input" placeholder="Descripción del post..."></textarea>
                            </div>
                        </div>
                        <div class="contenido-subir-formulario-fila1">
                            <div class="contenido-subir-formulario-fila1-input">
                                <p>Tags</p>
                                <div class="contenido-subir-formulario-fila1-input-tags" id="insert-tags">
                                </div>
                            </div>
                            <div class="contenido-subir-formulario-fila1-input">
                                <p>Insertar tags</p>
                                <input type="text" name="titulo" id="tags-input" placeholder="Tag... (máx. 4)">
                            </div>
                        </div>
                        <input type="file" accept=".png, .jpg, .jpeg, .gif" name="archivo" id="archivo-file" class="subir-archivo">
                        <input type="submit" value="Subir" id="btn-enviar" disabled>
                    </form>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
