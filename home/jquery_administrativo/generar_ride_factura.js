function sendData_generar_ride_factura(){
    $('.alerta_genera_ride_factura').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#generar_ride_factura')[0]);
$.ajax({
data: parametros,
url: 'pdf/generar_ride_factura.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.alerta_iniciar_caja').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'ride_exitoso') {
    $('.alerta_genera_ride_factura').html('<div class="alert alert-success" role="alert">Se ha Generado de Manera Exitosa el Ride lo puedes descargar   <a download href="facturacion/facturacionphp/comprobantes/pdf/' + info.clave_acceso_factura + '.pdf">Aquí</a>  !</div>');
  }
  if (info.noticia == 'caja_abierta') {
    $('.alerta_genera_ride_factura').html('<div class="alert alert-danger" role="alert">Ya tienes una caja Abierta!</div>');
  }


  }

}

});

}
