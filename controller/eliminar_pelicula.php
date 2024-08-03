<?php
if(!empty($_GET["pelicula_id"])){
    $id=$_GET["pelicula_id"];
    $sql=$conexion->query("DELETE FROM peliculas WHERE id=$id");
    if($sql==1){
        echo '<div class="alert alert-success">Pelicula eliminada correctamente.</div>';
    }
}
?>