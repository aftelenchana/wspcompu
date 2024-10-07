function sendData_cuenta_bancaria_kjhg(){
  $('.notificacion_cuenta_agregada').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_cuenta_bancaria')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuenta_bancaria.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_cuenta_agregada').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_cuenta_agregada').html('<div class="alert alert-success" role="alert">Cuenta Agregada Correctamente !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_cuenta_agregada').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
