function sendData_preguntas(){
  $('.notificacion_pregunta').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_preguntas')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/preguntas.php',
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
       document.getElementById("code_respuesta").innerHTML = response;

      }

    }

  });

}

function sendData_respuestas(){
  $('.notificacion_respuesta').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_respuestas')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/preguntas.php',
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
           $('.request_respuesta').html(' <p style="background: #FFC300;border-radius: 10px;padding: 10px;margin: 3px;" >'+info.respuesta+'</p>')
           $('.notificacion_respuesta').html('')
           $('.respuesta_user').html(' <p style="background: #FFC300;border-radius: 10px;padding: 10px;margin: 3px;" >'+info.respuesta+'</p>')
           $('.name_uer232323').html('Vendedor responde el <p style="background: #FFC300;border-radius: 10px;padding: 10px;margin: 3px;" >(Hace un Momento)</p>')

        }


      }

    }

  });

}
