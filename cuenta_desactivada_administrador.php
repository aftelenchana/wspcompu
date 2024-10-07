<?php


ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8'); //linea a colocar
      $user_in = $_GET['user_in'];
      $user = $_GET['user'];

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cuenta Desactivada</title>
  <meta property="og:locale" content="es_ES" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Guibis.com" />
  <meta property="og:description" content="Guibis.com un sitio donde puedes comprar por internet con seguridad" />
  <meta property="og:image" content="https://www.guibis.com/home/img/reacciones/guibis.png">
  <meta property="og:url" content="https://www.guibis.com" />
  <link rel="icon" href="/img/guibis.png">
  <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estilos_paginador.css">
  <link rel="stylesheet" href="./css/pie_pagina.css">
  <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/categorias_productos.css">
  <link rel="stylesheet" href="./css/index.css?v=2">
  <link rel="stylesheet" href="./css/productos_empresa.css?v=2">
  <link rel="stylesheet" href="./css/estilos.css?v=2">
  <link rel="stylesheet" href="./estilos/navidad.css?v=2">
  <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas.css">
  <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estrellas2.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin="" />
<link rel="stylesheet" type="text/css" href="home/files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="/estilos/api_productos.css?v=2">
<link rel="stylesheet" href="/estilos/consulta_ruc.css?v=2">
<link rel="stylesheet" href="home/estiloshome/load.css">
<link rel="stylesheet" href="./soporte/estilos.css?v=2">





</head>
<body style="padding: 0;margin: 0;">


  <?php
   require 'scripts/categorias.php';
   ?>



   <div class="container py-5">
       <div class="row">
           <div class="col-md-12">
               <div class="card">
                   <div class="card-header bg-danger text-white">
                       <h4 class="card-title"><i class="fas fa-exclamation-circle"></i> Información de Acceso</h4>
                   </div>
                   <div class="card-body">
                       <h5>Información del Administrador</h5>
                       <?php

                       $query_user_in = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$user_in");
                       $data_user_in  = mysqli_fetch_array($query_user_in);
                       $nombres_user_in   = $data_user_in['nombres'];
                       $apellidos_user_in = $data_user_in['apellidos'];
                       $email_user_in         = $data_user_in['email'];
                       $fecha_creacion_user_inf         = $data_user_in['fecha_creacion'];
                       $esatdo_cuenta_user_in         = $data_user_in['estado_cuenta'];
                       $fecha_suspencion_user_in         = $data_user_in['fecha_suspencion'];
                       $detalle_suspencion_in         = $data_user_in['detalle'];
                       if ($esatdo_cuenta_user_in == '1') {
                         $esatdo_cuenta_user_in = 'ACTIVADA';
                         // code...
                       }
                       if ($esatdo_cuenta_user_in == '0') {
                         $esatdo_cuenta_user_in = 'SUSPENDIDA';
                         // code...
                       }
                        ?>
                       <p><strong>Nombre del Administrador:</strong><?php echo $nombres_user_in ?> <?php echo $apellidos_user_in ?></p>
                       <p><strong>Fecha de Creación de la Cuenta:</strong> <?php echo $fecha_creacion_user_inf ?></p>
                       <p><strong>Estado Cuenta:</strong> <?php echo $esatdo_cuenta_user_in ?></p>
                       <p><strong>Email:</strong> <?php echo $email_user_in ?></p>
                       <?php if ($esatdo_cuenta_user_in == 'SUSPENDIDA'): ?>
                         <p><strong>Fecha Suspención:</strong> <?php echo $fecha_suspencion_user_in ?></p>
                         <p><strong>Detalle Suspención:</strong> <?php echo $detalle_suspencion_in ?></p>

                       <?php endif; ?>


                       <hr>
                       <h5>Información de la Cuenta que Intenta Acceder</h5>

                       <?php

                       $query_user = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$user");
                       $data_user  = mysqli_fetch_array($query_user);
                       $nombres_user   = $data_user['nombres'];
                       $apellidos_user = $data_user['apellidos'];
                       $email_user         = $data_user['email'];
                       $fecha_creacion_user         = $data_user['fecha_creacion'];
                       $esatdo_cuenta_user         = $data_user['estado_cuenta'];
                       $fecha_suspencion_user         = $data_user['fecha_suspencion'];
                       $detalle_suspencion         = $data_user['detalle'];
                       if ($esatdo_cuenta_user == '1') {
                         $esatdo_cuenta_user = 'ACTIVADA';
                         // code...
                       }
                       if ($esatdo_cuenta_user == '0') {
                         $esatdo_cuenta_user = 'SUSPENDIDA';
                         // code...
                       }
                        ?>
                       <p><strong>Nombre del Administrador:</strong><?php echo $nombres_user ?> <?php echo $apellidos_user ?></p>
                       <p><strong>Fecha de Creación de la Cuenta:</strong> <?php echo $fecha_creacion_user ?></p>
                       <p><strong>Estado Cuenta:</strong> <?php echo $esatdo_cuenta_user ?></p>
                       <p><strong>Email:</strong> <?php echo $email_user ?></p>
                       <?php if ($esatdo_cuenta_user == 'SUSPENDIDA'): ?>
                         <p><strong>Fecha Suspención:</strong> <?php echo $fecha_suspencion_user ?></p>
                         <p><strong>Detalle Suspención:</strong> <?php echo $detalle_suspencion ?></p>

                       <?php endif; ?>
                   </div>
               </div>
           </div>
       </div>
   </div>







   <div id="myMap" style="height:300px"></div>





   <?php
       require "scripts/footer.php";

    ?>
    <?php
    require "soporte/modal.php";

     ?>
       <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>

  <script type="text/javascript" src="https://guibis.com/home/jquery/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
  <script src="https://guibis.com/home/main.js"></script>
  <script src="./js/categorias.js"></script>
    <script src="./soporte/mensajes.js"></script>

    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
      integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
      crossorigin=""></script>
    <script type="text/javascript" src="home/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


      <script src="java/consulta_ruc.js"></script>

    <script type="text/javascript">
    let myMap = L.map('myMap').setView([51.505, -0.09], 13)

    L.tileLayer(`https://{s}.tile.osm.org/{z}/{x}/{y}.png`, {
    maxZoom: 18,
    }).addTo(myMap);
    myMap.panTo(new L.LatLng(-1.2484,-78.6133 ))
    L.marker([-1.2484, -78.6133]).addTo(myMap)

    </script>


</body>
</html>
<?php
ob_end_flush();
?>
