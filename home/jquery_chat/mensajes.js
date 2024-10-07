$(document).on("click", ".sacar_informacion_chat", function() {
  $('.resultado_mensajes_result').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
   var codigo = $(this).attr('codigo');
   var action = 'buscar_chat_usuario';
    $('#usuario_ingreso').val(codigo)

$.ajax({
  type:"post",
  url:"jquery_chat/mensajes.php",
  data: {action:action,codigo:codigo},
  success:function(response){
    console.log(response);
        var info = JSON.parse(response);
        if (info.noticia == 'no_existe_datos') {
          $('.resultado_mensajes_result').html('Vacio no Existen Datos')
            $('.resultado_usuario_buscar_nombres').html(info.nombres_user_raiz)

        }
        if (info.noticia == 'existe_chat') {
          $('.resultado_mensajes_result').html(info.respuesta)
            $('.resultado_usuario_buscar_nombres').html(info.nombres_user_raiz)

        }

  }

})

});



function sendData_agregar_chat(){
  var parametros = new  FormData($('#agregar_datos_chat')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_chat/mensajes.php',
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
      if (info.noticia == 'error') {
        $('.resultado_mensajes_result').html('Error en el servidor');
      }

      if (info.noticia == 'inser_correct') {
        var codigo = info.codigo;
        var action = 'buscar_chat_usuario';

     $.ajax({
       type:"post",
       url:"jquery_chat/mensajes.php",
       data: {action:action,codigo:codigo},
       success:function(response){
             var info = JSON.parse(response);
             if (info.noticia == 'no_existe_datos') {
               $('.resultado_mensajes_result').html('Vacio no Existen Datos')
                 $('.resultado_usuario_buscar_nombres').html(info.nombres_user_raiz)

             }
             if (info.noticia == 'existe_chat') {
               $('.resultado_mensajes_result').html(info.respuesta)
                 $('.resultado_usuario_buscar_nombres').html(info.nombres_user_raiz)

             }

       }

     })
      }




      }

    }

  });

}
