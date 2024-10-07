function sendData_generar_codigos(){
  $('.notificacion_generador').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#generar_codigos')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/generar_codigos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response)

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia ==  'insert_ok') {
          $('.notificacion_generador').html('<div class="notifiacion_positiva"><img src="img/reacciones/garrapata.png" alt=""></div>');

      }


      }

    }

  });

}

function sendData_validar_codigo_regalo(){
  $('.noti_regalo').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#codigo_regalo_compra')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/generar_codigos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response)

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia ==  'codigo_correct') {
          $('.noti_regalo').html('<div class="notifiacion_positiva">Revisa tu email<img src="img/reacciones/garrapata.png" width="35px;" alt=""></div>');

      }
      if (info.noticia ==  'no_existe') {
          $('.noti_regalo').html('<div class="notifiacion_positiva"> Codigo Incorrecto <img src="img/reacciones/cerrar.png" width="35px;" alt=""></div>');

      }


      }

    }

  });

}
