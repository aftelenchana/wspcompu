$(document).ready(function(){
  $.ajax({
    url:'scripts/configuracion_caja.php',
    type:'POST',
    async: true,
     success: function(response){
       console.log(response);
      var info = JSON.parse(response);
      console.log(response);
      if (info.noticia == 'caja_cerrada') {
              $('#configurar_caja').modal();
      }


     },
     error:function(error){
       console.log(error);
       }

     });

});






function sendDataedit_iniciar_caja(){
    $('.alerta_iniciar_caja2').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#add_iniciar_caja')[0]);
$.ajax({
data: parametros,
url: 'jquey_cuenta/caja.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.alerta_iniciar_caja2').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'insert_correct') {
    $('.alerta_iniciar_caja2').html('<div class="alert alert-success" role="alert">Caja Abierta Correctamente!</div>');
    $('.footer_modal_abrir_caja').html('<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');
  }
  if (info.noticia == 'caja_abierta') {
    $('.alerta_iniciar_caja2').html('<div class="alert alert-danger" role="alert">Ya tienes una caja Abierta!</div>');
  }


  }

}

});

}
