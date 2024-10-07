$(document).ready(function(){
 var codigo_movimiento = document.getElementById('codigo_movimiento').value;
 var action= 'informacion_movimineto';
  $.ajax({
    url: 'transporte/actualizar_recorrido.php',
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

                // Enviar las coordenadas al servidor
                var codigo_movimiento = document.getElementById('codigo_movimiento').value;
                var action = 'ingresar_coordenaas_transporte';
                $.ajax({
                    url: 'transporte/actualizar_recorrido.php',
                    type: 'POST',
                    data: {
                        latitud: latitud,
                        longitud: longitud,
                        action: action,
                        codigo_movimiento:codigo_movimiento
                    },
                    success: function(response) {
                      console.log(response);
                        var info = JSON.parse(response);
                        if (info.noticia == 'habilitar_recogida_pedido_cocina') {
                          $('.acciona_btn_tomar_viaje').show(); // Esto mostrará el modal-footer si estaba oculto
                          $('#action_modal_entrega').val('recoger_predido_cocina');
                            $('.acciona_btn_tomar_viaje').html('Recoger del Establecimiento');
                        }

                        if (info.noticia == 'habilitar_entrega_final') {
                          $('.acciona_btn_tomar_viaje').show(); // Esto mostrará el modal-footer si estaba oculto
                          $('#action_modal_entrega').val('entregar_pedido_final');
                            $('.acciona_btn_tomar_viaje').html('Entregar el Producto');
                        }
                        if (info.noticia == 'entregado_finalizado') {
                          $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-warning background-warning">'+
                               '<strong>Este viaje!</strong> Ya haz Finalizado'+
                               '</div>');
                                       $('.acciona_btn_tomar_viaje').hide(); // Esto ocultará el modal-footer
                        }

                    },
                    error: function(error) {
                        console.log('Error al enviar las coordenadas', error);
                    }
                });
            } else {
                console.log("El mapa no está definido");
            }
        });
    } else {
        console.log("Geolocalización no soportada por este navegador.");
    }
}
