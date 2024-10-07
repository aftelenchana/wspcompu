function sendData_ingresar_lavado_reserva(){
  $('.notificacion_tipo_lavado').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#ingreso_lavado_reserva')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_ingreso_lavado_reserva').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_ingreso_lavado_reserva').html('<div class="alert alert-success" role="alert">Reserva agregada Corretamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_ingreso_lavado_reserva').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}





function sendData_agregar_tipo_lavado(){
  $('.notificacion_tipo_lavado').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_tipo_lavado')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_tipo_lavado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_tipo_lavado').html('<div class="alert alert-success" role="alert">Tipo de lavado Agregado Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_tipo_lavado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}



function sendData_ingrear_area_lavado(){
  $('.ingreso_area_lavado').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#ingrear_area_lavanderia')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.ingreso_area_lavado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.ingreso_area_lavado').html('<div class="alert alert-success" role="alert">Ingreso al lavado correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.ingreso_area_lavado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
