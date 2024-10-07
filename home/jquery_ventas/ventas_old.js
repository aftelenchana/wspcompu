
//entrega producto
$(document).ready(function(){
  //modal para agregar el producto
  $('.agregar_entrega_producto').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoventa2';
    $.ajax({
      url:'jquery_ventas/ventas.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.estado == 'Iniciada') {
                        if (info.estado_fisico == 'NO ENTREGADO') {
                          if (info.estado_financiero == 'PAGADO') {
                            $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                            '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">Entrega el Producto</h4>'+
                            '<h3 style="margin: 12px;color: #329C08;">ENTREGA EL PRODUCTO</h3>'+
                            '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">La venta #'+info.id+''+
                            ' se ha realizado con exito,entrega el producto Físicamente y digitalmente aquí, para que puedas realizar la solicitud de pago (alado de este botón)  asegúrate de que la información proporcionada sea verídica, puesto que en caso de ser falsa el usuario comprador puede reportar la venta y enviar este caso al departamento legal.</p>'+
                            '<input type="hidden" name="action" id="" value="entregar_producto">'+
                             '<input type="hidden" name="id_venta" id="" value="'+info.id+'">'+
                             '<div class="alerta_general_gg">'+
                             '</div>'+
                            '<button type="submit" name="button" class="btn_new" onsubmit="sendDataedit_add_servicios();">Entregar Producto</button>'+
                            '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                              '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                            '</div>'+
                            '</form>');
                          }
                          if (info.estado_financiero == 'Pago Verificado') {
                            $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                            '<h3>El cliente comprador ya deposito la cantidad a la cual pertenece a este producto entrega el producto para que puedas realizar la solicitud de pago</h3>'+
                            '<input type="hidden" name="action" id="" value="entregar_producto">'+
                             '<input type="hidden" name="id_venta" id="" value="'+info.id+'">'+
                             '<div class="alerta_general_gg">'+
                             '</div>'+
                            '<button type="submit" name="button" class="btn_new" onsubmit="sendDataedit_add_servicios();">Entregar Producto</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModal_entrega_producto();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                            '</form>');
                          }
                          if (info.estado_financiero == 'VERIFICANDO') {
                            $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                            '<h3>El cliente comprador no ha  deposito la cantidad a la cual pertenece a este producto no entregues el producto </h3>'+
                            '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                              '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                            '</div>'+
                                                        '</form>');
                          }

                        }
                        if (info.estado_fisico == 'ENTREGADO') {

                            $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                            '<h3>El producto ya ha sido entregado</h3>'+
                            '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                              '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                            '</div>'+
                                                        '</form>');

                        }


           }
           if (info.estado == 'Cancelada') {
             $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">No Entregues el Producto</h4>'+
             '<h3 style="margin: 12px;color: #CE0000;">La venta #'+info.id+' ha sido cancelada , NO ENTREGUES EL PRODUCTO</h3>'+
             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">La venta #'+info.id+' ,'+
             'ha sido <span style="color: #CE0000;font-weight: bold;">CENCELADA</span>, fecha de cancelacion <span style="color: #CE0000;font-weight: bold;">('+info.fecha_cancelacion_venta+')</span>, por lo tanto el sistema ya hizo la devolucion del dinero  '+
             'a la cuenta del comprador.</p>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
             '</form>');
           }
           if (info.estado == 'Reportado') {
             $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">Entrega del Producto</h4>'+
             '<h3 style="margin: 12px;color: #CE0000;">La venta #'+info.id+' ha sido reportada</h3>'+
             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">La venta #'+info.id+' ,'+
             'ha sido reportada por el comprador, tipo de reporte (<span style="color: #CE0000;font-weight: bold;">'+info.tipo_reporte+'</span>), fecha de reporte <span style="color: #CE0000;font-weight: bold;">('+info.fecha_reporte+')</span>, descripción del reporte <span style="color: #CE0000;font-weight: bold;">('+info.descripcion_reporte+')</span> ('+info.descripcion_reporte+'), fecha máxima de solución de reporte ('+info.fecha_final_reporte+'), por lo tanto nuestro Departamento legal esta trabajando '+
             'contigo para tomar una solución lo más pronto posible puedes enviar un contra reporte y pugnar.</p>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
                          '</form>');

           }

           if (info.estado == 'Finalizada') {
             $('.bodyModal_agregar_entrega').html('<form class="form_add_producto" action="" method="post" name="entregar_producto" id="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">Entrega del Producto</h4>'+
             '<h3 style="margin: 12px;color: #CE0000;">La venta #'+info.id+' ha sido Finalizada</h3>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_entrega_producto();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
                          '</form>');
           }






         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_agregar_entrega').fadeIn();


  });

});


function sendData_entregar_producto(){
 $('.alerta_general_gg').html(' <div class="notificacion_negativa">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#entregar_producto')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_ventas/ventas.php',
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
      if (info.noticia == 'producto_entregado') {
        $('.alerta_general_gg').html('<div class="alerta_positiva">'+
          '<p style="background: #59CA24;padding: 5px;margin: 5px;">Producto Entregado Correctamente, el usuario a recibir no tiene que realizar ningun reporte y en un lapso de 24 horas, puede relizar la solicitud de cobro</p>'+
        '</div>');
        $('.entrga_venta'+info.id_venta+'').html('<p style="background: #C524CA;padding: 5px;">PRODUCTO ENTREGADO</p>');
      }

      if (info.noticia == 'estado_financiero_no_valido') {
        $('.alerta_general_gg').html('<div class="alerta_positiva">'+
          '<p>Sin pago del producto</p>'+
        '</div>');
      }
      if (info.noticia == 'error_insertar_sistema') {
        $('.alerta_general_gg').html('<div class="alerta_positiva">'+
          '<p>Error en el sistema</p>'+
        '</div>');
      }




      }

    }

  });

}


function closeModal_entrega_producto(){
  $('.foto').val('');
  $('.modal_agregar_entrega').fadeOut();
}










//solicitar_pago
$(document).ready(function(){
  //modal para agregar el producto
  $('.solicitar_pago').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoventa';
    $.ajax({
      url:'jquery_ventas/ventas.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
        success: function(response){
         console.log(response)
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.identificador_trabajo == 'producto' || info.identificador_trabajo == 'evento_recaudacion') {
             if (info.estado_reporte  == 'Activado') {
               $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
                  '<h3>Esta venta a sido reportada, nuestro departamento legal esta trabajando en tu caso</h3>'+
                        '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                        '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                          '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                        '</div>'+
                      '</form>');

             }else {
               if (info.solicitud_pago == 'PAGO EN PROCESO') {
                 $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
                    '<h3>PAGO EN PROCESO </h3>'+
                          '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                          '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                            '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                          '</div>'+
                                                  '</form>');

               }

               if (info.solicitud_pago == 'POR SOLICITAR') {
                     if (info.estado_fisico == 'ENTREGADO') {
                       $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
                       '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO ID #'+info.id+'</h4>'+
                       '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">'+
                       'Realiza la solicitud de pago para tener el dinero de esta venta en tu cuenta y posteriormente retirarlo en tus cuentas bancarias.</p>'+
                       '<input type="hidden" name="action" value="solicitar_pago" >'+
                         '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                       '<div class="tipo_cuenta_soli_pago">'+
                         '<select class="" name="tipo_banco_solicitud">'+
                           '<option value="Mi Cuenta Leben">Guibis.com</option>'+
                         '</select> '+
                       '</div>'+
                       '<div class="alerta_solictud_pago">'+
                       '</div>'+
                       '<button type="submit" name="button" class="btn_new" onsubmit="sendDataedit_add_servicios();">Solicitar Pago</button>'+
                       '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                         '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                       '</div>'+
                                              '<div class="alerta_solicitar_pago">'+
                       '</div>'+
                       '</form>');
                     }
                     if (info.estado_fisico == 'NO ENTREGADO') {
                       $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
                       '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO</h4>'+
                       '<h3 style="margin: 12px;color: #329C08;">ENTREGA EL PRODUCTO</h3>'+
                       '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">La venta #'+info.id+''+
                       ' se ha realizado con exito,entrega el producto Físicamente y digitalmente aquí, para que puedas realizar la solicitud de pago (alado de este botón)  asegúrate de que la información proporcionada sea verídica, puesto que en caso de ser falsa el usuario comprador puede reportar la venta y enviar este caso al departamento legal.</p>'+
                       '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                         '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                       '</div>'+
                                              '</form>');
                     }

               }
               if (info.solicitud_pago == 'PAGADO') {
                 $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
                    '<h3>PAGADO CORRECTAMENTE</h3>'+
                          '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                          '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                            '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                          '</div>'+
                                                  '</form>');

               }



             }


           }

           if (info.identificador_trabajo == 'evento') {
             $('.bodyModal_solicitar_pago').html('<form class="form_add_producto" action="" method="post" name="solicitar_pago" id="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago();">'+
             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO</h4>'+
             '<h3 style="margin: 12px;color: #329C08;">EL PAGO SE LO TIENE QUE REALIZAR DESDE LA CONSOLA DEL EVENTO</h3>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar_pago();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
           '</form>');

           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_solicitar_pago').fadeIn();


  });

});


function sendData_solicitar_pago(){
 $('.alerta_solictud_pago').html(' <div class="notificacion_negativa">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#solicitar_pago')[0]);
  $.ajax({
    data: parametros,
      url:'jquery_ventas/ventas.php',
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
      if (info.noticia == 'pagado_correctamente') {
        $('.alerta_solictud_pago').html('<p style="background: #26B329;padding: 5px;margin: 10px;">Pago Hecho Exitosamente</p>');
        $('.solicitud_pago'+info.id_venta+'').html('<div class="producto_entregado">'+
          '<p>PAGADO</p>'+
        '</div>');
      }

      if (info.noticia == 'venta_pagada_sin_acciones') {
        $('.alerta_solictud_pago').html('<p style="background: #F31F1F;padding: 5px;margin: 10px;">Ya se realizo el pago correspondiente</p>');
      }

        if (info.noticia == 'fecha_no_activa') {
          $('.alerta_solictud_pago').html('<p style="background: #FF0000;padding: 10px;margin: 5px;">No a pasado el tiempo requerido para que sea una compra segura, la fecha tope de solicitud es: '+info.fecha_activa+'</p>');
        }
        if (info.noticia == 'reporte_activado') {
          $('.alerta_solictud_pago').html('Esta venta tiene un reporte');
        }
      if (info.noticia == 'pagado_correctamente_en_proceso_pichincha') {
        $('.alerta_solictud_pago').html('Pago en proceso a Banco Pichincha, esto no lleva mas de 5 minutos');
      }
      if (info.noticia == 'pagado_correctamente_en_proceso_guayaquil') {
        $('.alerta_solictud_pago').html('Pago en proceso a Banco Guayaquil, esto no lleva mas de 5 minutos');
      }
      if (info.noticia == 'pagado_correctamente_en_proceso_produbanco') {
        $('.alerta_solictud_pago').html('Pago en proceso a Banco Produbanco, esto no lleva mas de 5 minutos');
      }

      if (info.noticia == 'cuenta_vacia_produbanco') {
        $('.alerta_solictud_pago').html('No tienes agregado una cuenta Produbanco en nuestra plataforma');
      }
      if (info.noticia == 'cuenta_vacia_guayaquil') {
        $('.alerta_solictud_pago').html('No tienes agregado una cuenta Guayaquil en nuestra plataforma');
      }
      if (info.noticia == 'cuenta_vacia_pihincha') {
        $('.alerta_solictud_pago').html('No tienes agregado una cuenta Pihincha en nuestra plataforma');
      }
      if (info.noticia == 'error_pago_servidor') {
        $('.alerta_solictud_pago').html('Error en el servidor, comuniquese con un tecnico');
      }


      if (info.noticia == 'error_pago_servidor') {
        $('.alerta_solictud_pago').html('Error en el sistema ');
      }
      if (info.noticia == 'cuenta_inactiva') {
        $('.alerta_solictud_pago').html('Cuenta Inactiva');

      }


      }

    }

  });

}


function closeModal_solicitar_pago(){
  $('.foto').val('');
  $('.modal_solicitar_pago').fadeOut();
}















//ver_reportes
$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_reportes').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'inforeporte';
    $.ajax({
      url:'jquery_ventas/ventas.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
        success: function(response){
         console.log(response)
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.noticia == 'sin_reporte') {
             $('.bodyModal_reportes').html('<form class="form_add_producto" action="" method="post" name="reportar_reporte" id="reportar_reporte" onsubmit="event.preventDefault(); sendData_reportar_reporte();">'+
                '<h3>Esta venta no tiene reportes </h3>'+
                '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                  '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_reportes();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                '</div>'+
              '</form>');

           }else {



             if (info.estado_contrareporte == 'Activado') {
               $('.bodyModal_reportes').html('<form class="form_add_producto" action="" method="post" name="reportar_reporte" id="reportar_reporte" onsubmit="event.preventDefault(); sendData_reportar_reporte();">'+
               '<h3>Esta venta ya has hecho un recontrareporte </h3>'+
               '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                 '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_reportes();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
               '</div>'+
               '</form>');

             }else {
               $('.bodyModal_reportes').html('<form class="form_add_producto" action="" method="post" name="reportar_reporte" id="reportar_reporte" onsubmit="event.preventDefault(); sendData_reportar_reporte();">'+
               '<h3>Ver reportes </h3>'+
               '<div class="informacion_reporte">'+
               '<table>'+
               '<tr>'+
               '<td>Tipo Reporte</td>'+
               '<td>'+info.tipo_reporte+'</td>'+
               '</tr>'+
               '<tr>'+
               '<td>Fecha Reporte</td>'+
               '<td>'+info.fecha_reporte+'</td>'+
               '</tr>'+
               '<tr>'+
               '<td>Descripcion Reporte:</td>'+
               '<td>'+info.descripcion_reporte+'</td>'+
               '</tr>'+
               '<tr>'+
               '<img src="img/reportes/'+info.img_reporte+'" alt="" width="50px">'+
               '</tr>'+
               '</table>'+
               '<input  type="file" name="foto" id="foto" accept="image/png, .jpeg, .jpg" required><br>'+
               '<input  type="hidden" name="action" value="reportar_reporte"  required><br>'+
               '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
               '<textarea class="descripcion_product" required name="descripcion_reporte" rows="5" cols="40"  placeholder="Descripcion del Problema"></textarea><br>'+
               '<input  type="text" name="password" value="" placeholder="Ingrese su Contraseña"  required><br>'+
               '<div class="alerta_reporte_reporte">'+
               '</div>'+
               '</div><br>'+
               '<button type="submit" name="button" class="btn_new">Reportar Reporte</button>'+
               '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                 '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_reportes();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
               '</div>'+
               '</form>');

             }

           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_reportes').fadeIn();


  });

});

function sendData_reportar_reporte(){
     $('.alerta_reporte_reporte').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
  var parametros = new  FormData($('#reportar_reporte')[0]);
  $.ajax({
    data: parametros,
    url:'jquery_ventas/ventas.php',
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
      if (info.noticia == 'venta_recontrareportada') {
        $('.alerta_reporte_reporte').html('Reporte hecho Correctamente');

      }
      if (info.noticia == 'Error_reportar_venta') {
        $('.alerta_reporte_reporte').html('Error en el servidor');

      }
      if (info.noticia == 'Error_password') {
        $('.alerta_reporte_reporte').html('Error de contraseña');

      }


      }

    }

  });

}

function closeModal_ver_reportes(){
  $('.foto').val('');
  $('.modal_reportes').fadeOut();
}





















//ver_usuario comprador
$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_comprador').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoComprador';
    $.ajax({
      url:'jquery_ventas/ventas.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
       success: function(response){
         console.log(response)
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.metodo_pago == 'Agregado a mi carrito') {
             $('.bodyModal_ver_comprador').html('<form class="form_add_producto" action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData_add_comprobante();">'+
                 '<h3>Fue agregado como interes al carrito de compras, por lo tanto no se agregado ningun pago</h3>'+
                 '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                   '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_comprador();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                 '</div>'+
                    '</form>');

           }else {


             $('.bodyModal_ver_comprador').html('<form class="form_add_producto" action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData_add_comprobante();">'+
             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">Información del usuario</h4>'+
             '<table style="width: 80%;margin: 0 auto;margin-top: 20px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin-bottom: 25px;padding: 5px;">'+
               '<tr>'+
                 '<td>Nombres:</td>'+
                 '<td>'+info.nombres_comprador+' '+info.apellidos_comprador+'</td>'+
               '</tr>'+
               '<tr>'+
                 '<td>Email:</td>'+
                 '<td>'+info.email_comprador+'</td>'+
               '</tr>'+
               '<tr>'+
                 '<td>whatsapp</td>'+
                 '<td>'+info.whatsapp+'</td>'+
               '</tr>'+

               '<tr>'+
                 '<td>Antiguedad:</td>'+
                 '<td>'+info.fecha_creacion+'</td>'+
               '</tr>'+
               '<tr>'+
                 '<td>ID:</td>'+
                 '<td>'+info.id_usuario+'</td>'+
               '</tr>'+
             '</table>'+

             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_comprador();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
                                 '</form>');

           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_ver_comprador').fadeIn();


  });

});



function closeModal_ver_comprador(){
  $('.foto').val('');
  $('.modal_ver_comprador').fadeOut();
}








//ver producto
$(document).ready(function(){
  $('.ver_producto_venta').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoproducto_venta';
    $.ajax({
      url:'jquery_ventas/ventas.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
       success: function(response){
         console.log(response)
         if (response != 'error') {
           var info = JSON.parse(response);
           var precio = info.precio;
           var comision = precio*0.03;
           var t_generado = precio*0.97;
           $('.bodyModal_ver_producto_venta').html('<form class="form_add_producto" action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData();">'+
           '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">Ver Producto de Venta #'+info.id+'</h4>'+
                 '<table style="text-align: center;width: 80%;margin: 0 auto;margin-top: 0px;margin-top: 10px;padding: 4px;margin-bottom: 25px;">'+
                   '<tr>'+
                     '<td>Nombre:</td>'+
                     '<td>'+info.nombre_producto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Valor Total:</td>'+
                     '<td>$'+info.precio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Transferencia:</td>'+
                     '<td>$'+t_generado+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Comision Retenida:</td>'+
                     '<td>$'+comision+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Tipo</td>'+
                     '<td>'+info.identificador_trabajo+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Fecha Venta:</td>'+
                     '<td>'+info.fecha+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Descripcion:</td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>'+
                 '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                   '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_comprador();" class=""><img style="width: 20px;display: inline-block;" src="img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                 '</div>'+
                  '</form>');



         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_ver_producto_venta').fadeIn();


  });

});




function closeModal_ver_producto(){
  $('.foto').val('');
  $('.modal_ver_producto_venta').fadeOut();
}
