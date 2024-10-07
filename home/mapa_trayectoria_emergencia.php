<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }

       $iduser= $_SESSION['id'];

       $codigo_emergencia = $_GET['codigo'];


  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Trayectoria de Emergencias</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
        <link rel="stylesheet" href="localizacion/dist/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="localizacion/mapas/index.css" />

        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/cuenta_bancaria.css?v=2">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/estilos_paginador.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/etiquetas_tabla_ventas.css">

    </head>

    <body>

     <?php
    require 'scripts/cabezera_general.php';

              ?>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Trayectoria de Emergencia</h5>
                                              </div>

                                              <input type="hidden" class="codigo_movimiento" name="codigo_movimiento" id="codigo_movimiento" value="<?php echo $codigo_emergencia ?>">

                                               <div class="row">
                                                 <div class="col">

                                                   <div id="map1" class="map"></div>
                                                 </div>

                                               </div>

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>


              </div>

                </div>
            </div>
        </div>

        <style media="screen">
          #map1{
            position: relative;
            width: 100%;
            height: 400px;
          }

          #map2{
            position: relative;
            width: 100%;
            height: 400px;
          }
          .leaflet-routing-container{
            width: 90%;
          }
          .leaflet-routing-alternatives-container{
            width: 90%;
          }

          div.leaflet-routing-container.leaflet-bar.leaflet-routing-collapsible.leaflet-control {
          width: 60%;
        }
        </style>







                <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
                <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
                <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
                <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

                <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>



                <script type="text/javascript" src="files/bower_components/i18next/i18next.min.js"></script>
                <script type="text/javascript" src="files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
                <script type="text/javascript" src="files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
                <script type="text/javascript" src="files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>


                <script type="text/javascript" src="files/bower_components/modernizr/modernizr.js"></script>
                <script type="text/javascript" src="files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

                <script type="text/javascript" src="files/bower_components/chart.js/dist/Chart.js"></script>

                <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/amcharts.js"></script>
                <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/serial.js"></script>
                <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/light.js"></script>

                <script type="text/javascript" src="files/assets/pages/dashboard/custom-dashboard.min.js"></script>
                <script src="files/assets/js/pcoded.min.js"></script>
                <script src="files/assets/js/horizontal-layout.min.js"></script>
                <script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
                <script type="text/javascript" src="files/assets/js/script.js"></script>


                <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
                <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

                <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
                <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
                <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
                <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
                <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>


                <script src="https://code.responsivevoice.org/responsivevoice.js?key=VObU0Br4"></script>


                <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
                <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
                <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
                <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
                <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
                <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>
                <script src="area_facturacion/busqueda_secuencia.js"></script>
                <script type="text/javascript" src="jquery_chat/mensajes.js"></script>

                <script type="text/javascript" src="transporte/tomar_pedido.js"></script>


                <script type="text/javascript">
                $(document).ready(function() {
                  $('#tabla_facturas').DataTable({
                      "dom": 'Bfrtip',
                      "buttons": [
                          'copy', 'csv', 'excel', 'pdf', 'print'
                      ],
                      "language": {
                          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                      },
                      "order": [],
                      "destroy": true
                  });
                });

                </script>
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
        <script src="localizacion/dist/leaflet-routing-machine.js"></script>
        <script src="localizacion/mapas/Control.Geocoder.js"></script>
        <script src="localizacion/mapas/config.js"></script>
        <script src="transporte/actualizar_ubicacion_emergencia.js"></script>

        <script type="text/javascript">
        $(document).ready(function(){
         var codigo_movimiento = document.getElementById('codigo_movimiento').value;
         var action= 'informacion_movimineto';
          $.ajax({
            url: 'transporte/actualizar_recorrido_emergencia.php',
            type: 'POST',
            data: { codigo_movimiento: codigo_movimiento,action: action }, // Enviando la variable
            async: true,
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);
              if (info.noticia == 'pedido_ocupado_usuario_activo') {
                  // Si la condición se cumple, inicia la actualización del mapa cada 9 segundos

                  var latitude_origen = info.latitude_origen;
                  var longitude_origen = info.longitude_origen;
                  var latitud_raiz = info.latitud_raiz;
                  var longitud_raiz = info.longitud_raiz;


                  function inicializarMapa(id, latLng1, latLng2) {
                    var map = L.map(id);

                    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                      attribution: 'guibis.com'
                    }).addTo(map);

                    var control = L.Routing.control(L.extend(window.lrmConfig, {
                      waypoints: [
                        L.latLng(latLng1),
                        L.latLng(latLng2)
                      ],
                      language: 'es',
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

                          // Crear un icono personalizado
                          var customIcon = L.icon({
                            iconUrl: '/img/guibis.png', // Reemplaza esto con la URL de tu imagen
                            iconSize: [32, 32], // Tamaño del icono
                            iconAnchor: [16, 32], // Punto del icono que corresponderá a la ubicación del marcador
                            popupAnchor: [0, -32] // Punto desde el que se abrirá la ventana emergente
                          });

                          // Crear un marcador con el icono personalizado
                          var marker = L.marker(latLng2, {icon: customIcon}).addTo(map);

                           marker.bindPopup("Punto de destino").openPopup();
                           // Crear un circleMarker para el punto de inicio
                           var startMarker = L.circleMarker(latLng1, {
                             color: 'orange',
                             fillColor: '#f03',
                             fillOpacity: 0.5,
                             radius: 8
                           }).addTo(map);
                           startMarker.bindPopup("Punto de inicio");

                           control.on('routesfound', function(e) {
                               var routes = e.routes;
                               var summary = routes[0].summary;


                                var distancia = (summary.totalDistance / 1000).toFixed(2); // Convertir a km y redondear a 2 decimales
                                var tiempo = Math.floor(summary.totalTime / 60); // Convertir a minutos


                               console.log('Distancia: ' + (summary.totalDistance / 1000).toFixed(2) + ' km');
                               console.log('Tiempo: ' + Math.floor(summary.totalTime / 60) + ' min');

                               var dest = routes[0].inputWaypoints[routes[0].inputWaypoints.length - 1];
                               console.log('Destino:', dest.latLng.toString());

                               $('#distancia').val(distancia);
                               $('#tiempo').val(tiempo);


                           });

                            window.myMap = map;

                  }


                  inicializarMapa('map1', [latitud_raiz,longitud_raiz], [latitude_origen, longitude_origen]);




                  setInterval(function() {
                      actualizarMapa(info.latitude_origen, info.longitude_origen);
                  }, 9000);
              }
            },
            error: function(error){
              console.log(error);
            }
          });
        });

        var control; // Definir control en un ámbito accesible
        function actualizarMapa(latitude_origen, longitude_origen) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;

                    var existingMap = window.myMap;

                    if (existingMap) {
                        // Crear un nuevo marcador y añadirlo al mapa
                        var newMarker = L.marker([latitud, longitud]).addTo(existingMap);

                        // Configurar el popup del marcador
                        newMarker.bindPopup("Estoy aquí").openPopup();

                        // Obtener el nivel de zoom actual del mapa
                        var currentZoom = existingMap.getZoom();


                        // Centrar el mapa en el nuevo punto sin cambiar el nivel de zoom
                        existingMap.setView([latitud, longitud], currentZoom);

                        // Crear la ruta
                        if (control) {
                            // Si ya existe un control de ruta, actualiza los waypoints
                            control.setWaypoints([
                                L.latLng(latitud, longitud),
                                L.latLng(latitude_origen, longitude_origen) // Coordenadas de destino
                            ]);
                        } else {
                            // Si no existe un control de ruta, créalo
                            control = L.Routing.control({
                              waypoints: [
                                  L.latLng(latitud, longitud),
                                  L.latLng(latitude_origen, longitude_origen) // Coordenadas de destino
                              ],
                              language: 'es',
                              routeWhileDragging: true
                          }).addTo(existingMap);


                          control.on('routesfound', function(e) {
                            var rutas = e.routes;
                            if (rutas && rutas.length > 0) {
                              var primeraRuta = rutas[0];
                              var primerPaso = primeraRuta.instructions[0];
                              var direccion = primerPaso.text;
                              var distancia = primerPaso.distance;
                              var mensaje = `En ${distancia} metros, ${direccion.toLowerCase()}`;
                              console.log('Mensaje:', mensaje);
                              hablar(mensaje); // Aquí llamamos a la función para reproducir la dirección con voz
                            }
                          });

                          function hablar(texto) {
                            if (responsiveVoice.voiceSupport()) {
                              responsiveVoice.speak(texto, "Spanish Latin American Female");
                            } else {
                              console.log('La síntesis de voz no está soportada en este navegador.');
                            }
                          }

                        }


                    } else {
                        console.log("El mapa no está definido");
                    }
                });
            } else {
                console.log("Geolocalización no soportada por este navegador.");
            }
        }


        </script>



        <script type="text/javascript">
        (function(){
          $(function(){
            $('.boton_tomar_pedido').on('click',function(){
              var secuencial = $(this).attr('secuencial');

              $('.notificacion_tomar_pedido_transporte').html('');
              $('#tomar_pedido').modal();
              var action = 'info_viaje_pedido';
              $.ajax({
                url:'transporte/tomar_pedido.php',
                type:'POST',
                async: true,
                data: {action:action,secuencial:secuencial},
                 success: function(response){
                   console.log(response);
                     var info = JSON.parse(response);
                     if (info.noticia == 'pedido_vacio') {

                            $('.acciona_btn_tomar_viaje').show(); // Esto mostrará el modal-footer si estaba oculto


                     }

                     if (info.noticia == 'pedido_ocupado') {
                       $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-warning background-warning">'+
                            '<strong>Viaje!</strong> Ya accionado'+
                            '</div>');
                                    $('.acciona_btn_tomar_viaje').hide(); // Esto ocultará el modal-footer

                     }


                 },
                 error:function(error){
                   console.log(error);
                   }

                 });
            });


          });

        }());
        </script>



    </body>
</html>
