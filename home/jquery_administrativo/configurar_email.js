function sendDataedit_nuevo_producto(){
  $('.alerta_agregar_email').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_email_host')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_administrativo/configurar_email.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.alerta_agregar_email').html('<div class="alert alert-success" role="alert">Correo agregado Correctamente desde este momento este correo sera tu servidor de correo electrónico.!</div>')

      }
      if (info.noticia =='error') {
        $('.alerta_agregar_email').html('<div class="alert alert-danger" role="alert">Error,'+info.contenido_error+' !</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.alerta_agregar_email').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')

      }

    }

  });
}
