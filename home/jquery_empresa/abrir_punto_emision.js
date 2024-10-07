function sendData_abrir_emision(){
  $('.notificacion_transportista').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#abrir_punto_emision')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/abrir_punto_emision.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_transportista').html('<div class="alert alert-success" role="alert">Punto de Emisión Agregado Correctamente, ve a <a href="transportistas">Aqui</a> para configurarlo!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_transportista').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
