function sendData_agregar_plan_parqueo(){
  $('.notificacion_plan_parqueo').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_plan_parqueo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/agregar_plan_parqueo.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_plan_parqueo').html('<div class="alert alert-success" role="alert">Plan de Parqueo Agregado Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_plan_parqueo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
