function sendData_porcentaje_ini(){
  $('.notificacion_ini_hotmart').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#porcentaje_ini')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/porcentaje_ini2.php',
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
          $('.notificacion_ini_hotmart').html('<img src="img/reacciones/cerrar.png" alt="">');

      }
      if (info.noticia ==  'ya_accionado') {
          $('.notificacion_ini_hotmart').html('<img src="img/reacciones/cerrar.png" alt=""><p style="background: #D61212;padding: 5px;">Este producto ya se encuentra Activo </p> ');

      }
      if (info.noticia ==  'ok') {
          $('.notificacion_ini_hotmart').html('  <img src="img/reacciones/garrapata.png" alt="">');

      }


      }

    }

  });

}
