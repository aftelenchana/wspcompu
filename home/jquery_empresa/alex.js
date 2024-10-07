function sendData_agregar_base_datos(){
  $('.notificacion_subir_base_datos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#subir_base_satos')[0]);
  $.ajax({
    data: parametros,
    url: 'librerias/subir_base_datos',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_subir_base_datos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      console.log(response);
      if (info.noticia == 'insert_correct') {
        var inicio = parseInt(info.inicio);
        var final  =  parseInt(info.llegada);
        var meta   =  parseInt(info.llegada_fin);
        var porcentaje = (final/meta)*100;
        var inicio_nuevo = final+1;
        var final_tope = final+1700;
        $('#inicio_secuncial').val(inicio_nuevo);
        $('#final_secuencial').val(final_tope);
        const audio = new Audio("audio/noti.mp3");
        audio.play();
        if (final_tope<=meta) {
          $('.notificacion_subir_base_datos').html('<div class="alert alert-success" role="alert">SECUENCIA INICIADO EN '+info.inicio+' hasta '+info.llegada+', tiene que igualar a '+info.llegada_fin+', el porcentaje de subida es '+porcentaje+' !</div>');
          $('.porcentaje_ty').html('<div class="alert alert-success" role="alert">Porcentaje de subida es '+porcentaje+' en '+info.provincia+' !</div>');
        }else {
          $('.notificacion_subir_base_datos').html('<div class="alert alert-danger" role="alert">SECUENCIA INICIADO EN '+info.inicio+' hasta '+info.llegada+', tiene que igualar a '+info.llegada_fin+', el porcentaje de subida es '+porcentaje+' !</div>');
            $('.porcentaje_ty').html('<div class="alert alert-danger" role="alert">Porcentaje de subida es '+porcentaje+' en '+info.provincia+' !</div>');
        }




      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_subir_base_datos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
