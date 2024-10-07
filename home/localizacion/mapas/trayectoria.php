
<?php

ob_start();
include "../../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();
      if (empty($_SESSION['active'])) {
        header('location:/');

      }else {
        $iduser= $_SESSION['id'];
        $query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$iduser");
        $result=mysqli_fetch_array($query);
        $estado_transportista = $result['estado_transportista'];
        $nombres           = $result['nombres'];
        $apellidos           = $result['apellidos'];
        $email_usuario         = $result['email'];
        $direccion         = $result['direccion'];
        $codigo_sri        = $result['codigo_sri'];
        $apellidos         = $result['apellidos'];
        $img_logo          = $result['img_logo'];
        $img_qr            = $result['img_qr'];
        $celular            = $result['celular'];
        $telefono           = $result['telefono'];
        $numero_identidad   = $result['numero_identidad'];
        $id_e            = $result['id_e'];
        $mi_leben            = $result['mi_leben'];

        //PARA SACAR LA INFORMACION DE LA TRAYECTORIA
        $id_viaje = $_GET['id_viaje'];
        $query_viaje = mysqli_query($conection, "SELECT * FROM ventas
          INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
          WHERE ventas.id = $id_viaje");
        $result_viaje = mysqli_fetch_array($query_viaje);
        $latitud1    = $result_viaje['latitud1'];
        $longitud1   = $result_viaje['longitud1'];
        $latitud2    = $result_viaje['latitud2'];
        $longitud2   = $result_viaje['longitud2'];
        $qr_venta    = $result_viaje['qr_venta'];
        $ciudad_1    = $result_viaje['ciudad_1'];
        $provincia_1 = $result_viaje['provincia_1'];
        $ciudad_2    = $result_viaje['ciudad_2'];
        $provincia_2 = $result_viaje['provincia_2'];
        $direccion_1 = $result_viaje['direccion_1'];
        $direccion_2 = $result_viaje['direccion_2'];
        $categorias = $result_viaje['categorias'];
        $subcategorias = $result_viaje['subcategorias'];
        $estado_transporte = $result_viaje['estado_transporte'];
        $precio_transporte = $result_viaje['precio_transporte'];
      }
  ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mapa Trayectoria</title>
    <link rel="icon" href="/img/guibis.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="estilos/activar_cuenta.css?v=1" rel="stylesheet"/>
    <link href="estilos/load.css?v=1" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="estilos/load.css?v=1" rel="stylesheet"/>
    <link href="/estilos/footer.css" rel="stylesheet" />
      <link rel="stylesheet" href="/home/estilos/mapa_trayectoria.css?v=2" />
    <style media="screen">
    .results {
        background-color: white;
        opacity: 0.8;
        position: absolute;
        top: 12px;
        right: 12px;
        width: 320px;
        height: 480px;
        overflow-y: scroll;
    }
    </style>
</head>
<body>
        <?php require "../../scripts/menu2.php" ?>

          <div class="tirulo_activar_cuenta">
              <h3>Trayectioria de Viaje</h3>
          </div>
          <div class="row estg_entrega">
            <div class="col">
              <h3>Acercate lo mas pósible al punto de entrega</h3>
              <p>El sistema detecta la proximidad de entrega, es decir acercate lo mas que puedas para que se active el sistema de entrega del producto.</p>
            </div>
            <div class="col">
          <a target="_blank" class="btn btn-warning" href="proceso_final?id_viaje=<?php echo $id_viaje ?>">Ir a consola de entrega Final</a>
          <p>Una vez que ya estes con el usuario sigue a consola para que puedas finalizar la entrega.</p>
            </div>
          </div>
  <div class="">
      <div id="map"style="height:300px" ></div>
  </div>
  <?php require "../../../scripts/footer.php" ?>
     <script src="/home/java/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script src="../dist/leaflet-routing-machine.js"></script>
    <script src="Control.Geocoder.js"></script>
    <script src="config.js"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <script type="text/javascript">
    var map = L.map('map');

    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {

    }).addTo(map);

    var control = L.Routing.control(L.extend(window.lrmConfig, {
      waypoints: [
        L.latLng(-1.2484, -78.6133),
        L.latLng(-1.2484, -78.6133)
      ],
      geocoder: L.Control.Geocoder.nominatim(),
      routeWhileDragging: true,
      reverseWaypoints: true,
      showAlternatives: true,
      altLineOptions: {
        styles: [
          {color: 'black', opacity: 0.15, weight: 9},
          {color: 'white', opacity: 0.8, weight: 6},
          {color: 'blue', opacity: 0.5, weight: 2}
        ]
      }
    })).addTo(map);

    L.Routing.errorControl(control).addTo(map);



    </script>
    <script type="text/javascript">

      (function(){
        $(function(){
          $('.btn-ventana').on('click',function(){
            $('.exampleModalLong').modal();
            if (navigator.geolocation) {
              $('.botones_accion').html(' <div class="notificacion_negativa">'+
                '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
              '</div>');
               navigator.geolocation.getCurrentPosition(showPosition);

             }else {
               x.innerHTML = "No es compatible tu navegador";
             }
             function showPosition(position){
              $('#latitude_add').val(position.coords.latitude);
              $('#longitude_add').val(position.coords.longitude);
              console.log(position.coords.latitude)
              console.log(position.coords.longitude)

             }
          });


        });

      }());
    </script>
</body>
</html>
