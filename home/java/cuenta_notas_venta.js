function sendData_notas_venta(){
  $('.notificacion_general_notas_venta').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#data_notas_venta')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta_notas_venta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_general_notas_venta').html('<div class="alert alert-success" role="alert">Datos Guardados Correctamente!</div>');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_general_notas_venta').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
