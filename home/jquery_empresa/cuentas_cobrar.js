function sendData_agregar_producto_C_c(){
  var parametros = new  FormData($('#agregar_producto_cuentas_por_cobrar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuentas_cobrar.php',
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
          $("#nombre_producto").val(info.nombre);
          $("#precio_producto").val(info.precio);
          $("#id_producto").val(info.idproducto);



      }

    }

  });

}


function sendData_agregar_clientes_cc_c(){
  var parametros = new  FormData($('#agregar_cliente_ccc')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuentas_cobrar.php',
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
          $("#nombre_cliente").val(info.nombres);
          $("#identificacion_cliente").val(info.identificacion);
          $("#id_cliente").val(info.id);



      }

    }

  });

}





function sendData_crear_cuentas_conbrar(){
  $('.notificacion_cuentas_conrar_g').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#crear_cuentas_cobrar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuentas_cobrar.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_cuentas_conrar_g').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_cuentas_conrar_g').html('<div class="alert alert-success" role="alert">Cuenta por Cobrear Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_cuentas_conrar_g').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
