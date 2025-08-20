<?php
    require "../db/config.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_SESSION["cuenta_id"])){
            $comentario_id = $_POST["id_comentario"];
            $comentario_autor_id = $_SESSION["cuenta_id"];
            $comentario_texto = nl2br(htmlspecialchars($_POST["comentario"]));
            $comentario_anonimo = $_POST["anonimo"];
            // desarrollar imagen adjuntada
            $comentario_imagen = 0;
            if ($comentario_anonimo == "on"){
                $comentario_autor_id = 0;
            }   

            try{
                $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $conn->prepare("INSERT INTO posts_comentarios(id_post, id_autor, comentario, imagen_adjuntada) VALUES (?, ?, ?, ?);");
                $sql->execute([$comentario_id, $comentario_autor_id, $comentario_texto, $comentario_imagen]);
                header("Location: ../../post.php?id=$comentario_id");
            }
            catch (PDOException $e){
                header("Location: ../../error.php?id=9");
                exit();
            }
        }
        else{
            header("Location: ../../index.php");
        }
    }
    else{
        header("Location: ../../index.php");
    }
?>
