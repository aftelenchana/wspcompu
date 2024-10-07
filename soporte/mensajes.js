(function(){
  $(function(){
    // Definición de la función que realiza la petición AJAX
    function cargarMensajes() {
      var action = 'buscar_mensajes';
      $.ajax({
        url: '/soporte/mensajes.php',
        type: 'POST',
        async: true,
        data: {action: action},
        success: function(response) {

            //console.log(response);
          if (response != 'error') {
            var info = JSON.parse(response);

            if (info.noticia == 'no_existe_datos') {
              $('.resultado_mensajes_result').html('<div class="d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 200px; background-color: #f8f9fa;">'+
              '<i class="fas fa-comment-alt fa-2x text-secondary mb-3"></i>'+
              '<h4 class="mb-2">No hay conversaciones activas</h4>'+
              '<p class="text-muted">Inicia una conversación para que el soporte responda.</p>'+
              '</div>');
            }
            if (info.noticia == 'existe_chat') {
              $('.resultado_mensajes_result').html(info.respuesta);
              if (info.estado_mensaje  =='Entregado') {
                var audio = new Audio('/home/mutimedia/sonidos/hola.mp3'); // Asegúrate de que la ruta sea correcta
                 audio.play(); // Reproduce el sonido

              }
            }
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    // Variable para almacenar el intervalo, para poder detenerlo más tarde si es necesario
    var intervaloMensajes;

    $('.boton_soporte_tecnico').on('click', function() {
      console.log('hola mundo');
      $('#chatModal').modal();

      // Detiene cualquier intervalo previo para evitar múltiples intervalos corriendo
      clearInterval(intervaloMensajes);

      // Llama a cargarMensajes inmediatamente
      cargarMensajes();

      // Establece un nuevo intervalo para llamar a cargarMensajes cada 5 segundos
      intervaloMensajes = setInterval(cargarMensajes, 5000);
    });

    // Mover esta función al mismo ámbito que cargarMensajes
    function sendData_mensajes_soporte(){
      $('#mensaje_enviar_desde_soporte').val('');
      var parametros = new FormData($('#mensajes_soporte')[0]);
      $.ajax({
        data: parametros,
        url: '/soporte/mensajes.php',
        type: 'POST',
        contentType: false,
        processData: false,
        beforeSend: function(){
        },
        success: function(response){
          console.log(response);

          if (response == 'error') {
            $('.alert_general').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
          } else {
            var info = JSON.parse(response);
            if (info.noticia == 'inser_correct') {
                cargarMensajes(); // Llama a cargarMensajes inmediatamente
                $('#mensaje_enviar_desde_cliente').val('');

                if (info.estado_mensaje  =='Entregado') {
                  var audio = new Audio('/home/multimedia/sonidos/hola.mp3'); // Asegúrate de que la ruta sea correcta
                   audio.play(); // Reproduce el sonido

                }
            }
          }
        },
        error: function(xhr, status, error) {
          console.log(error);
          $('.alert_general').html('<div class="alert alert-danger" role="alert">Error al enviar el mensaje!</div>');
        }
      });
    }

    // Exponer sendData_mensajes_soporte si es necesario llamarla desde fuera, como desde un evento onclick en el HTML.
    window.sendData_mensajes_soporte = sendData_mensajes_soporte;
  });
}());
