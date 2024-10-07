
function sendData_configurar_cuienta_cobrar(){
  $('.notificacion_configurar_cuenya_cobrar').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#configuracion_cuenta_cobrar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuentas_cobrar_creados.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_configurar_cuenya_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_configurar_cuenya_cobrar').html('<div class="alert alert-success" role="alert">Cuenta por Cobrear Configurada Correctamente <a target="_blank" href="historial_pagos?idcuenta'+info.id+'">Historial Pagos</a> !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_configurar_cuenya_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }
      if (info.noticia == 'monto_cupera_capacidad') {
      $('.notificacion_configurar_cuenya_cobrar').html('<div class="alert alert-danger" role="alert">El monto supera a la cuenta débito, verifica los valores!</div>');

      }
      if (info.noticia == 'cuenta_configurada') {
      $('.notificacion_configurar_cuenya_cobrar').html('<div class="alert alert-danger" role="alert">Esta cuenta ya ha sido configurada!</div>');

      }

      }

    }

  });

}




function sendData_agregar_pafo_cuenta_cobrar(){
  $('.notificacion_agregar_pago_cuenta_cobrar').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_pago_cuenta_cobrar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cuentas_cobrar_creados.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_agregar_pago_cuenta_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_agregar_pago_cuenta_cobrar').html('<div class="alert alert-success" role="alert">Cuenta agregada Correctamente <a target="_blank" href="historial_pagos?idcuenta'+info.id+'">Historial Pagos</a> !</div>');
        $('.debito_modificado').html('$'+info.monto+'');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_agregar_pago_cuenta_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }
      if (info.noticia == 'monto_cupera_capacidad') {
      $('.notificacion_agregar_pago_cuenta_cobrar').html('<div class="alert alert-danger" role="alert">El monto supera a la cuenta débito, verifica los valores!</div>');

      }
      if (info.noticia == 'cuenta_configurada') {
      $('.notificacion_agregar_pago_cuenta_cobrar').html('<div class="alert alert-danger" role="alert">Esta cuenta ya ha sido configurada!</div>');

      }

      }

    }

  });

}
