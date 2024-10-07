function sendData_reenviar_facturas(){
    $('.notificacion_reenviar_facturas').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#reenviar_facturas')[0]);
$.ajax({
data: parametros,
url: 'jquery_facturacion/reenvio.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.notificacion_reenviar_facturas').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'insert_correct') {
    $('.notificacion_reenviar_facturas').html('<div class="alert alert-success" role="alert"> Facturas reenviadas Correctamente</div>');

  }
  if (info.noticia == 'error_insertar') {
    $('.notificacion_reenviar_facturas').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

  }

  }

}

});

}
