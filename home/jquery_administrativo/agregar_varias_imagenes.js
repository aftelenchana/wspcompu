
function sendData_agregar_varias_iamgenes(){
  $('.notificacion_agregar_imagenes').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_varias_imagenes')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_administrativo/agregar_varias_imagenes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_agregar_imagenes').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'productos_agregados_correctamente') {
        $('.notificacion_agregar_imagenes').html('<div class="alert alert-success" role="alert"> '+info.cantidad+' Imagenes  Agregadas  Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_agregar_imagenes').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      if (info.noticia == 'usuario_existente') {
      $('.notificacion_agregar_imagenes').html('<div class="alert alert-warning" role="alert">El usuario con '+info.identificacion+' ya se encuentra registrado lo puedes mirar en el siguiente <a href="perfil_cliente.php?cliente='+info.cliente+'">Enlace</a>!</div>');

      }

      if (info.noticia == 'identificacion_invalida') {
      $('.notificacion_agregar_imagenes').html('<div class="alert alert-danger" role="alert">Ingresa una Identificación Válida!</div>');

      }

      }

    }

  });

}


$(document).on("click", ".eliminar_imagen", function() {
    var imagen = $(this).attr("imagen");
    var action = 'eliminar_imagen';
    $.ajax({
      url: 'jquery_administrativo/agregar_varias_imagenes.php',
      type:'POST',
      async: true,
      data: {action:action,imagen:imagen},
      success: function(response){
        console.log(response);
        var info = JSON.parse(response);
        if (info.noticia == 'elimado_correctamnete') {
          var urlf ='imagen'+info.imagen+'';
          console.log(urlf);
       document.getElementById('imagen'+info.imagen+'').style.display = "none";

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_habilitar_plataforma').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }
      if (info.noticia == 'sin_url_real') {
      $('.notificacion_habilitar_plataforma').html('<div class="alert alert-danger" role="El archivo que estas intendado Eliminar no esta en este servidor intenta acceder al dominio '+info.url+'!</div>');

      }


      },
    });
});






function sendData_agregar_factores(){
  $('.notificacion_agregar_producto').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#configurar_factores')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_administrativo/agregar_varias_imagenes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_agregar_producto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'editador_correctamente') {
        $('.notificacion_agregar_producto').html('<div class="alert alert-success" role="alert"> Producto Habilitado Correctamente!</div>');

      }
      if (info.noticia == 'error_editar') {
      $('.notificacion_agregar_producto').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }


      }

    }

  });

}
