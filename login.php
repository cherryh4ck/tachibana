<?php
    require "php/db/config.php";

    session_start();
    if (isset($_SESSION["cuenta_usuario"])){
        header("Location: index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $username = trim($_POST["user"]);
        $password = $_POST["password"];

        if (empty($user) || empty($password)){
            exit();
        }
        try{
            $conn = new PDO("mysql:host=$host:$puerto;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
            $sql->execute([$username]);
            $fetch = $sql->fetch(PDO::FETCH_ASSOC);

            if ($fetch && password_verify($password, $fetch["password"])){
                echo "Logueado con exito!";
                $_SESSION["cuenta_id"] = $fetch["id"];
                $_SESSION["cuenta_usuario"] = $fetch["username"];
                header("Location: index.php");
            }
            else{
                echo "Datos incorrectos.";
            }
        }
        catch(PDOException $e){
            echo $e;
            // mostrar error de manera más visual (base de datos caida)
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles/styles.css">
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
    <div class="contenido-menu">
        <form action="login.php" method="post">
            <p id="texto-centrado">Iniciar sesión</p>
            <input type="text" name="user" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar sesión">
        </form>
        <p id="registrate">¿No tenés cuenta? Registrate <a href="register.php">acá</a></p>
    </div>
</body>
</html>
