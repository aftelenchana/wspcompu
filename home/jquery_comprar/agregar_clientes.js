function sendData_editar_producto_jj(){
  $('.noticia_editar_producto').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#editar_producto_j')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/clientes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_editar_producto').html('<div class="noti_fac_positiva"><p>Agregado Correctamente </p><img src="img/reacciones/garrapata.png" alt=""></div>');
        location.href ='editar_producto.php?producto='+info.idproducto+'';

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_editar_producto').html('<div class="noti_fac_negativa"><p>Error al Agregar </p><img src="img/reacciones/cerrar.png" alt=""></div>');

      }

      }

    }

  });

}

$(document).ready(function(){
  $('.eliminar_cliente').click(function(e){
    e.preventDefault();
    var cliente = $(this).attr('cliente');
    var action = 'eliminar_cliente';
    $.ajax({
      url: 'jquery_comprar/clientes.php',
      type:'POST',
      async: true,
      data: {action:action,cliente:cliente},
      success: function(response){
        console.log(response);
        if (response != 'error') {
          var info = JSON.parse(response);
          if (info.noticia == 'insert_correct') {
            location.href ='clientes.php';
          }

        }
      },
       error:function(error){
         console.log(error);
         }
       });

  });

});



function sendData_editar_clientes(){
  $('.noticia_agregar_clientes').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#editar_clientes')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/clientes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_agregar_clientes').html('<div class="noti_fac_positiva"><p>Agregado Correctamente </p><img src="img/reacciones/garrapata.png" alt=""></div>');
        location.href ='editar_cliente.php?cliente='+info.id_cliente+'';

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_agregar_clientes').html('<div class="noti_fac_negativa"><p>Error al Agregar </p><img src="img/reacciones/cerrar.png" alt=""></div>');

      }

      }

    }

  });

}


function sendData_agregar_clientes(){
  $('.noticia_agregar_clientes').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_cientes')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/clientes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_agregar_clientes').html('<div class="alert alert-success" role="alert">Cliente Agregado Correctamente lo puedes mirar  <a href="perfil_cliente.php?cliente='+info.cliente+'">en este enlace</a> !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_agregar_clientes').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      if (info.noticia == 'usuario_existente') {
      $('.noticia_agregar_clientes').html('<div class="alert alert-warning" role="alert">El usuario con '+info.identificacion+' ya se encuentra registrado lo puedes mirar en el siguiente <a href="perfil_cliente.php?cliente='+info.cliente+'">Enlace</a>!</div>');

      }

      if (info.noticia == 'identificacion_invalida') {
      $('.noticia_agregar_clientes').html('<div class="alert alert-danger" role="alert">Ingresa una Identificación Válida!</div>');

      }


      }

    }

  });

}




$(document).ready(function(){
  $('.enviar_email').click(function(e){
    e.preventDefault();
    var clave_acceso = $(this).attr('clave_acceso');
    var action = 'enviar_email';
    $('.'+clave_acceso+'').html(' <div class="notificacion_negativa">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'jquery_comprar/clientes.php',
      type:'POST',
      async: true,
      data: {action:action,clave_acceso:clave_acceso},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
             console.log('SI SE PUDO');
             $('.'+info.clave_acceso+'').html('<div class="noti_fac_positiva"><img src="img/reacciones/garrapata.png" width="45px" alt=""></div>');

           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_producto').fadeIn();

  });

});
