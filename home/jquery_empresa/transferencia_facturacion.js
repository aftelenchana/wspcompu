function sendData_agregar_transferencia_kjh(){
  $('.notificacion_transferecnia_agregadp').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#tranferecnia_factruacion')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/transferencia_facturacion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_transferecnia_agregadp').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_transferecnia_agregadp').html('<div class="alert alert-success" role="alert">Deposito Agregado Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_transferecnia_agregadp').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}

function sendData_agregar_cliente_deposito(){
  var parametros = new  FormData($('#agregar_cliente_depositos')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/depositos_facturacion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_deposito_agregado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
        var info = JSON.parse(response);
          $("#id_cliente").val(info.id);
          $("#nombres_cliente").val(info.nombres);
          $("#identificacion_cliente").val(info.identificacion);



      }

    }

  });

}
