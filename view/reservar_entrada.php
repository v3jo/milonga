<?php
session_start();
if (empty($_SESSION["id"]) || $_SESSION["rol"] != 'user') {
    header("location: login.php");
    exit();
}
include "../model/conexion.php";

$pelicula_id = isset($_GET['pelicula_id']) ? intval($_GET['pelicula_id']) : 0;
$funcion_id = isset($_GET['funcion_id']) ? intval($_GET['funcion_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si 'cantidad' está presente en $_POST y es un array
    if (isset($_POST['cantidad']) && is_array($_POST['cantidad'])) {
        // Proceso de reserva
        $id_usuario = $_SESSION['id'];
        $nombre_cliente = $_SESSION['nombre'];

        // Convertir los valores a enteros y calcular la cantidad total
        $cantidad = array_sum(array_map('intval', $_POST['cantidad']));

        /* // Guardar datos en la sesión en lugar de la base de datos
        $_SESSION['reserva_temp'] = [
            'funcion_id' => $funcion_id,
            'nombre_cliente' => $nombre_cliente,
            'cantidad' => $cantidad,
            'id_usuario' => $id_usuario,
            'tipos_tickets' => $_POST['cantidad']
        ]; */

        // En la página donde se hace la reserva:
$_SESSION['reserva_temp'] = [
  'funcion_id' => $funcion_id,
  'nombre_cliente' => $nombre_cliente,
  'cantidad' => $cantidad,
  'id_usuario' => $id_usuario,
  'tipos_tickets' => $_POST['cantidad']  // Almacena el array en la sesión
];

        // Redirigir a seleccionar butacas con todos los parámetros necesarios
        header("Location: seleccionar_butacas.php?pelicula_id=$pelicula_id&funcion_id=$funcion_id&cantidad=$cantidad");
        exit();
    } else {
        echo "Datos de cantidad inválidos.";
        exit();
    }
}

$tipo_entrada = $conexion->query("SELECT * FROM tipo_entrada");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Reservar Entrada</title>
</head>
<body>
    <!-- Navegador -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="inicio.php">Milonga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <?php if (isset($_SESSION["nombre"]) && isset($_SESSION["email"])): ?>
                        <li class="nav-item">
                            <div class="text-white bg-success p-2" id="etiqueta_usuario">
                                <?php echo $_SESSION["nombre"]; ?>
                            </div>
                        </li>
                        <li class="nav-item ms-2">
                            <div class="text-white bg-success p-2">
                                <?php echo $_SESSION["email"]; ?>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="controller/controlador_cerrar_session.php" id="btn_cerrarSesion">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="view/login.php" id="btn_inicioSesion">Iniciar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    
    <form method="POST" class="container form-label alert alert-dark text-dark mt-4 ">
    <h1 class="text-center">Reservar Entrada</h1>
        <h2>Seleccione la cantidad de entradas</h2>
        <?php while ($ticket = $tipo_entrada->fetch_object()): ?>
            <div>
                <label class="form-label"><b><?= $ticket->nombre_tipo ?></b>($<?= $ticket->precio ?>): </label>
                <input class="form-control" type="number" name="cantidad[<?= $ticket->id ?>]" min="0" value="0">
            </div>
        <?php endwhile; ?>
        <button class=" btn btn-warning  mt-2" type="submit">Continuar a la selección de butacas</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>