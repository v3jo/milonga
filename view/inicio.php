<?php
session_start();

ob_start(); // Inicia el almacenamiento en búfer de salida
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Películas en Cartelera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
   
    <!-- Navegador -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Milonga</a>
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
                <a class="nav-link" href="../controller/controlador_cerrar_session.php" id="btn_cerrarSesion">Cerrar Sesión</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="login.php" id="btn_inicioSesion">Iniciar Sesión</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
   
    <!-- Header-Slider -->
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../assets/portada_1.jfif" class="d-block w-100" alt="Portada">
        </div>
        <div class="carousel-item">
          <img src="../assets/portada_2.jfif" class="d-block w-100" alt="Portada">
        </div>
        <div class="carousel-item">
          <img src="../assets/portada_3.jfif" class="d-block w-100" alt="Portada">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Section Funciones -->
<h2 class="text-center mt-3 mb-3">Películas en Cartelera</h2>
<div class="container d-flex flex-wrap">
    <?php
    include "../model/conexion.php";
    $sql = $conexion->query("SELECT * FROM peliculas");
    while ($datos = $sql->fetch_object()){ ?>
        <!-- Card para cada película -->
        <div class="card mb-3" style="max-width: 540px; margin: 10px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $datos->imagen ?>" class="img-fluid rounded-start" alt="Poster_Pelicula">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $datos->titulo ?></h5>
                        <p class="card-text"><?= $datos->descripcion ?></p>
                        <div class="container d-flex justify-content-evenly">
                            <div class="d-flex flex-column">
                                <p class="card-text"><small class="text-body-secondary">Duración: <?= $datos->duracion ?></small></p>
                                <p class="card-text"><small class="text-body-secondary">Clasificación: <?= $datos->clasificacion ?></small></p>
                            </div>
                            <div class="d-flex flex-column">
                                <?php
                                $sql_funciones = $conexion->query("SELECT id, fecha, hora FROM funciones WHERE pelicula_id={$datos->id}");
                                while ($funcion = $sql_funciones->fetch_object()) { ?>
                                    <p class="card-text"><small class="text-body-secondary">Fecha: <?= $funcion->fecha ?></small></p>
                                    <p class="card-text"><small class="text-body-secondary">Hora: <?= $funcion->hora ?></small></p>
                                    <a href="reservar_entrada.php?pelicula_id=<?= $datos->id ?>&funcion_id=<?= $funcion->id ?>" class="btn btn-warning">Reservar</a>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>
</div>
 

    <script src="controller/hidden_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


<?php ob_end_flush(); // Enviar el búfer de salida al navegador ?>
