<?php
session_start();
if (empty($_SESSION["id"]) || $_SESSION["rol"] != 'user') {
    header("location: login.php");
    exit();
}
include "../model/conexion.php";

// Obtener parámetros de la URL y verificar su validez
$pelicula_id = isset($_GET['pelicula_id']) ? intval($_GET['pelicula_id']) : 0;
$funcion_id = isset($_GET['funcion_id']) ? intval($_GET['funcion_id']) : 0;
$cantidad = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;

// Verificar si la reserva temporal está en la sesión
if (!isset($_SESSION['reserva_temp'])) {
  echo "No se encontraron datos de reserva.";
  exit();
}

$reserva_temp = $_SESSION['reserva_temp'];

// Verificar que la cantidad coincida
$cantidad = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
if ($reserva_temp['cantidad'] != $cantidad) {
    echo "La cantidad de boletos no coincide con la cantidad esperada.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Procesar la información de pago y las butacas seleccionadas
  $butacas_seleccionadas = isset($_POST['butacas']) ? $_POST['butacas'] : [];
  $cardNumber = $_POST['numeroTarjeta'];
  $cardName = $_POST['nombreTarjeta'];
  $expiryDate = $_POST['fechaExpiro'];
  $cvv = $_POST['cvv'];

  

  // Validar la cantidad de butacas seleccionadas
  if (count($butacas_seleccionadas) != $cantidad) {
      echo "La cantidad de butacas seleccionadas no coincide con la cantidad de boletos.";
      exit();
  }

  $conexion->begin_transaction(); // Iniciar la transacción

    try {
        // Insertar en la tabla reservas
        $stmt = $conexion->prepare("INSERT INTO reservas (funcion_id, nombre_cliente, cantidad, id_usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isii', $funcion_id, $_SESSION['nombre'], $cantidad, $_SESSION['id']);
        $stmt->execute();
        $reserva_id = $stmt->insert_id; // Obtener el ID de la reserva insertada
        $stmt->close();

       // Verificar que $_GET['cantidad'] es un arreglo
       if (is_array($reserva_temp['tipos_tickets'])) {
        foreach ($reserva_temp['tipos_tickets'] as $ticket_tipo_id => $cantidad_ticket) {
            if ($cantidad_ticket > 0) {
                $stmt = $conexion->prepare("INSERT INTO detalle_reserva (reserva_id, ticket_tipo_id, cantidad) VALUES (?, ?, ?)");
                $stmt->bind_param('iii', $reserva_id, $ticket_tipo_id, $cantidad_ticket);
                $stmt->execute();
                $stmt->close();
            }
        }
    } else {
        echo "Datos de cantidad inválidos.";
    }

        // Actualizar el estado de las butacas
        foreach ($butacas_seleccionadas as $butaca_id) {
            $stmt = $conexion->prepare("UPDATE butacas SET reservado = 1 WHERE id = ?");
            $stmt->bind_param('i', $butaca_id);
            $stmt->execute();
            $stmt->close();
        }

        $conexion->commit(); // Confirmar la transacción

        echo "Reserva realizada con éxito.";
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir la transacción en caso de error
        echo "Error al realizar la reserva: " . $e->getMessage();
    }
}

// Obtener butacas disponibles
$sql = $conexion->query("SELECT * FROM butacas WHERE funcion_id = $funcion_id");
if (!$sql) {
    die("Error en la consulta de butacas: " . $conexion->error);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/butacas_style.css">

    <title>Seleccionar Butacas</title>
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

    <h1 class="text-center">Seleccionar Butacas</h1>
    <div class="container fondo_pantalla">
        <div class="pantalla">Pantalla</div>
    </div>
    <form method="POST">
        <div class="butacas-container">
            <?php while ($butaca = $sql->fetch_object()): ?>
                <div class="butaca">
                    <?php if ($butaca->reservado == 0): ?>
                        <label>
                            <i class='bx bx-chair'></i>
                            <input type="checkbox" name="butacas[]" value="<?= $butaca->id ?>">
                            <?= $butaca->numero ?>
                        </label>
                    <?php else: ?>
                        <i class='bx bx-chair' style="color: red;"></i>
                        <small>Reservada</small>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

    <h2>Información de Pago</h2>
    <div class="form-group">
        <label for="cardNumber">Número de Tarjeta</label>
        <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" required>
    </div>
    <div class="form-group">
        <label for="cardName">Nombre en la Tarjeta</label>
        <input type="text" class="form-control" id="nombreTarjeta" name="nombreTarjeta" required>
    </div>
    <div class="form-group">
        <label for="expiryDate">Fecha de Expiración</label>
        <input type="text" class="form-control" id="fechaExpiro" name="fechaExpiro" placeholder="MM/AA" required>
    </div>
    <div class="form-group">
        <label for="cvv">CVV</label>
        <input type="text" class="form-control" id="cvv" name="cvv" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-warning">Confirmar Reserva</button>
    </div>
</form>


    <!--Script propio-->
    <script>
   document.addEventListener('DOMContentLoaded', (event) => {
    const maxButacas = <?= $_GET['cantidad'] ?>;
    const checkboxes = document.querySelectorAll('input[name="butacas[]"]');
    let selectedButacas = []; // Array para almacenar las butacas seleccionadas

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const butacaId = this.value;

            if (isChecked && selectedButacas.length >= maxButacas) {
                this.checked = false; // No permitir seleccionar más butacas
                return;
            }

            // Verificar si la butaca está reservada o ya seleccionada
            const isReserved = checkbox.parentElement.querySelector('small') !== null;
            const isSelected = selectedButacas.includes(butacaId);

            if (isChecked && !isReserved && !isSelected) {
                selectedButacas.push(butacaId);
            } else {
                const index = selectedButacas.indexOf(butacaId);
                if (index !== -1) selectedButacas.splice(index, 1);
            }

            // Habilitar o deshabilitar butacas según la cantidad seleccionada
            checkboxes.forEach(cb => {
                const cbId = cb.value;
                const isCbReserved = cb.parentElement.querySelector('small') !== null;
                const isCbSelected = selectedButacas.includes(cbId);

                if (isCbReserved || (selectedButacas.length >= maxButacas && !isCbSelected)) {
                    cb.disabled = true;
                } else {
                    cb.disabled = false;
                }
            });
        });
    });
});

</script>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</body>
</html>
