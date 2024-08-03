<?php
if(!empty($_GET["funcion_id"])){
    $id=$_GET["funcion_id"];
    $sql=$conexion->query("DELETE FROM funciones WHERE id=$id");
    if($sql==1){
        echo '<div class="alert alert-success">Función eliminada correctamente.</div>';
    }
}
?>