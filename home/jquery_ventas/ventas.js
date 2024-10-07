(function(){
  $(function(){
    $('.entregar_producto_at').on('click',function(){
          var venta = $(this).attr('venta');
          var action = 'infoventa2';
          $.ajax({
            url:'jquery_ventas/ventas.php',
            type:'POST',
            async: true,
            data: {action:action,venta:venta},
             success: function(response){
              $('.accion_entregar_producto').modal();
               if (response != 'error') {
                 var info = JSON.parse(response);
                 console.log('ESTE ES EL ESTADO FISICO '+info.estado_fisico+'');
                  console.log('ESTE ES EL ESTADO FINANCIERO '+info.estado_financiero+'');
                 if (info.estado == 'Iniciada') {
                   if (info.estado_fisico == 'NO ENTREGADO') {
                     if (info.estado_financiero == 'PAGADO') {
                       $('.resultado_entrega_producto').html('<div class="row">'+
                           '<div class="col">'+
                             '<form name="add_comprobante" action="" method="post" id="entregar_producto" name="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                               '<p>Entrega el producto para que puedas realizar el cobro en 24 horas aproximadamente, esta acción se lo realiza para protegerte a ti y a tu cliente , gracias por usar nuestra tecnologia</p>'+
                               '<input type="hidden" name="action" value="entregar_producto">'+
                               '<input type="hidden" name="id_venta" value="'+info.id+'">'+
                              '<div class="modal-footer">'+
                              '<button type="submit" class="btn btn-primary">Entregar Producto</button>'+
                              '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                             '</div>'+
                             '<div class="contenedor_articulo">'+
                            ' </div>'+
                             '</form>'+
                           '</div>'+
                         '</div>');
                       console.log('esta venta ya esta pagadaa');

                     }
                     if (info.estado_financiero == 'Pago Verificado') {
                       $('.resultado_entrega_producto').html('<div class="row">'+
                           '<div class="col">'+
                             '<form name="add_comprobante" action="" method="post" id="entregar_producto" name="entregar_producto" onsubmit="event.preventDefault(); sendData_entregar_producto();">'+
                               '<p>Entrega el producto para que puedas realizar el cobro en 24 horas aproximadamente, esta acción se lo realiza para protegerte a ti y a tu cliente , gracias por usar nuestra tecnologia</p>'+
                               '<input type="hidden" name="action" value="entregar_producto">'+
                               '<input type="hidden" name="id_venta" value="'+info.id+'">'+
                               '<div class="contenedor_articulo">'+
                              ' </div>'+
                              '<button type="submit" class="btn btn-primary">Entregar Producto</button>'+
                              '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'+
                             '</form>'+
                           '</div>'+
                         '</div>');
                       console.log('esta venta ya esta pagada');

                     }
                     if (info.estado_financiero == 'VERIFICANDO') {
                       console.log('la venta se esta verificando');

                     }

                   }
                   if (info.estado_fisico == 'ENTREGADO') {
                     console.log('hhh');

                       $('.resultado_entrega_producto').html('<div class="row">'+
                                  ' <form name="add_comprobante" action="" method="post" id="" name="" onsubmit="event.preventDefault(); sendData_eliminar_producto_at();">'+
                                  '<div class="" style="padding: 12px;">'+
                                     '<h2>Este producto ya ha sido entregado</h2>'+
                                     '<p> muchas gracias por ocupar nuestra tecnología, revisa tu correo para que puedas guiarte con un documento que te enviamos con la orden deventa</p>'+
                                     '<div class="modal-footer">'+
                                     '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                    '</div>'+
                                   '</form>'+
                                ' </div>');

                   }

                 }
                 if (info.estado == 'Cancelada') {
                   $('.resultado_entrega_producto').html('<div class="row">'+
                              ' <form name="add_comprobante" action="" method="post" id="" name="" onsubmit="event.preventDefault(); sendData_eliminar_producto_at();">'+
                                 '<h2>No entregues el producto.</h2>'+
                                 '<p> Esta venta ha sido cancelada por el comprador ! no entregues el producto</p>'+
                                 '<div class="modal-footer">'+
                                 '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                '</div>'+
                               '</form>'+
                            ' </div>');


                 }
                 if (info.estado == 'Reportado') {
                   $('.resultado_entrega_producto').html('<div class="row">'+
                              ' <form name="add_comprobante" action="" method="post" id="" name="" onsubmit="event.preventDefault(); sendData_eliminar_producto_at();" style="padding: 15px;">'+
                                 '<h2>Esta venta ha sido reportada.</h2>'+
                                  '<p> Esta venta ha sido cancelada por el comprador ! no entregues el producto</p>'+
                                 '<div class="modal-footer">'+
                                 '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                '</div>'+
                               '</form>'+
                            ' </div>');

                 }

                 if (info.estado == 'Finalizada') {
                   $('.resultado_entrega_producto').html('<div class="row">'+
                              ' <form name="add_comprobante" action="" method="post" id="" name="" onsubmit="event.preventDefault(); sendData_eliminar_producto_at();">'+
                                 '<h2>Esta venta ya ha sido Finalizada, muchas gracias por usar nuestra tecnología, te recordamos que tienes los controles para realizar reportes y contrareportes.</h2>'+
                                 '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'+
                               '</form>'+
                            ' </div>');


                 }




               }
             },
             error:function(error){
               console.log(error);
               }

             });

    });


  });

}());




function sendData_entregar_producto(){
 $('.notificacion_eliminacion_aceptada_at').html(' <div class="notificacion_negativa">'+
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
        $('.notificacion_eliminacion_aceptada_at').html('<div class="alert alert-success" role="alert">Producto Entregado Correctamente, el usuario a recibir no tiene que realizar ningun reporte y en un lapso de 24 horas, puede relizar la solicitud de cobro!</div>');
        $('.entrga_venta'+info.id_venta+'').html('<p style="padding: 5px;">PRODUCTO ENTREGADO</p>');
      }

      if (info.noticia == 'estado_financiero_no_valido') {
        $('.notificacion_eliminacion_aceptada_at').html('<div class="alert alert-danger" role="alert">Estado financiero invalido!</div>');
      }
      if (info.noticia == 'error_insertar_sistema') {
        $('.notificacion_eliminacion_aceptada_at').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');
      }




      }

    }

  });

}




(function(){
  $(function(){
    $('.boton_principal_articulo').on('click',function(){
          var venta = $(this).attr('venta');
          var action = 'infoventa';
          $.ajax({
            url:'jquery_ventas/ventas.php',
            type:'POST',
            async: true,
            data: {action:action,venta:venta},
             success: function(response){
              $('.solicitar_pago').modal();
               if (response != 'error') {
                 var info = JSON.parse(response);
                 console.log('este es el identificador de trabajo '+info.identificador_trabajo+'  ');

                 if (info.identificador_trabajo == 'producto' || info.identificador_trabajo == 'evento_recaudacion') {
                   if (info.estado_reporte  == 'Activado') {

                     console.log('venta reportada uu');


                   }else {
                     if (info.solicitud_pago == 'PAGO EN PROCESO') {
                       console.log('pago en proceso');


                     }

                     if (info.solicitud_pago == 'POR SOLICITAR') {
                           if (info.estado_fisico == 'ENTREGADO') {
                             console.log('puede solciitar');
                             $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago_at" name="solicitar_pago_at" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO ID #'+info.id+'</h4>'+
                             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">'+
                             'Realiza la solicitud de pago para tener el dinero de esta venta en tu cuenta y posteriormente retirarlo en tus cuentas bancarias.</p>'+
                                '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                              '<input type="hidden" name="action" value="solicitar_pago" >'+
                              '<div class="tipo_cuenta_soli_pago">'+
                                '<select class="" name="tipo_banco_solicitud"  style="display: block;padding: 15px;margin: 25px;">'+
                                  '<option value="Mi Cuenta Leben">Guibis.com</option>'+
                                '</select> '+
                              '<button type="submit" class="btn btn-primary">Solicitar Pago</button>'+
                               '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                               '</form>');

                           }
                           if (info.estado_fisico == 'NO ENTREGADO') {
                             $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago_at" name="solicitar_pago_at" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO ID #'+info.id+'</h4>'+
                             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">'+
                             'No puede solicitar el pago debido a que no ha entregado el producto.</p>'+
                                '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                              '<input type="hidden" name="action" value="solicitar_pago" >'+
                              '<div class="form-group">'+
                                '<select class="form-control" name="tipo_banco_solicitud">'+
                                  '<option value="Mi Cuenta Leben">Guibis.com</option>'+
                                '</select> '+
                                '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                               '</div>'+
                               '<div class="entrega_producto_sistemaactualizado">'+
                              ' </div>'+
                               '</form>');

                           }

                     }
                     if (info.solicitud_pago == 'PAGADO') {
                       console.log('ya esta pagado');
                       $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago" name="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                           '<h4>Esta venta ya ha sido pagada, revisa tu cuenta digital, o tus correos</h4>'+
                           '<input type="hidden" name="id_venta" value="'+info.id+'" >'+

                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                         '</form>');


                     }



                   }


                 }
                 if (info.identificador_trabajo == 'servicio_suscripcion') {
                   if (info.estado_reporte  == 'Activado') {
                     $('.resultado_solicitud_pago').html('<div class="row">'+
                                ' <form name="add_comprobante" action="" method="post" id="" name="" onsubmit="event.preventDefault(); sendData_eliminar_producto_at();" style="padding: 15px;">'+
                                   '<h2>Esta venta ha sido reportada.</h2>'+
                                    '<p> Esta venta ha sido cancelada por el comprador ! no entregues el producto</p>'+
                                   '<div class="modal-footer">'+
                                   '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                  '</div>'+
                                 '</form>'+
                              ' </div>');
                     console.log('venta reportada');


                   }else {
                     if (info.solicitud_pago == 'PAGO EN PROCESO') {
                       console.log('pago en proceso');


                     }

                     if (info.solicitud_pago == 'POR SOLICITAR') {
                           if (info.estado_fisico == 'ENTREGADO') {
                             console.log('puede solciitar');
                             $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago_at" name="solicitar_pago_at" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO ID #'+info.id+'</h4>'+
                             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">'+
                             'Realiza la solicitud de pago para tener el dinero de esta venta en tu cuenta y posteriormente retirarlo en tus cuentas bancarias.</p>'+
                                '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                              '<input type="hidden" name="action" value="solicitar_pago" >'+
                              '<div class="form-group">'+
                                '<select class="form-control" name="tipo_banco_solicitud">'+
                                  '<option value="Mi Cuenta Leben">Guibis.com</option>'+
                                '</select> '+
                                '<div class="modal-footer">'+
                                '<button type="submit" class="btn btn-primary">Solicitar Pago</button>'+
                                '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                               '</div>'+
                               '<div class="entrega_producto_sistemaactualizado">'+
                              ' </div>'+
                               '</form>');

                           }
                           if (info.estado_fisico == 'NO ENTREGADO') {
                             $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago_at" name="solicitar_pago_at" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                             '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;">SOLICITUD DE PAGO ID #'+info.id+'</h4>'+
                             '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">'+
                             'No puede solicitar el pago debido a que no ha entregado el producto.</p>'+
                                '<input type="hidden" name="id_venta" value="'+info.id+'" >'+
                              '<input type="hidden" name="action" value="solicitar_pago" >'+
                              '<div class="form-group">'+
                                '<select class="form-control" name="tipo_banco_solicitud">'+
                                  '<option value="Mi Cuenta Leben">Guibis.com</option>'+
                                '</select> '+
                                '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                               '</div>'+
                               '<div class="entrega_producto_sistemaactualizado">'+
                              ' </div>'+
                               '</form>');
                             console.log('no puede solicitar primero tiene que entregad');

                           }

                     }
                     if (info.solicitud_pago == 'PAGADO') {
                       console.log('ya esta pagado');
                       $('.resultado_solicitud_pago').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago" name="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                           '<h4>Esta venta ya ha sido pagada, revisa tu cuenta digital, o tus correos</h4>'+
                           '<input type="hidden" name="id_venta" value="'+info.id+'" >'+

                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                         '</form>');


                     }



                   }

                 }





               }
             },
             error:function(error){
               console.log(error);
               }

             });

    });


  });

}());



function sendData_solicitar_pago_at (){
 $('.entrega_producto_sistemaactualizado').html(' <div class="notificacion_negativa">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#solicitar_pago_at')[0]);
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
        $('.notificacion_solicitud_pago').html('<div class="alert alert-success" role="alert">Venta Pagada Correctamente Revisa Tu cuenta digital y tu correo!</div>');
        $('.solicitud_pago'+info.id_venta+'').html('<div class="producto_entregado">'+
          '<p>PAGADO</p>'+
        '</div>');
      }

      if (info.noticia == 'venta_pagada_sin_acciones') {
        $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">Ya se ha realizado el pago revisa tu cuenta digital!</div>');
      }

        if (info.noticia == 'fecha_no_activa') {
            $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">No a pasado el tiempo requerido para que sea una compra segura, la fecha tope de solicitud es: '+info.fecha_activa+'!</div>');
        }
        if (info.noticia == 'reporte_activado') {
          $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">Esta venta tiene un reporte!</div>');
        }
      if (info.noticia == 'pagado_correctamente_en_proceso_pichincha') {
        $('.entrega_producto_sistemaactualizado').html('Pago en proceso a Banco Pichincha, esto no lleva mas de 5 minutos');
      }
      if (info.noticia == 'pagado_correctamente_en_proceso_guayaquil') {
        $('.entrega_producto_sistemaactualizado').html('Pago en proceso a Banco Guayaquil, esto no lleva mas de 5 minutos');
      }
      if (info.noticia == 'pagado_correctamente_en_proceso_produbanco') {
        $('.entrega_producto_sistemaactualizado').html('Pago en proceso a Banco Produbanco, esto no lleva mas de 5 minutos');
      }

      if (info.noticia == 'cuenta_vacia_produbanco') {
        $('.entrega_producto_sistemaactualizado').html('No tienes agregado una cuenta Produbanco en nuestra plataforma');
      }
      if (info.noticia == 'cuenta_vacia_guayaquil') {
        $('.entrega_producto_sistemaactualizado').html('No tienes agregado una cuenta Guayaquil en nuestra plataforma');
      }
      if (info.noticia == 'cuenta_vacia_pihincha') {
        $('.entrega_producto_sistemaactualizado').html('No tienes agregado una cuenta Pihincha en nuestra plataforma');
      }
      if (info.noticia == 'error_pago_servidor') {
        $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">Error en el servidor, comuniquese con un tecnico!</div>');
      }


      if (info.noticia == 'error_pago_servidor') {
        $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">Error en el servidor, comuniquese con un tecnico!</div>');
      }
      if (info.noticia == 'cuenta_inactiva') {
        $('.entrega_producto_sistemaactualizado').html('<div class="alert alert-danger" role="alert">Tienes tu cuenta digital innactiva, activale en Cuenta !</div>');

      }


      }

    }

  });

}



//VER REPORTES
(function(){
  $(function(){
    $('.btn_acc_reportes').on('click',function(){
          var venta = $(this).attr('venta');
          var action = 'inforeporte';

          $.ajax({
            url:'jquery_ventas/ventas.php',
            type:'POST',
            async: true,
            data: {action:action,venta:venta},
             success: function(response){
              $('.accion_reportes').modal();
               if (response != 'error') {
                 var info = JSON.parse(response);

                 if (info.noticia == 'sin_reporte' || info.estado_reporte == '' ) {
                   console.log('contrareporte activado');
                   $('.resultado_accion_reportes').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago" name="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                       '<h4>Esta venta no tiene reportes</h4>'+
                       '<input type="hidden" name="id_venta" value="'+info.id+'" >'+

                       '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                     '</form>');


                 }

                 if (info.estado_reporte == 'Activado') {
                   if (info.estado_contrareporte == 'Activado') {
                     $('.resultado_accion_reportes').html('  <form name="add_comprobante" action="" method="post" id="solicitar_pago" name="solicitar_pago" onsubmit="event.preventDefault(); sendData_solicitar_pago_at();">'+
                         '<h4>Ya se ha realizado un contra reporte de esta venta</h4>'+
                         '<div class="modal-footer">'+
                         '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                        '</div>'+
                       '</form>');

                   }else {
                     $('.resultado_accion_reportes').html('<form class="form_add_producto" action="" method="post" name="reportar_reporte" id="reportar_reporte" onsubmit="event.preventDefault(); sendData_reportar_reporte();">'+
                         '<h4>Resumen del Reporte Realizado</h4>'+
                         '<div class="row">'+
                              '<div class="col-12">'+
                                  '<div class="table-responsive">'+
                                    '  <table class="table table-bordered">'+
                                          '<thead>'+
                                              '<tr>'+
                                                  '<th>Imagen del Reporte</th>'+
                                                  '<th>Tipo Reporte</th>'+
                                                  '<th>Fecha Reporte</th>'+
                                                  '<th>Descripcion Reporte</th>'+
                                              '</tr>'+
                                          '</thead>'+
                                          '<tbody>'+
                                              '<tr>'+
                                                  '<td><a target="_blank" href="img/reportes/'+info.img_reporte+'"><img src="img/reportes/'+info.img_reporte+'" alt="" width="150px"></a></td>'+
                                                  '<td>'+info.tipo_reporte+'</td>'+
                                                  '<td>'+info.fecha_reporte+'</td>'+
                                                  '<td>'+info.descripcion_reporte+'</td>'+
                                              '</tr>'+
                                          '</tbody>'+
                                      '</table>'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+

                          '<div class="form-group">'+
                            '<label for="exampleFormControlFile1">Agrega evidencia</label>'+
                            '<input type="file"  name="foto" id="foto" accept="image/png, .jpeg, .jpg" required  class="form-control-file">'+
                          '</div>'+
                          '<div class="form-group">'+
                            '<label for="exampleFormControlTextarea1">Agrega una descripción</label>'+
                            '<textarea class="form-control" required name="descripcion_reporte" id="exampleFormControlTextarea1" rows="3"></textarea>'+
                          '</div>'+
                          '<div class="form-group">'+
                            '<label for="exampleFormControlInput1">Ingresa tu contraseña</label>'+
                            '<input type="password" name="password" required class="form-control" id="exampleFormControlInput1" placeholder="Ingresa tu contraseña">'+
                          '</div>'+
                         '<div class="modal-footer">'+
                         '<input  type="hidden" name="action" value="reportar_reporte"  required><br>'+
                         '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
                         '<button type="submit" class="btn btn-primary">Realizar Contra Reporte</button>'+
                         '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                        '</div>'+
                        '<div class="alerta_reporte_reporte">'+
                        '</div>'+
                       '</form>');

                   }




                 }




                   if (info.estado_contrareporte == 'Activado') {
                     console.log('contrareporte activado');


                   }







               }
             },
             error:function(error){
               console.log(error);
               }

             });

    });


  });

}());




function sendData_reportar_reporte(){
  $('.alerta_reporte_reporte').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
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
        $('.alerta_reporte_reporte').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'venta_recontrareportada') {
        $('.alerta_reporte_reporte').html('<div class="alert alert-success" role="alert">Venta Contra Reportada!</div>');

      }
      if (info.noticia == 'Error_reportar_venta') {
        $('.alerta_reporte_reporte').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }
      if (info.noticia == 'Error_password') {
        $('.alerta_reporte_reporte').html('<div class="alert alert-danger" role="alert">Error en credenciales!</div>');

      }


      }

    }

  });

}
