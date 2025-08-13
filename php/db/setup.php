<?php
require "config.php";

$paso = "conexion";

try {
    $conn = new PDO("mysql:host=$host:$puerto", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión hecha<br><br>";
    $paso = "crear";
    $sql = "CREATE DATABASE tachibana; USE tachibana; CREATE TABLE usuarios(id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, nickname VARCHAR(100) NOT NULL, descripcion TEXT, auth_cookie TEXT, rol VARCHAR(100) NOT NULL DEFAULT 'user', fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP, ultima_actividad DATETIME); CREATE TABLE posts(id INT AUTO_INCREMENT PRIMARY KEY, id_autor INT NOT NULL, titulo VARCHAR(100) NOT NULL, descripcion TEXT NOT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_autor) REFERENCES usuarios(id) ON DELETE CASCADE); CREATE TABLE tags(id INT AUTO_INCREMENT PRIMARY KEY, usos INT NOT NULL); CREATE TABLE posts_tags(id_post INT PRIMARY KEY NOT NULL, id_tag INT NOT NULL, FOREIGN KEY (id_post) REFERENCES posts(id), FOREIGN KEY (id_tag) REFERENCES tags(id)); INSERT INTO usuarios(username, password, nickname, rol) VALUES ('root', '?', 'admin', 'admin');";
    $conn->exec($sql);
    echo "Base de datos creada con éxito<br>";
    echo "Tu cuenta predeterminada es root.<br>";
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
