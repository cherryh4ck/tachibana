<?php
    require "php/db/config.php";
    session_start();

    if (isset($_GET["id"]) && is_numeric($_GET["id"])){
        $id = $_GET["id"];
        if (!file_exists("galeria/fullsize/" . $id . ".jpg")){
            if (file_exists("galeria/fullsize/" . $id . ".gif")){
                $ext = "gif";
            }
            else{
                header("Location: error.php?id=2");
                exit();
            }
        }
        else{
            $ext = "jpg";
        }
    }
    else{
        header("Location: error.php?id=2");
        exit();
    }
    try {
        $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $conn->prepare("SELECT * FROM posts WHERE id = ?");
        $sql->execute([$id]);
        $fetch = $sql->fetch(PDO::FETCH_ASSOC);
        if ($fetch){
            $post_titulo = $fetch["titulo"];
            $post_descripcion = $fetch["descripcion"];
            $post_id_autor = $fetch["id_autor"];
            $post_fecha_creacion = $fetch["fecha_creacion"];

            $dateTime = new DateTime($post_fecha_creacion);
            $post_fecha_creacion = $dateTime->format("d-m-Y \a \l\a\s H:i:s");

            // buscar datos del OP
            $sql = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
            $sql->execute([$post_id_autor]);
            $fetch = $sql->fetch(PDO::FETCH_ASSOC);
            if ($fetch){
                $post_autor_username = $fetch["username"];
                $post_autor_nickname = $fetch["nickname"];
                $post_autor_perfil = "perfil.php?id=" . $post_id_autor;
            }
            else{
                header("Location: error.php?id=2");
                exit();
            }
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

    //todo:
    // hacer funcionar el botón de adjuntar imagen
    // añadir info de la imagen al adjuntar imagen
    // añadir id a los comentarios
    // añadir soporte para las imagenes en los comentarios
    // añadir categoria
    // arreglar el alineado del titulo kek
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<title>" . $post_titulo . "</title>";
    ?>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/post/comentar.js" defer></script>
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
        <div class="contenido-post">
            <?php
                echo "<img src='galeria/fullsize/" . $id . "." . $ext ."'>";
                echo "<div class='post-contenido'>";
                echo "<div class='post-contenido-titulo'>";
                echo "<h1 id='post-titulo'>$post_titulo</h1>";
                echo "<h2 id='post-id'>ID #" . $id . "</h2>";
                echo "<div class='post-contenido-tags'>";
                echo "<span id='input-tag2'>tag1</span>";
                echo "<span id='input-tag2'>tag2</span>";
                echo "<span id='input-tag2'>asfsafafafafagg</span>";
                echo "<span id='input-tag2'>test tes test t eststst</span>";
                echo "</div>";
                echo "<div class='post-autor'>";
                echo "<img src='resources/avatar.png' alt='Avatar' id='post-autor-avatar'>";
                echo "<div class='post-autor-info'>";
                echo "<p><b><a href='$post_autor_perfil'>$post_autor_nickname</a></b><br>";
                echo "<p>Publicado el $post_fecha_creacion</p>";
                echo "</div>";
                echo "</div>";
                echo "<h2 id='post-titulo-descripcion'>Descripción</h2>";
                echo "<p id='post-descripcion'>$post_descripcion</p>";
                echo "</div>";
            ?>
            <h2 id="post-comentarios-titulo">Comentarios</h1>
            <div class="post-comentarios">
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <div class="post-comentarios-comentario-info">
                        <div class="post-comentarios-comentario-autor">
                            <p><b><a href="">Usuario 1</a></b></p>
                            <p id="post-comentarios-comentario-fecha">24-07-2025 a las 5:06 AM</p>
                        </div>
                        <div class="post-comentarios-comentario-texto">
                            <p>Hola</p>
                        </div>
                    </div>
                </div>
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <div class="post-comentarios-comentario-info">
                        <div class="post-comentarios-comentario-autor">
                            <p><b><a href="">Usuario 2</a></b></p>
                            <p id="post-comentarios-comentario-fecha">24-07-2025 a las 5:12 AM</p>
                        </div>
                        <div class="post-comentarios-comentario-texto">
                            <p>Hola</p>
                            <p id="post-comentarios-greentext">>green text test. lol</p>
                        </div>
                    </div>
                </div>
                <div class="post-comentarios-comentario">
                    <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                    <div class="post-comentarios-comentario-info">
                        <div class="post-comentarios-comentario-autor">
                            <p><b><a href="">Usuario 3</a></b></p>
                            <p id="post-comentarios-comentario-fecha">24-07-2025 a las 5:54 AM</p>
                        </div>
                        <div class="post-comentarios-comentario-texto">
                            <p>Hola :3</p>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veniam, expedita, dolore illo corrupti voluptatum, rem beatae enim distinctio doloribus quis non. Repudiandae porro provident quibusdam eius quod enim cumque iure.</p>
                        </div>
                    </div>
                </div>
            </div>
            <h2 id="post-comentarios-comentar">Comentar</h2>
            <div class="post-comentarios-comentar">
                <img src="resources/avatar.png" alt="" id="post-comentarios-comentario-avatar">
                <form action="" method="post">
                    <textarea name="" id="post-comentarios-textarea" rows="2" placeholder="Tu comentario..." required></textarea>
                    <div class="post-comentarios-comentar-botones">
                        <input type="submit" value="Comentar" id="post-comentarios-enviar" disabled>
                        <input type="button" value="Adjuntar imagen">
                    </div>
                </form>
            </div>
            </div>
        </div>
    </header>
</body>
</html>
