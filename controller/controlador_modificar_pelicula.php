<?php
if (!empty($_POST["btnEditar"])) {
    if (!empty($_POST["titulo"]) && !empty($_POST["descripcion"]) && !empty($_POST["duracion"]) && !empty($_POST["clasificacion"]) && !empty($_FILES["imagen"]["tmp_name"])) {
        $id = mysqli_real_escape_string($conexion, $_POST["id"]);
        $nombre = $_POST["nombre"];

        // Datos de la imagen
        $imagen = $_FILES["imagen"]["tmp_name"];
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $directorio = "../assets/";

        if (is_file($imagen)) {
            if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png" || $tipoImagen == "jfif") {
                // Eliminamos la imagen anterior
                if (is_file($nombre)) {
                    unlink($nombre);
                }

                $ruta = $directorio . $id . "." . $tipoImagen;
                // Almacenar imagen
                if (move_uploaded_file($imagen, $ruta)) {
                    $editar = $conexion->query("UPDATE peliculas SET imagen='$ruta' WHERE id=$id");

                    if ($editar) {
                        echo '<div class="alert alert-success">Imagen actualizada correctamente.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error al editar imagen.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Error al subir la imagen al servidor.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Solo se aceptan formatos jpg/jpeg/png.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Debes seleccionar una imagen.</div>';
        }

        // Sanitizar y actualizar los demás campos
        $titulo = mysqli_real_escape_string($conexion, $_POST["titulo"]);
        $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
        $duracion = mysqli_real_escape_string($conexion, $_POST["duracion"]);
        $clasificacion = mysqli_real_escape_string($conexion, $_POST["clasificacion"]);

        $sql = $conexion->query("UPDATE peliculas SET titulo='$titulo', descripcion='$descripcion', duracion='$duracion', clasificacion='$clasificacion' WHERE id=$id");
        if ($sql) {
            echo '<div class="alert alert-success">Película modificada correctamente.</div>';
        } else {
            echo '<div class="alert alert-danger">Error en el registro.</div>';
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
