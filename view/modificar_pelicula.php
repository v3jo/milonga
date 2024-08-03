<?php
session_start();
if (empty($_SESSION["id"]) || $_SESSION["rol"] != 'admin') {
    header("location: ../inicio.php");
    exit();
}

include "../model/conexion.php";

// Verificar si 'id' está presente en $_GET
if (!isset($_GET["id"])) {
    die("ID no especificado.");
}

$id = $_GET["id"];

// Verificar que 'id' sea un número
if (!is_numeric($id)) {
    die("ID inválido");
}

$sql = $conexion->query("SELECT * FROM peliculas WHERE id=$id");

if (!$sql) {
    die("Error en la consulta: " . $conexion->error);
}

$datos = $sql->fetch_object();
if (!$datos) {
    die("No se encontró ninguna película con el ID proporcionado.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<form class="col-4 p-3 m-auto" method="POST" enctype="multipart/form-data">
    <h5 class="text-center alert alert-secondary">Modificar Película</h5>
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <?php
    include "../controller/controlador_modificar_pelicula.php";
    ?>
    <!--Titulo -->
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($datos->titulo) ?>">
    </div>
    <!--Descripcion -->
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text" class="form-control" name="descripcion" value="<?= htmlspecialchars($datos->descripcion) ?>">
    </div>
    <!--Duracion -->
    <div class="mb-3">
        <label for="duracion" class="form-label">Duración</label>
        <input type="time" class="form-control" name="duracion" value="<?= htmlspecialchars($datos->duracion) ?>">
    </div>
    <!--Clasificacion -->
    <div class="mb-3">
        <label for="clasificacion" class="form-label">Clasificación</label>
        <input type="text" class="form-control" name="clasificacion" value="<?= htmlspecialchars($datos->clasificacion) ?>">
    </div>
    <!--Poster -->
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" name="imagen" ">
        <input type="hidden"  class="form-control" name="nombre" value="<?= htmlspecialchars($datos->imagen) ?>">
    </div>

    <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Modificar Película</button>
    <a href="administrar_pelicula.php" class="btn btn-secondary">Cancelar</a>
</form>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
