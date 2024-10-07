$(document).ready(function(){
  $("#contribuyente_especial_hg").change(function(){
    var contribuyente_especial_hg = $("#contribuyente_especial_hg").val();
    if (contribuyente_especial_hg=='SI') {
      $('.resultado_si_contribuyente').html('<div class="form-group">'+
                '<label for="exampleFormControlTextarea1">Agrega la  Resolución de Contribuyente Especial</label>'+
                '<textarea class="form-control" name="resolucion_contribuyente"  id="resolcuod_ces" rows="3"> </textarea>'+
              '</div>');


    }
    if (contribuyente_especial_hg=='NO') {
      $('.resultado_si_contribuyente').html('');


    }
  });

});


$(document).ready(function(){
  $("#agente_retencion_hgf").change(function(){
    var agente_retencion_hgf = $("#agente_retencion_hgf").val();
    if (agente_retencion_hgf=='SI') {
      $('.resultado_si_resolucion').html('<div class="form-group">'+
                '<label for="exampleFormControlTextarea1">Agrega la  Resolución de Agente de Retención</label>'+
                '<textarea class="form-control" name="resolucion_retencion"  id="ad_gente_retenion" rows="3"> </textarea>'+
              '</div>');


    }
    if (agente_retencion_hgf=='NO') {
      $('.resultado_si_resolucion').html('');


    }
  });

});


function sendData_add_contribuyente_especial(){
  $('.notificacion_resultador_contribuyente').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_contribuyente_especial')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        if (info.contribuyente_especial == 'NO') {
          $('.notificacion_resultador_contribuyente').html('<div class="alert alert-success" role="alert">Contribuyente Agregado Correctamente!</div>');
          $('#contribuyente_aq').val(info.contribuyente_especial);
          $('.resultado_guardar_contribuyente').html('');

        }
        if (info.contribuyente_especial == 'SI') {
          $('.notificacion_resultador_contribuyente').html('<div class="alert alert-success" role="alert">Contribuyente Agregado Correctamente!</div>');
          $('#contribuyente_aq').val(info.contribuyente_especial);
          $('.resultado_guardar_contribuyente').html('<div class="form-group">'+
                          '<label for="exampleFormControlTextarea1">Resolución de Contribuyente </label>'+
                          '<textarea class="form-control" readonly id="resolcuicin_contrniyebte_esoefal" rows="3">'+info.resolucion_contribuyente+'</textarea>'+
                        '</div>');

        }
      }
      if (info.noticia == 'error_insertar') {
        $('.notificacion_resultador_contribuyente').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}


function sendData_agregar_retencion(){
  $('.notificacion_resultador_retencion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_retencion')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        if (info.agente_retencion == 'NO') {
          $('.notificacion_resultador_retencion').html('<div class="alert alert-success" role="alert">Agente de Retención Agregado Correctamente!</div>');
          $('#agente_retencion').val(info.agente_retencion);
          $('.resultado_guardar_resolucion').html('');

        }
        if (info.agente_retencion == 'SI') {
          $('.notificacion_resultador_retencion').html('<div class="alert alert-success" role="alert">Agente de Retención  Agregado Correctamente!</div>');
          $('#agente_retencion').val(info.agente_retencion);
          $('.resultado_guardar_resolucion').html('<div class="form-group">'+
                          '<label for="exampleFormControlTextarea1">Resolución de Contribuyente </label>'+
                          '<textarea class="form-control" readonly id="resolcuicin_contrniyebte_esoefal" rows="3">'+info.resolucion_retencion+'</textarea>'+
                        '</div>');

        }
      }
      if (info.noticia == 'error') {
        $('.notificacion_resultador_retencion').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}











function sendData_reset_secuencial(){
  $('.notificacion_general_reset_secuencial').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#reset_secuencial')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_general_reset_secuencial').html('<div class="alert alert-success" role="alert">Secuencial Reseteado Correctamente!</div>');
          $('.exitencia_secuencial').html('<div class="alert alert-warning" role="alert">SECUENCIAL ACTUAL ('+info.nuevo_secuencial+')</div>');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_general_reset_secuencial').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}


function sendData_add_contabilidad(){
  $('.notificacion_contabilidad').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_contabilidad')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_contabilidad').html('<div class="alert alert-success" role="alert">Contabilidad Agregada Correctamente!</div>');
          $('#contabilidad_li').val(info.contabilidad);
      }
      if (info.noticia == 'error_insertar') {
          $('.notificacion_contabilidad').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}

function sendData_add_regimen(){
  $('.notificacion_regimennotificacion_regimen').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_regimen')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_regimen').html('<div class="alert alert-success" role="alert">Regimen Agregado Correctamente!</div>');
          $('#regimen_li').val(info.regimen);
      }
      if (info.noticia == 'error_insertar') {
        $('.notificacion_regimen').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
      }

      }

    }

  });

}



function sendData_add_establecimiento(){
  $('.notificacion_general_establecimiento').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_establecimiento')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_general_establecimiento').html('<div class="alert alert-success" role="alert">Establecimiento Agregado Correctamente!</div>');
          $('#establecimineto_ju').val(info.estableciminento);
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_general_establecimiento').html('<div class="noti_fac_negativa"><p>Error al Agregar </p><img src="/home/img/reacciones/cerrar.png" alt=""></div>');

      }

      }

    }

  });

}


function sendData_punto_emision(){
  $('.notificacion_punto_emision').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_punto_acceso')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_punto_emision').html('<div class="alert alert-success" role="alert">Punto de Emisión Agregado!</div>');
          $('#punto_emision').val(info.punto_emision);
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_punto_emision').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}


function sendData_porcentaje_iva(){
  $('.notificacion_porcentaje_iva').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_porcentaje_iva')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_porcentaje_iva').html('<div class="noti_fac_positiva"><p>Agregado Correctamente </p><img src="/home/img/reacciones/garrapata.png" alt=""></div>');
          $('#existencia_porcentaje_iva').html('<div class="noti_fac_positiva">'+
            '<p> <input style="text-align: center;" type="text" name="" value="'+info.porcentaje_iva+'%" readonly> </p>'+
          '</div>');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_porcentaje_iva').html('<div class="noti_fac_negativa"><p>Error al Agregar </p><img src="/home/img/reacciones/cerrar.png" alt=""></div>');

      }

      }

    }

  });

}





function sendDataedit_add_logo_empresa(){
  $('.resultado_imagen_upload').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
 $('.esperando').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
  var parametros = new  FormData($('#add_form_add_logo_empresa')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
          $('.resultado_imagen_upload').html('  <img class="img-fluid" style="width: 180px;" src="img/uploads/'+info.img+'" alt="'+info.img+'">');
          $('.notificacion_imagen_perfil').html('<div class="alert alert-success" role="alert">Foto Agregada Correctamente!</div>');

          $('.resultado_imagen_upload_perfil').html('<a href="#" class="profile-image " tabindex="-1" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">'+
                                          '<img class="user-img img-radius " width="50%"  src="img/uploads/'+info.img+'" alt="'+info.img+'" />'+
                                    '  </a>');
      }
      if (info.noticia == 'error_insertar') {
      $('.noti_img').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
/*Agregar firma electronica*/

function sendData_add_firma_electronica(){
  $('.notificacion_firma_digital').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
   console.log('procesando');
  var parametros = new  FormData($('#add_firma_electronica')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_agregar_firma_electronica').html('<div class="alert alert-success background-success">'+
        '<strong>Firma Electrónica y Clave guardada Correctamente!</strong> La fecha de Caducidad de tu Firma Electrónica es '+info.fecha_caducidad+'  '+
        '</div>');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_agregar_firma_electronica').html('<div class="alert alert-danger background-danger">'+
      '<strong>Error en el servidor!</strong> comunicate con soporte  '+
      '</div>');

      }
      if (info.noticia == 'error_credenciales_firma_clave') {
        $('.notificacion_agregar_firma_electronica').html('<div class="alert alert-warning background-warning">'+
        '<strong>Error en tus credenciales!</strong> verifíca tu firma eletrónica o tu clave'+
        '</div>');

      }
      if (info.noticia == 'firma_caducada') {
        $('.notificacion_agregar_firma_electronica').html('<div class="alert alert-warning background-warning">'+
        '<strong>Firma Caducada!</strong> Ingresa un Firma Válida'+
        '</div>');

      }

      }

    }

  });

}

/*Agregar codigo sri*/

function sendData_codigo_sri(){
  $('.notificacion_codigo_sri').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
   console.log('procesando');
  var parametros = new  FormData($('#add_codigo_sri')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
        $('.notificacion_codigo_sri').html('<div class="alert alert-success" role="alert">Clave Agregada Correctamente!</div>');
          $('existencia_claves').html('<div class="alert alert-success" role="alert">Ya tienes agregada una clave !</div>');
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_codigo_sri').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
      }
      if (info.noticia == 'claves_no_iguales') {
      $('.notificacion_codigo_sri').html('<div class="alert alert-danger" role="alert">Registra claves iguales!</div>');
      }

      }

    }

  });

}

/*Agregar direccion*/

function sendData_direccion(){
  $('.notificacion_direccion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_direccion')[0]);
  $.ajax({
    data: parametros,
    url: 'php/cuenta.php',
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
      $('.result_direccion').html(info.direccion);
      $('.editar_direccion').attr('direccion', info.direccion);
      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_direccion').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
      }

      }

    }

  });

}


function sendData_name_empresa(){
  $('.notificacion_empresa').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_name_empresa').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'Editado_correctamente') {
              $('.result_nombre_empresa').html(info.editt_empresa);
              $('.editar_nombre_empresa').attr('nombre_empresa', info.editt_empresa);
           }
           if (info.noticia == 'Error al editar') {
             $('.notificacion_empresa').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error</p>'+
              '</div>');

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}





function sendData_razon_social(){
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_razon_social').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'Editado_correctamente') {
              $('.result_razon_social').html(info.razon_social);
              $('.editar_razon_social').attr('razon_social', info.razon_social);
           }
           if (info.noticia == 'Error al editar') {

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}






function sendDataedit_nombres(){
  $('.notificacion_general').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  $('.alerteditt_nombre').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_nombres').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'editado_correctamente') {
             $('.result_nombres').html(info.nombres);
              $('.editar_nombres').attr('nombresh', info.nombres);
           }
           if (info.noticia == 'Error al editar') {
                 $('#errorModal').modal();
           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDataedit_apellidos(){
  $('.notificacion_apellidos').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_apellidos').serialize(),

       success: function(response){

         console.log(response);


         if (response =='error') {
           console.log(response);
           $('.alerteditt_Apellido').html('<p class="alerta_negativa">Error al Editar el Apellido</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'cuenta_activa_leben') {
             $('.notificacion_apellidos').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Cuenta Segura(No puede hacer Cambios en los Apellidos)</p>'+
              '</div>');

           }
           if (info.noticia == 'Editado_correctamente') {

              $('.result_apellidos').html(info.editt_apellido);
               $('.editar_apellidos').attr('nombresh', info.editt_apellido);

           }
           if (info.noticia == 'Error al editar') {
             $('.notificacion_apellidos').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error</p>'+
              '</div>');
           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}



function sendData_cedula_identidad(){
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_cedula_identidad').serialize(),

       success: function(response){

         if (response =='error') {
           console.log(response);
           $('.notificacion_cedula').html('<p class="alerta_negativa">Error al Editar el Apellido</p>')
         }else {
           console.log(response);
           var info = JSON.parse(response);
           if (info.noticia == 'Editado_correctamente') {
              $('.result_identidicacion').html(info.cedula_identidad);
               $('.editar_identificacion').attr('identificacion', info.cedula_identidad);

           }
           if (info.notificacion_cedula == 'Error al editar') {
             $('.notificacion_apellidos').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error</p>'+
              '</div>');
           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDataedit_email(){
  $('.notificacion_email').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_email').serialize(),

       success: function(response){
         if (response =='error') {
           $('.notificacion_email').html('<p class="alerta_negativa">Error al Editar el Email</p>');
         }else {
           var info = JSON.parse(response);
           if (info.email != '') {
             $('.notificacion_email').html(' <div class="notificacion_positiva">'+
                '<img src="/home/img/reacciones/garrapata.png" alt="">'+
              '</div>');
              $('.mail_user').html(info.email);

           }
           if (info.Error=='Error al insertar el Correo') {
             $('.notificacion_email').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');
           }
           if (info.Error=='password_incorrect') {
             $('.notificacion_email').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');
           }
           if (info.Error=='email_existente') {
            $('.notificacion_email').html(' <div class="notificacion_negativa">'+
               '<img src="/home/img/reacciones/cerrar.png" alt="">'+
               '<p>Error este Email ya Existe</p>'+
             '</div>');
           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDatatelefono(){
    $('.notificacion_telefono').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_telefono').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_telefono').html('<p class="alerta_negativa">Error al Agregar el Telefono</p>')
         }else {
           var info = JSON.parse(response);
            if (info.noticia == 'insert_correct') {
               $('.result_telefono').html(info.telefono);
                $('.editar_telefono').attr('telefono', info.telefono);

            }
            if (info.noticia == 'error_server') {
              $('.notificacion_telefono').html(' <div class="notificacion_negativa">'+
                 '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                 '<p>Error en el servidor</p>'+
               '</div>');
            }
            if (info.noticia == 'primer_digito_cero') {
              $('.notificacion_telefono').html(' <div class="notificacion_negativa">'+
                 '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                 '<p>Primer digito tiene que ser cero</p>'+
               '</div>');
            }
            if (info.noticia == 'digitos_9') {
              $('.notificacion_telefono').html(' <div class="notificacion_negativa">'+
                 '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                 '<p>Ingresa uno de 9 digitos</p>'+
               '</div>');
            }
            if (info.noticia == 'mayor_9') {
              $('.notificacion_telefono').html(' <div class="notificacion_negativa">'+
                 '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                 '<p>Ingresa uno de 9 digitos</p>'+
               '</div>');
            }

         }


       },
       error:function(error){
         console.log(error);
         }

       });

}


function sendDatacelular(){
    $('.notificacion_celular').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_celular').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_telefono').html('<p class="alerta_negativa">Error al Agregar el Telefono</p>')
         }else {
           var info = JSON.parse(response);
            if (info.noticia == 'insert_correct') {
               $('.rst_celular').html(info.celular);
                $('.editar_celular').attr('celular', info.celular);

            }
            if (info.noticia == 'error_server') {
                $('#error_general').modal();
              $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
              '<i class="icofont icofont-close-line-circled text-white"></i>'+
              '</button>'+
              '<strong>Error!</strong> Error en el Servidor Intenta mas tarde'+
              '</div>');
            }
            if (info.noticia == 'primer_digito_cero') {
              $('#error_general').modal();
            $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<i class="icofont icofont-close-line-circled text-white"></i>'+
            '</button>'+
            '<strong>Error!</strong> El primer digito tiene que ser cero'+
            '</div>');
            }
            if (info.noticia == 'digitos_10') {
              $('#error_general').modal();
            $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<i class="icofont icofont-close-line-circled text-white"></i>'+
            '</button>'+
            '<strong>Error!</strong>Tienes que digitar un numero con 10 digitos'+
            '</div>');
            }
            if (info.noticia == 'mayor_10') {
              $('#error_general').modal();
            $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<i class="icofont icofont-close-line-circled text-white"></i>'+
            '</button>'+
            '<strong>Error!</strong>Tu número es mayor a 10 dijita un número mayor a 10'+
            '</div>');
            }

         }


       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDataeditpasword(){
  $('.alerteditt_pasword').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_password').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_pasword').html('<p class="alerta_negativa">Error al Editar el N ombre</p>')
         }else {
           var info = JSON.parse(response);
           if (info.resp_password == 'positiva') {
             $('.alerteditt_pasword').html(' <div class="notificacion_positiva">'+
                '<img src="/home/img/reacciones/garrapata.png" alt="">'+
              '</div>');

           }
           if (info.resp_password == 'error_insertar') {
             $('.alerteditt_pasword').html('<p class="alerta_negativa">Error al insertar la contraseña</p>')
             $('.notificacion_celular').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');


           }
           if (info.resp_password == 'contrasena_incorrecta') {
             $('.alerteditt_pasword').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');


           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDataWhatsapp(){
    $('.notificacion_whatsaap').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_whatsapp').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_whatsaap').html('<p class="alerta_negativa">Error al Agregar Whatsapp</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
             $('.notificacion_whatsaap').html(' <div class="notificacion_positiva">'+
                '<img src="/home/img/reacciones/garrapata.png" alt="">'+
              '</div>');
              $('.whatsapp_user').html('<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;mi&nbsp;tienda&nbsp;Es&nbsp;https://guibis.com/perfil.php?id='+info.id+'"> <img src="img/reacciones/garrapata.png" alt=""><img src="img/reacciones/whatsapp.png" alt=""> </a>');

           }
           if (info.noticia == 'error_server') {
             $('.notificacion_whatsaap').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error en el servidor</p>'+
              '</div>');
           }
           if (info.noticia == 'primer_digito_cero') {
             $('.notificacion_whatsaap').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Primer digito tiene que ser cero</p>'+
              '</div>');
           }
           if (info.noticia == 'numero_major_a_10') {
             $('.notificacion_whatsaap').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Ingresa un numero Valido</p>'+
              '</div>');
           }
           if (info.noticia == 'contiene_menos_9') {
             $('.notificacion_whatsaap').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Ingresa un numero Valido</p>'+
              '</div>');
           }



         }


       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDatainstagram(){
    $('.notificacion_instagram').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_instagram').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_instagram').html('<p class="alerta_negativa">Error al Agregar instagram</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='insert_correct') {
              $('.result_insta').html(info.instagram);
               $('.editar_instagram').attr('instagram', info.instagram);

           }
           if (info.noticia == 'error_servidor') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong>Error en el servidor'+
           '</div>');
           }
           if (info.noticia == 'direccion_invalida') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong> Dirección Invalida'+
           '</div>');
           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}



function sendData_pagina_web(){
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_pagina_web').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_instagram').html('<p class="alerta_negativa">Error al Agregar instagram</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='insert_correct') {
              $('.result_pagina_web').html('<a class="out_pagina_web" href="#!">'+info.pagina_web+'</a>');
               $('.editar_pagina_web').attr('pagina_web', info.pagina_web);

           }
           if (info.noticia == 'error_servidor') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong>Error en el servidor'+
           '</div>');
           }
           if (info.noticia == 'direccion_invalida') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong> Dirección Invalida'+
           '</div>');
           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}




function sendData_descripcion(){
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_descripcion').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_agregar_descripcion').html('<p class="alerta_negativa">Error al Agregar instagram</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='Editado_correctamente') {
             $('.notificacion_agregar_descripcion').html('<div class="alert alert-danger background-success">'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
             '<i class="icofont icofont-close-line-circled text-white"></i>'+
             '</button>'+
             '<strong>Descripción!</strong>Agregada Correctamente'+
             '</div>');
               $('.descripcion_int').val( info.descripcion);

           }
           if (info.noticia == 'error_servidor') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong>Error en el servidor'+
           '</div>');
           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}




function sendData_telegram(){
    $('.notificacion_telegram').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_telegram').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_telegram').html('<p class="alerta_negativa">Error al Agregar instagram</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='insert_correct') {
             $('.notificacion_telegram').html(' <div class="notificacion_positiva">'+
                '<img src="/home/img/reacciones/garrapata.png" alt="">'+
              '</div>');
              $('.telegram_user').html('<a target="_blank" href="'+info.telegram+'"><img src="img/reacciones/garrapata.png" alt=""><img src="img/reacciones/instagram.png" alt=""></a>')

           }
           if (info.noticia == 'error_servidor') {
             $('.notificacion_telegram').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error en el servidor</p>'+
              '</div>');
           }
           if (info.noticia == 'direccion_invalida') {
             $('.notificacion_telegram').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Direccion Invalida</p>'+
              '</div>');
           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}



function sendData_facebook(){
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_facebook').serialize(),
       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_facebook').html('<p class="alerta_negativa">Error al Agregar Facebook</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='insert_correct') {
             $('.result_facebook').html(info.facebook);
              $('.editar_facebook').attr('facebook', info.facebook);

           }
           if (info.noticia == 'error_servidor') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong> Error en el Servidor Intenta mas tarde'+
           '</div>');
           }
           if (info.noticia == 'direccion_invalida') {
             $('#error_general').modal();
           $('.mensaje_error_general').html('<div class="alert alert-danger background-danger">'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<i class="icofont icofont-close-line-circled text-white"></i>'+
           '</button>'+
           '<strong>Error!</strong> Dirección Invalida'+
           '</div>');
           }
         }
       },
       error:function(error){
         console.log(error);
         }

       });

}


function sendData_tiktok(){
  $('.notificacion_tiktok').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_toktok').serialize(),
       success: function(response){
         if (response =='error') {
           $('.notificacion_facebook').html('<p class="alerta_negativa">Error al Agregar Facebook</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia=='insert_correct') {
             $('.notificacion_tiktok').html(' <div class="notificacion_positiva">'+
                '<img src="/home/img/reacciones/garrapata.png" alt="">'+
              '</div>');
              $('.tiktok_user').html('<a target="_blank" href="https://www.'+info.tiktok+'"><img src="img/reacciones/garrapata.png" alt=""><img src="img/reacciones/tiktok.png" alt=""></a>')

           }
           if (info.noticia == 'error_servidor') {
             $('.notificacion_tiktok').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error en el servidor</p>'+
              '</div>');
           }
           if (info.noticia == 'direccion_invalida') {
             $('.notificacion_tiktok').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Direccion Invalida</p>'+
              '</div>');
           }
         }
       },
       error:function(error){
         console.log(error);
         }

       });

}


function sendDatabanca_p(){
 $('.notificacion_banco_pichincha').html(' <div class="">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_banca_p').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_banco_pichincha').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
          $('.notificacion_banco_pichincha').html(' <div class="notificacion_positiva">'+
             '<img src="/home/img/reacciones/garrapata.png" alt="">'+
           '</div>');
           $('.banco_pichincha_user').html(info.banca_p);

           }

           if (info.noticia =='error_servidor') {
             $('.notificacion_banco_pichincha').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');


           }
           if (info.noticia == 'password_incorrect') {
             $('.notificacion_banco_pichincha').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');


           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDatabanca_guayaquil(){
  $('.notificacion_banco_guayaquil').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');

    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_banca_guayaquil').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_banco_guayaquil').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
          $('.notificacion_banco_guayaquil').html(' <div class="notificacion_positiva">'+
             '<img src="/home/img/reacciones/garrapata.png" alt="">'+
           '</div>');
           $('.banco_guayaquil_user').html(info.banca_p);

           }

           if (info.noticia =='error_servidor') {
             $('.notificacion_banco_guayaquil').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');


           }
           if (info.noticia == 'password_incorrect') {
             $('.notificacion_banco_guayaquil').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');


           }



         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function sendDatabanca_produbanco(){
  $('.notificacion_banco_produbanco').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');

    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_banca_produbanco').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.banco_produbanco_user').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
          $('.notificacion_banco_produbanco').html(' <div class="notificacion_positiva">'+
             '<img src="/home/img/reacciones/garrapata.png" alt="">'+
           '</div>');
           $('.banco_produbanco_user').html('<img src="/home/img/reacciones/garrapata.png" alt="">'+info.banca_p+'');

           }

           if (info.noticia =='error_servidor') {
             $('.notificacion_banco_produbanco').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');


           }
           if (info.noticia == 'password_incorrect') {
             $('.notificacion_banco_produbanco').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');


           }



         }
       },
       error:function(error){
         console.log(error);
         }

       });

}


function sendDatabanca_pacifico(){
  $('.notificacion_banco_pacifico').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'php/cuenta.php',
      type:'POST',
      async: true,
      data: $('#add_form_banca_pacifico').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.notificacion_banco_pacifico').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'insert_correct') {
          $('.notificacion_banco_pacifico').html(' <div class="notificacion_positiva">'+
             '<img src="/home/img/reacciones/garrapata.png" alt="">'+
           '</div>');
           $('.banco_pacifico_user').html('<img src="/home/img/reacciones/garrapata.png" alt="">'+info.banca_p+'');

           }

           if (info.noticia =='error_servidor') {
             $('.notificacion_banco_pacifico').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Error de Servidor</p>'+
              '</div>');


           }
           if (info.noticia == 'password_incorrect') {
             $('.notificacion_banco_pacifico').html(' <div class="notificacion_negativa">'+
                '<img src="/home/img/reacciones/cerrar.png" alt="">'+
                '<p>Contraseña Incorrecta</p>'+
              '</div>');


           }



         }
       },
       error:function(error){
         console.log(error);
         }

       });

}



//Activar cuenta mi leben
$(document).ready(function(){
  $('.active_count_now').click(function(e){
    e.preventDefault();
    var usuario = $(this).attr('usuario');
    var action = 'infoUsuario';
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.mi_leben == 'Activa') {
             $('.bodyModal_add_active_count').html('<form class="form_add_producto" action="" method="post" name="add_form_active_count" id="add_form_active_count" onsubmit="event.preventDefault(); sendDataactive_conut();">'+
                 '<h3>'+info.nombres+' tratamos de crear un mundo seguro en nuestro mundo, tu cuenta esta activada</h3>'+
                  '<div class="notificacion_solicitud">'+
                  '</div>'+
                  '<h3>Estado: '+info.mi_leben+'</h3>'+
                  '<input type="hidden" name="action" value="activar_cuenta" required><br>'+
                  '<a class="btn_ok closeModal" onclick="closeModal_active_count();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');

           }else {
             $('.bodyModal_add_active_count').html('<form class="form_add_producto" action="" method="post" name="add_form_active_count" id="add_form_active_count" onsubmit="event.preventDefault(); sendDataactive_conut();">'+
                 '<h3>Hola <span class="nombres_info_usuario"> '+info.nombres+' '+info.apellidos+'</span> tratamos de crear tu mundo seguro en nuestro mundo, sube una imagen de tu cedula de identidad y  activa tu cuenta en nuestro sitio para tener beneficios como:</h3>'+
                  '<div class="photo">'+
                  '<div class="lista_beneficios">'+
                    '<ul>'+
                      '<li>Transferencia de Pagos con el 3% de Comisión.</li>'+
                      '<li>Menor tiempo en pagos de tus ventas.</li>'+
                      '<li>Tus cuenta es 100% Segura.</li>'+
                    '</ul>'+
                  '</div>'+
                  '<input  type="file" name="foto"  accept="image/png, .jpeg, .jpg" required>'+
                  '<div class="notificacion_solicitud">'+
                  '</div>'+
                  '<h3 class="estado_c_d">Estado: '+info.mi_leben+'</h3>'+
                  '<input type="hidden" name="action" value="activar_cuenta" required><br>'+
                  '<button type="submit" name="button" class="btn_new" onsubmit="sendDataedit_add_servicios();">Seleccionar foto de Cdeula de Identidad</button>'+
                  '<a class="btn_ok closeModal" onclick="closeModal_active_count();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_active_count').fadeIn();


  });

});


function sendDataactive_conut(){
 $('.notificacion_solicitud').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
  var parametros = new  FormData($('#add_form_active_count')[0]);
  $.ajax({
    data: parametros,
    url: 'jquey_cuenta/activar_cuenta.php',
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
       $('.esperando').html('');
       $('.notificacion_solicitud').html('<p class="alerta_oisitiva">Solicitud Enviada Correctamente</p>')
        $('.estado_c_d').html('Estado: En Proceso')


      }

    }

  });

}


function closeModal_active_count(){
 $('.name_product').val('');
  $('.foto').val('');

  $('.modal_active_count').fadeOut();
}
