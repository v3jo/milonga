<?php
session_start();
if (empty($_SESSION["id"]) || $_SESSION["rol"] != 'admin') {
    header("location: inicio.php");
    exit();
}
ob_start(); // Inicia el almacenamiento en búfer de salida
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>crud en php</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Box-Icon-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!--Data-Table-->
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <!--Navegador-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Milonga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <div class="text-white bg-success p-2">
                            <?php echo $_SESSION["nombre"]; ?>
                        </div>
                    </li>
                    <li class="nav-item ms-2">
                        <div class="text-white bg-success p-2">
                            <?php echo $_SESSION["email"]; ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/controlador_cerrar_session.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--Cartelera peliculas-->
    <h1 class="text-center p-2">Cartelera de Peliculas</h1>
    <div class="container-fluid row">
        <form class="col-4 p-3" method="POST" enctype="multipart/form-data">
            <h5 class="text-center alert alert-secondary">Subir Nueva Pelicula</h5>
            <div class="container">
                <?php
                include "../model/conexion.php";
                include "../controller/registro_pelicula.php";
                include "../controller/eliminar_pelicula.php";
                ?>
            </div>
            <!--Titulo -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Titulo</label>
                <input type="text" class="form-control" name="titulo">
            </div>
            <!--Descripcion -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Descripcion</label>
                <input type="text" class="form-control" name="descripcion">
            </div>
            <!--Duracion -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Duracion</label>
                <input type="time" class="form-control" name="duracion">
            </div>
            <!--Clasificacion -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Clasificacion</label>
                <input type="text" class="form-control" name="clasificacion">
            </div>
            <!--Poster -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen">
            </div>
            <button type="submit" class="btn btn-primary" name="btnRegistrar" value="ok">Subir Pelicula</button>
        </form>
        <div class="col-8 p-4">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Duracion</th>
                        <th scope="col">Clasificacion</th>
                        <th scope="col">Poster</th>
                        <th scope=""></th>
                    </tr>
                </thead class="bg-info">
                <tbody>
                    <?php
                    include "../model/conexion.php";
                    $sql = $conexion->query("SELECT * FROM peliculas");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id ?></td>
                            <td><?= $datos->titulo ?></td>
                            <td><?= $datos->descripcion ?></td>
                            <td><?= $datos->duracion ?></td>
                            <td><?= $datos->clasificacion ?></td>
                            <td>
                                <img width="80" src="<?= $datos->imagen ?>" alt="">
                            </td>
                            <td>
                                <a href="modificar_pelicula.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning"><i class='bx bxs-edit bx-md'></i></a>
                                <a onclick="return eliminar()" href="administrar_pelicula.php?pelicula_id=<?= $datos->id ?>" class="btn btn small btn-danger"><i class='bx bxs-trash bx-md'></i></a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--Funciones-->
    <!--Gestor de Funciones-->
    <h1 class="text-center p-2">Gestor de Funciones</h1>
    <div class="container-fluid row">
        <form class="col-4 p-3" method="POST">
            <h5 class="text-center alert alert-secondary">Programar nueva Funcion</h5>
            <div class="container">
                <?php
                include "../model/conexion.php";
                include "../controller/controlador_subir_funcion.php";
                include "../controller/controlador_eliminar_funcion.php";
                ?>
            </div>
            <!--Pelicula-id -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Pelicula ID</label>
                <input type="number" class="form-control" name="pelicula_id">
            </div>
            <!--Fecha -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha">
            </div>
            <!--Hora -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Hora</label>
                <input type="time" class="form-control" name="hora">
            </div>
            <!--Sala -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Sala</label>
                <input type="text" class="form-control" name="sala">
            </div>
            <button type="submit" class="btn btn-primary" name="btnSubirFuncion" value="ok">Subir Funcion</button>
        </form>
        <div class="col-8 p-4">
            <table class="table" id="myTable2">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Pelicula_id</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Sala</th>
                        <th scope=""></th>
                    </tr>
                </thead class="bg-info">
                <tbody>
                    <?php
                    include "../model/conexion.php";
                    $sql = $conexion->query("SELECT * FROM funciones");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id ?></td>
                            <td><?= $datos->pelicula_id ?></td>
                            <td><?= $datos->fecha ?></td>
                            <td><?= $datos->hora ?></td>
                            <td><?= $datos->sala ?></td>
                            <td>
                                <a href="modificar_funcion.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning"><i class='bx bxs-edit bx-md'></i></a>
                                <a onclick="return eliminar2()" href="administrar_pelicula.php?funcion_id=<?= $datos->id ?>" class="btn btn small btn-danger"><i class='bx bxs-trash bx-md'></i></a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--Scripts propios-->
    <script>
        function eliminar() {
            let respuesta = confirm("Estas seguro que deseas eliminar la pelicula?")
            return respuesta
        }

        function eliminar2() {
            let respuesta = confirm("Estas seguro que deseas eliminar la pelicula?")
            return respuesta
        }
    </script>
    <!--SCRIPTS EXTERNOS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        //Tabla de Peliculas
        $(document).ready(function () {
            $('#myTable').DataTable({
                // Opciones de configuración aquí
                "paging": true,        // Habilita la paginación
                "searching": true,     // Habilita la búsqueda
                "ordering": true,      // Habilita el ordenamiento de columnas
                "info": true,          // Muestra la información de la tabla
                "lengthChange": false, // Oculta la opción de cambiar el número de registros por página
                "pageLength": 7       // Número de registros por página
            });
        });

        //Tabla de Funciones
        $(document).ready(function () {
            $('#myTable2').DataTable({
                // Opciones de configuración aquí
                "paging": true,        // Habilita la paginación
                "searching": true,     // Habilita la búsqueda
                "ordering": true,      // Habilita el ordenamiento de columnas
                "info": true,          // Muestra la información de la tabla
                "lengthChange": false, // Oculta la opción de cambiar el número de registros por página
                "pageLength": 7       // Número de registros por página
            });
        });

    </script>
</body>
</html>

<?php ob_end_flush(); // Enviar el búfer de salida al navegador ?>
