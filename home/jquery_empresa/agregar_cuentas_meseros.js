function sendData_agregar_cuentas_meseros(){
  $('.notificacion_agregar_cuenta_mesero').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_cuentas_meseros')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/agregar_cuentas_meseros.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_agregar_cuenta_mesero').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_agregar_cuenta_mesero').html('<div class="alert alert-success" role="alert">Cuenta Agregada Correctamente !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_agregar_cuenta_mesero').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
