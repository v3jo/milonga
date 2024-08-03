<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="css/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
   <!-- <Bootstrap> -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- <"Box-Icon"> -->
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
   <title>Inicio de sesión</title>
</head>

<body>
   <div class="container">
      <div class="login-content">
         <form method="POST" action="" class="container text-center mt-4 alert alert-dark">
            <h2 class="title alert alert-light">BIENVENIDO</h2>
            <h3>Registro de usuarios</h2>
            <?php
            include "../model/conexion.php";
            include "../controller/controlador_registro.php";
            ?>
            <!--Includes-->
            <div class="input-div one">
               <div class="i">
                  <i class="fas fa-user"></i>
               </div>
               <!--Nombre-->
               <div class="div">
                  <h5>Nombre</h5>
                  <input id="nombre" type="text" class="input" name="nombre">
               </div>
            </div>
            <div class="input-div pass">
               <div class="i">
                  <i class="fas fa-lock"></i>
               </div>
               <!--email-->
               <div class="div" >
                  <h5>Correo</h5>
                  <input id="email" type="text" class="input" name="email">
               </div>

               <!--contraseña-->
               <div class="div">
                  <h5>Contraseña</h5>
                  <input type="password" id="input" class="input" name="password">
               </div>
            </div>
            <div class="view">
               <i class='bx bx-low-vision' onclick="vista()" id="verPassword" ></i>
            </div>

            <div class="text-center">
               <a class="font-italic isai5" href="login.php">Inicio de Sesión</a>
            </div>
            <input name="btnRegistroUsuario" class="btn btn-primary" type="submit" value="Registrarse">
            <a class="btn btn-secondary" href="inicio.php">Volver al inicio</a>
         </form>
      </div>
   </div>
<!--<Bootstrap-Script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!--<Box-Icon-Script>-->
   <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>


</body>

</html>