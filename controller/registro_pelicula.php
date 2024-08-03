<?php
if (!empty($_POST["btnRegistrar"])) {
    if (!empty($_POST["titulo"]) && !empty($_POST["descripcion"]) && !empty($_POST["duracion"]) && !empty($_POST["clasificacion"]) && !empty($_FILES["imagen"]["tmp_name"])) {
        // Asegurarse de que la conexión a la base de datos esté abierta
        // $conexion = new mysqli('host', 'username', 'password', 'database');
        
        // Sanitizar los inputs
        $titulo = mysqli_real_escape_string($conexion, $_POST["titulo"]);
        $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
        $duracion = mysqli_real_escape_string($conexion, $_POST["duracion"]);
        $clasificacion = mysqli_real_escape_string($conexion, $_POST["clasificacion"]);
        $imagen = $_FILES["imagen"]["tmp_name"];
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $sizeImagen = $_FILES["imagen"]["size"];
        $directorio = "../assets/";

        if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png" || $tipoImagen == "jfif") {
            // Insertar la película
            $sql = $conexion->query("INSERT INTO peliculas (titulo, descripcion, duracion, clasificacion, imagen) VALUES ('$titulo', '$descripcion', '$duracion', '$clasificacion', '')");
            if ($sql) {
                $idRegistro = $conexion->insert_id;
                $ruta = $directorio . $idRegistro . "." . $tipoImagen;

                // Actualizar la ruta de la imagen
                $actualizarImagen = $conexion->query("UPDATE peliculas SET imagen = '$ruta' WHERE id = $idRegistro");

                // Almacenar la imagen
                if (move_uploaded_file($imagen, $ruta)) {
                    echo '<div class="alert alert-success">Película agregada correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger">Error al almacenar la imagen.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Error en el registro.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Formato de imagen no aceptado.</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Todos los campos son obligatorios.</div>';
    }
?>
<script>
    history.replaceState(null, null, location.pathname);
</script>
<?php
}
?>
