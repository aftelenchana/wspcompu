$(document).ready(function(){
  $.ajax({
    url:'scripts/configuracion.php',
    type:'POST',
    async: true,
     success: function(response){
       console.log(response);
      var info = JSON.parse(response);
      console.log(response);
      if (info.configuracion == 'NINGUNO') {
              $('#configurar_cuenta').modal();
      }


     },
     error:function(error){
       console.log(error);
       }

     });

});


function sendData_consultar_ruc(){
  $('.notificacio_ingresar_ruc').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#consulta_ruc')[0]);
  $.ajax({
    data: parametros,
    url: 'java/configuracion.php',
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
      if (info.noticia == 'consulta_no_existente') {
        $('.contendedor_respuestas_generales').html('<div class="">'+
                      '<form  class="" method="post" name="agregar_plan_user" id="agregar_plan_user" onsubmit="event.preventDefault(); sendData_agregar_plan();">'+
                        '<div class="alert alert-success" role="alert">'+
                        '  Hola Alex Telenchana, no se a encontrado información sobre ti en nuestro sistema !, a continuación'+
                        '  elije el sistema que se adapte a tus necesidades!'+
                        '</div>'+
                        '<div class="form-group">'+
                          '  <label for="exampleFormControlSelect1">Elije un sistema</label>'+
                            '<select class="form-control" name="sistema_seleccionado" id="exampleFormControlSelect1">'+
                              '<option value="1">Sistema General(Todos los Documentos Electrónicos sin agregar módulos.)</option>'+
                              '<option value="2">Sistema de Suscripción (Tiene el Módulo de agregar suscripciones por meses)</option>'+
                              '<option value="3">Sistema con Admisión(Realiza el ingreso y egreso de Pacientes)</option>'+
                              '<option value="4">Sistema con Pedidos(Realiza pedidos  como para restaurants)</option>'+
                              '<option value="5">Sistema Parqueo</option>'+
                              '<option value="6">Todo el Sistema sin restricciones</option>'+
                            '</select>'+
                          '</div>'+
                          '<div class="modal-footer">'+
                          '<input type="hidden" name="action" value="agregar_plan">'+
                            '<div class="espacio_agregar_boton_cerrar">'+
                                '<button type="submit" class="btn btn-success">Siguiente</button>'+
                            '</div>'+
                        '  </div>'+
                        '<div class="notificacio_agregar_plan">'+
                        '</div>'+
                      '</form>'+
                    '</div>');

      }

      if (info.noticia == 'consulta_exitosa') {
        $('.contendedor_respuestas_generales').html('<div class="">'+
                      '<form  class="" method="post" name="agregar_plan_user" id="agregar_plan_user" onsubmit="event.preventDefault(); sendData_agregar_plan();">'+
                        '<div class="alert alert-success" role="alert">'+
                        '  Hola '+info.RAZON_SOCIAL+', te presentamos un sistema que te pueda ayudar a '+info.ACTIVIDAD_ECONOMICA+' en la provincia de '+info.DESCRIPCION_PROVINCIA+' '+
                        ' en la ciudad de '+info.DESCRIPCION_CANTON+', elige el plan que mas se adecue a tu empresa !'+
                        '</div>'+
                        '<div class="form-group">'+
                          '  <label for="exampleFormControlSelect1">Elije un sistema</label>'+
                          '<select class="form-control" name="sistema_seleccionado" id="exampleFormControlSelect1">'+
                            '<option value="1">Sistema General(Todos los Documentos Electrónicos sin agregar módulos.)</option>'+
                            '<option value="2">Sistema de Suscripción (Tiene el Módulo de agregar suscripciones por meses)</option>'+
                            '<option value="3">Sistema con Admisión(Realiza el ingreso y egreso de Pacientes)</option>'+
                            '<option value="4">Sistema con Pedidos(Realiza pedidos  como para restaurants)</option>'+
                                 '<option value="5">Sistema Parqueo</option>'+
                              '<option value="6">Todo el Sistema sin restricciones</option>'+
                          '</select>'+
                          '</div>'+
                          '<div class="modal-footer">'+
                          '<input type="hidden" name="action" value="agregar_plan">'+
                            '<div class="espacio_agregar_boton_cerrar">'+
                                '<button type="submit" class="btn btn-success">Siguiente</button>'+
                            '</div>'+
                        '  </div>'+
                        '<div class="notificacio_agregar_plan">'+
                        '</div>'+
                      '</form>'+
                    '</div>');

      }


      }

    }

  });

}




function sendData_agregar_plan(){
  $('.notificacio_agregar_plan').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_plan_user')[0]);
  $.ajax({
    data: parametros,
    url: 'java/configuracion.php',
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
        $('.notificacio_agregar_plan').html('<div class="alert alert-success" role="alert">Tu cuenta se ha configurado Correctamente!</div>');
        $('.espacio_agregar_boton_cerrar').html('<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacio_agregar_plan').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }


      }

    }

  });

}
