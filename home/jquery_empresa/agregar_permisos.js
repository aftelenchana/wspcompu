function sendData_permisos_documentos(){
  $('.notificacion_permisos_documentos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#permisos_documentos')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/agregar_permisos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_permisos_documentos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_permisos_documentos').html('<div class="alert alert-success" role="alert">Permisos de Documentos Agregados Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_permisos_documentos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
