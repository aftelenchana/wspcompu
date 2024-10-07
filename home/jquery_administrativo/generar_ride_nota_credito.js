function sendData_generar_ride_nota_credito(){
    $('.alerta_genera_ride_nota_factura').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#generar_ride_nota_credito')[0]);
$.ajax({
data: parametros,
url: 'pdf/generar_ride_nota_credito.php',
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
    $('.alerta_genera_ride_nota_factura').html('<div class="alert alert-success" role="alert">Se ha Generado de Manera Exitosa el Ride de la nota de Crédito, lo puedes descargar   <a download href="facturacion/facturacionphp/comprobantes/nota-credito/pdf/' + info.clave_acceso_nota_credito + '.pdf">Aquí</a>  !</div>');
  }
  if (info.noticia == 'caja_abierta') {
    $('.alerta_genera_ride_nota_factura').html('<div class="alert alert-danger" role="alert">Ya tienes una caja Abierta!</div>');
  }


  }

}

});

}
