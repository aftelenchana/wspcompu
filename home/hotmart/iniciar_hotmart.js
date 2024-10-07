function sendData_porcentaje_ini(){
  $('.notificacion_ini_hotmart').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#porcentaje_ini')[0]);
  $.ajax({
    data: parametros,
    url: 'hotmart/iniciar_hotmart.php',
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
      if (info.noticia ==  'error_privacidad') {
          $('.notificacion_ini_hotmart').html('<div class="alert alert-warning background-warning">'+
          '<strong>Error!</strong> en privacidad '+
          '</div>');

      }
      if (info.noticia ==  'ya_accionado') {
        $('.notificacion_ini_hotmart').html('<div class="alert alert-warning background-warning">'+
        '<strong>Error!</strong> ya se ha realizado esta acción no tienes permiso para realizar esta acción '+
        '</div>');

      }
      if (info.noticia ==  'ok') {
        $('.notificacion_ini_hotmart').html('<div class="alert alert-success background-success">'+
        '<strong>Acción Exitosa!</strong>se ha enviado para el equipo de ventas '+
        '</div>');

      }


      }

    }

  });

}
