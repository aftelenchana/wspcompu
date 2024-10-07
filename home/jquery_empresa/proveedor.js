function sendDataedit_nuevo_proveedor(){
    $('.alerta_nuevoproveedor').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#agregar_proveedor')[0]);
$.ajax({
data: parametros,
url: 'jquery_empresa/proveedor.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.alert_general').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'insert_correct') {
    $('.alerta_nuevoproveedor').html('<div class="alert alert-success background-success">'+
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
    '<i class="icofont icofont-close-line-circled text-white"></i>'+
    '</button>'+
    '<strong>Proveedor!</strong> Agregado Correctamente'+
    '</div>');

  }
  if (info.noticia == 'error') {
    $('.alerta_nuevoproveedor').html('<div class="alert alert-danger background-danger" role="alert">Error en el servidor!</div>');

  }

  }

}

});

}
