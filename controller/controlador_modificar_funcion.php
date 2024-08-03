<?php
if (!empty($_POST["btnSubirFuncion"])) {
    if (!empty($_POST["pelicula_id"]) && !empty($_POST["fecha"]) && !empty($_POST["hora"]) && !empty($_POST["sala"]) && !empty($_POST["id"])) {
        
        // Convertir a entero
        $pelicula_id = intval($_POST["pelicula_id"]);
        $id = intval($_POST["id"]);
        
        // Preparar y limpiar otros datos
        $fecha = mysqli_real_escape_string($conexion, $_POST["fecha"]);
        $hora = mysqli_real_escape_string($conexion, $_POST["hora"]);
        $sala = mysqli_real_escape_string($conexion, $_POST["sala"]);
        
        // Usar una consulta preparada para mayor seguridad
        $stmt = $conexion->prepare("UPDATE funciones SET pelicula_id = ?, fecha = ?, hora = ?, sala = ? WHERE id = ?");
        $stmt->bind_param("isssi", $pelicula_id, $fecha, $hora, $sala, $id);
        
        if ($stmt->execute()) {
            header("location: ../view/administrar_pelicula.php");
        } else {
            echo '<div class="alert alert-danger">Error en la actualización de la función</div>';
        }
        
        $stmt->close();
    } else {
        echo '<div class="alert alert-warning">Todos los campos son obligatorios</div>';
    }
}
?>
