function sendDataedit_iniciar_caja(){
    $('.alerta_iniciar_caja2').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#add_iniciar_caja')[0]);
$.ajax({
data: parametros,
url: 'jquery_administrativo/caja.php',
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
  if (info.noticia == 'insert_correct') {
    $('.alerta_iniciar_caja2').html('<div class="alert alert-success" role="alert">Caja Abierta Correctamente!</div>');
  }
  if (info.noticia == 'caja_abierta') {
    $('.alerta_iniciar_caja2').html('<div class="alert alert-danger" role="alert">Ya tienes una caja Abierta!</div>');
  }


  }

}

});

}


function sendDatacerrar_caja (){
    $('.alerta_cerrar_caja').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#add_cerrar_caja')[0]);
$.ajax({
data: parametros,
url: 'jquery_administrativo/caja.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.alerta_cerrar_caja').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'insert_correct') {
    $('.alerta_cerrar_caja').html('<div class="alert alert-success" role="alert">Caja Cerrada Correctamente!</div>');
  }
  if (info.noticia == 'caja_abierta') {
    $('.alerta_cerrar_caja').html('<div class="alert alert-success" role="alert">Ya tienes una caja Abierta!</div>');
  }


  }

}

});

}
