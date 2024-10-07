function sendDataedit_responder_pregunta(){
  $('.alerta_responder').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#responder_pregunta')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_preguntas/preguntas.php',
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
       if (info.noticia  == 'insert_ok') {
            $('.respuesta_user').html(info.respuesta)
            $('.alerta_responder').html('<div class="alert alert-success background-success">'+
            '<strong>Respuesta!</strong> Agregada Correctamente'+
            '</div>');

       }

      }

    }

  });

}
