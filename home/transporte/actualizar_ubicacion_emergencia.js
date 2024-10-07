$(document).ready(function() {

    // Función para obtener la ubicación
    function obtenerUbicacion() {
        if (navigator.geolocation) {
            console.log('Intentando obtener la ubicación...');
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.log("Tu navegador no es compatible con la geolocalización.");
        }
    }

    function showPosition(position) {
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;

        console.log("Posición obtenida para guardar en el de emercia : Latitud = " + latitud + ", Longitud = " + longitud);


        var action = 'actualizar_ubicacion_tiempo_real_emergencia';
        $.ajax({
          url:'transporte/actualizar_ubicacion_emergencia.php',
          type:'POST',
          async: true,
          data: {action:action,latitud:latitud,longitud:longitud},
           success: function(response){
             console.log(response);
  



           },
           error:function(error){
             console.log(error);
             }

           });


    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                console.log("El usuario denegó la solicitud de geolocalización.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("La información de ubicación no está disponible.");
                break;
            case error.TIMEOUT:
                console.log("La solicitud para obtener la ubicación ha caducado.");
                break;
            case error.UNKNOWN_ERROR:
                console.log("Ocurrió un error desconocido.");
                break;
        }
    }

    // Obtener la ubicación cuando la página se carga
    obtenerUbicacion();

    // Actualizar la ubicación cada 25 segundos
    setInterval(obtenerUbicacion, 25000); // 25000 milisegundos = 25 segundos
});
