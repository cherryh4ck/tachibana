<?php
    if (isset($_GET["id"]) && is_numeric($_GET["id"])){
        $id = $_GET["id"];
        if (!file_exists("galeria/fullsize/" . $id . ".jpg")){
            header("Location: error.php?id=2");
            exit();
        }
    }
    else{
        header("Location: error.php?id=2");
    }

    //todo: mejores tags - like y dislikes - mejor preview (?)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/post/comentar.js" defer></script>
</head>
<body>
    <nav>
        <h1>test</h1>
        <ul>
            <li><a href="galeria.php?pag=1">Galería</a></li>
            <li><a href="subir.php">Subir</a></li>
        </ul>
        <div class="nav-cuenta">
            <a href="php/cuenta.php" id="cuenta">Invitado</a>
        </div>
    </nav>
    <header>
        <div class="contenido-post">
            <?php
                echo "<img src='galeria/fullsize/" . $id . ".jpg'>";
                echo "<div class='post-contenido'>";
                echo "<div class='post-contenido-titulo'>";
                echo "<h1 id='post-titulo'>Título</h1>";
                echo "<h2 id='post-id'>ID #" . $id . "</h2>";
                echo "<div class='post-contenido-tags'>";
                echo "<span id='input-tag2'>tag1</span>";
                echo "<span id='input-tag2'>tag2</span>";
                echo "<span id='input-tag2'>asfsafafafafagg</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "</div>";
                echo "<h2 id='post-titulo-descripcion'>Descripción</h2>";
                echo "<p id='post-descripcion'>Descripción. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium aspernatur alias harum velit laborum perspiciatis quisquam autem voluptatum ducimus deleniti. Placeat fugiat veniam provident, blanditiis quos voluptatum aliquam cupiditate ullam.</p>";
                echo "</div>";
            ?>
            <h2 id="post-comentarios-titulo">Comentarios</h1>
            <div class="post-comentarios">
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <p><b>User</b><br>Hola</p>
                </div>
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <p><b>User</b><br>Testeo</p>
                </div>
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <p><b>User</b><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae accusamus quidem voluptatum eius. In sunt numquam sequi error vel fugit, consequatur, nesciunt temporibus commodi corporis reiciendis, excepturi sapiente. Facere, debitis.</p>
                </div>
            </div>
            <h2 id="post-comentarios-comentar">Comentar</h2>
            <div class="post-comentarios-comentar">
                <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                <form action="" method="post">
                    <textarea name="" id="post-comentarios-textarea" rows="2" required></textarea>
                    <input type="submit" value="Comentar" id="post-comentarios-enviar" disabled>
                </form>
            </div>
            </div>
        </div>
    </header>
</body>
</html>
