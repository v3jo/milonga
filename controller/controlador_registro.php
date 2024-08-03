<?php
session_start();

if (!empty($_POST["btnRegistroUsuario"])){
    if (!empty($_POST["nombre"])){
        if (!empty($_POST["email"])){
            if (!empty($_POST["password"])){
                $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
                $email = mysqli_real_escape_string($conexion, $_POST["email"]);
                $password = mysqli_real_escape_string($conexion, $_POST["password"]);

                $sql = $conexion->query("INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')");

                if ($sql == 1) {
                    header("location: ../view/inicio.php");
                } else {
                    echo '<div class="alert alert-danger">Error en el registro</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Falta llenar el campo password</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Falta llenar el campo email</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Falta llenar el campo nombre</div>';
    }
} 
            
?>


<!-- if (!empty($_POST["nombre"]) and !empty($_POST["password"])) {
        $nombre=$_POST["nombre"];
        $password=$_POST["password"];
        $sql=$conexion->query("SELECT * FROM usuarios WHERE nombre='$nombre' and password='$password'");
        if ($datos=$sql->fetch_object()) {
            $_SESSION["id"]=$datos->id;
            $_SESSION["nombre"]=$datos->nombre;
            $_SESSION["email"]=$datos->email;
            $_SESSION["rol"] = $datos->rol;
            header("location: ../view/administrar_pelicula.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Acceso denegado</div>";
        }
        
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    } -->