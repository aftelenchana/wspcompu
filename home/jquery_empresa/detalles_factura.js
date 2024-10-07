function sendData_anular_factura(){
  $('.notificacion_anular_factura').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#anular_factura')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/detalles_factura.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_anular_factura').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_anular_factura').html('<div class="alert alert-success" role="alert">Factura anulada Internamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_anular_factura').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
