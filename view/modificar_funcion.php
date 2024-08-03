<?php
session_start();
if (empty($_SESSION["id"]) || $_SESSION["rol"] != 'admin') {
    header("location: inicio.php");
    exit();
}
?>

<?php

include "../model/conexion.php";

$id=$_GET["id"];
if (!is_numeric($id)){
    die("ID inválido");
}

 $sql=$conexion->query("SELECT * FROM funciones WHERE id=$id");

 if(!$sql){
    die("error en la consulta:" . $conexion->error);
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Box-Icon-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<form class="col-4 p-3 m-auto" method="POST">
    <h5 class="text-center alert alert-secondary">Modificar Funcion</h5>
    <input type="hidden" name="id" value="<?= $_GET["id"]?>">
      <?php
      include "../controller/controlador_modificar_funcion.php";
      while($datos=$sql->fetch_object()){ ?>
      <!--Titulo -->
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Pelicula_id</label>
    <input type="number" class="form-control" name="pelicula_id" value="<?= $datos->pelicula_id?>">
  </div>
<!--Descripcion -->
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Fecha</label>
    <input type="text" class="form-control" name="fecha" value="<?= $datos->fecha?>">
  </div>
  <!--Duracion -->
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Hora</label>
    <input type="time" class="form-control" name="hora" value="<?= $datos->hora?>">
  </div>
  <!--Clasificacion -->
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Sala</label>
    <input type="text" class="form-control" name="sala" value="<?= $datos->sala?>">
  </div>
      <?php };
      ?>

  
  <button type="submit" class="btn btn-primary" name="btnSubirFuncion" value="ok">Modificar Funcion</button>
  <a href="administrar_pelicula.php" class="btn btn-secondary">Cancelar</a>
</form>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>