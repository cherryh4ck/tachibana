<?php
    session_start();
    session_unset();
    session_destroy();

    unset($_COOKIE["auth"]);
    unset($_COOKIE["ult_act"]);
    setcookie("auth", "", 1, "/");
    setcookie("ult_act", "", 1, "/"); 
    require "config.php";
    $paso = "conexion";

    try {
        $conn = new PDO("mysql:host=$host:$puerto", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Conexión hecha<br><br>";
        $paso = "crear";
        $password = password_hash("admin", PASSWORD_BCRYPT);
        $sql = "CREATE DATABASE $db; USE $db; CREATE TABLE settings(id INT AUTO_INCREMENT PRIMARY KEY, motd_titu TEXT, motd_desc TEXT, motd_key TEXT); CREATE TABLE usuarios(id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, nickname VARCHAR(100) NOT NULL, descripcion TEXT, auth_cookie TEXT, rol VARCHAR(100) NOT NULL DEFAULT 'user', fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP, ult_act DATETIME, ult_act_activo TINYINT(1) DEFAULT 0); CREATE TABLE categorias(id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(50) NOT NULL UNIQUE); CREATE TABLE posts(id INT AUTO_INCREMENT PRIMARY KEY, id_autor INT NOT NULL, id_categoria INT NOT NULL, titulo VARCHAR(100) NOT NULL, descripcion TEXT NOT NULL, anonimo TINYINT(1) NOT NULL, archivado TINYINT(1) NOT NULL DEFAULT 0, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_autor) REFERENCES usuarios(id) ON DELETE CASCADE, FOREIGN KEY (id_categoria) REFERENCES categorias(id)); CREATE TABLE tags(id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100) NOT NULL, usos INT NOT NULL); CREATE TABLE posts_tags(id INT AUTO_INCREMENT PRIMARY KEY , id_post INT NOT NULL, id_tag INT NOT NULL, FOREIGN KEY (id_post) REFERENCES posts(id), FOREIGN KEY (id_tag) REFERENCES tags(id)); CREATE TABLE posts_comentarios(id INT AUTO_INCREMENT PRIMARY KEY, id_post INT NOT NULL, id_autor INT NOT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP, comentario TEXT NOT NULL, imagen_adjuntada TINYINT(1) NOT NULL, original_poster TINYINT(1) NOT NULL, FOREIGN KEY (id_post) REFERENCES posts(id)); INSERT INTO settings(motd) VALUES ('Bienvenido a Tachibana!'); INSERT INTO usuarios(username, password, nickname, rol) VALUES ('root', '$password', 'admin', 'admin'); INSERT INTO categorias(nombre) VALUES ('any'), ('anime'), ('manga'), ('games'), ('pol'), ('tech'), ('music'), ('movie'), ('coding');";
        $conn->exec($sql);
        echo "Base de datos creada con éxito<br>";
        echo "Tu cuenta predeterminada es root (contraseña: admin).<br>";
        echo "Como no lleva contraseña recuerda cambiarla, lo cual se puede hacer en el perfil.<br><br>";
    }
    catch(PDOException $e){
        if ($paso == "conexion") {
            echo "Hubo un error al conectarse a la base de datos. Asegurate de que los datos estén bien puestos.";
        }
        else{
            echo "La base de datos ya existe, entra a tu perfil y modifica la contraseña.<br>";
            echo "Eres libre de borrar este archivo si es que lo deseas.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup</title>
</head>
<body>
    
</body>
</html>
