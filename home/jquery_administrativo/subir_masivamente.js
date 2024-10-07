function sendData_subir_prodcutos_masivamente(){
  $('.notificacion_subida_productos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#subir_productos_masivamente')[0]);
  $.ajax({
    data: parametros,
    url: 'librerias/subir.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_subida_productos').html('<div class="alert alert-success" role="alert">Productos '+info.registros+' Agregados Correctamente .!</div>')

      }
      if (info.noticia =='error') {
        $('.notificacion_subida_productos').html('<div class="alert alert-danger" role="alert">Error, en el servidor !</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.notificacion_subida_productos').html('<div class="alert alert-danger" role="alert">Error al subir Productos!</div>')

      }

    }

  });
}


function sendData_subir_clientes_masivamente(){
  $('.notificacion_subida_clientes').html(' <div class="subir_clientes_masivamente">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#subir_clientes_masivamente')[0]);
  $.ajax({
    data: parametros,
    url: 'librerias/subir.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_subida_clientes').html('<div class="alert alert-success" role="alert">Clientes  '+info.registros+' Agregados Correctamente .!</div>')

      }
      if (info.noticia =='error') {
        $('.notificacion_subida_clientes').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.notificacion_subida_clientes').html('<div class="alert alert-danger" role="alert">Error al subir Clientes!</div>')

      }
      if (info.noticia =='identificacion_invalida') {
        $('.notificacion_subida_clientes').html('<div class="alert alert-warning" role="alert">Identificación Invalida revisa nuevamente el archivo, verifíca en '+indo.identificacion+' Columna '+info.columna+' !</div>')

      }

    }

  });
}





function sendData_subir_clientes_masivamente_credenciales(){
  $('.notificacion_subida_clientes_credenciales').html(' <div class="subir_clientes_masivamente">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#subir_clientes_masivamente_crdenciales')[0]);
  $.ajax({
    data: parametros,
    url: 'librerias/subir.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_subida_clientes_credenciales').html('<div class="alert alert-success" role="alert">Clientes  '+info.registros+' Agregados Correctamente .!</div>')

      }
      if (info.noticia =='error') {
        $('.notificacion_subida_clientes_credenciales').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.notificacion_subida_clientes_credenciales').html('<div class="alert alert-danger" role="alert">Error al subir Clientes!</div>')

      }
      if (info.noticia =='identificacion_invalida') {
        $('.notificacion_subida_clientes_credenciales').html('<div class="alert alert-warning" role="alert">Identificación Invalida revisa nuevamente el archivo, verifíca en '+indo.identificacion+' Columna '+info.columna+' !</div>')

      }

    }

  });
}
