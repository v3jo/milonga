<?php
session_start();

if (!empty($_POST["btnLogin"])){
    if (!empty($_POST["nombre"]) and !empty($_POST["password"])) {
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
    }
    
}
?>