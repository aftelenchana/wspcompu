
//Ver mi prodcuto en historial de compras

$(document).ready(function(){
  $('.ver_producto_historial').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoproducto';
    $.ajax({
      url:'jquery_historial_compra/historial.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},

       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.identificador_trabajo == 'sorteos') {
             $('.bodyModal_ver_producto_compra').html('<form class="form_ver_product" action="" method="post" name="add_form_ver_producto" id="add_form_ver_producto" onsubmit="event.preventDefault();" >'+
                     '<div class="titu_info">'+
                       '<h4>informacion del producto</h4>'+
                       '<div class="sorteo_historial">'+
                         '<form class="" action="" method="post">'+
                           '<div class="respuesta_sistema">'+
                             '<h3 class="">Pagado Correctamente</h3>'+
                           '</div>'+
                           '<div class="contendor_boleto_sorteo">'+
                             '<div class="img_boleto_historial">'+
                             '<div class="img_boleto_tt id="img_boleto_tt""></div>'+
                               '<h3>$25.12</h3>'+
                             '</div>'+
                             '<div class="informacion_boleto">'+
                               '<table>'+
                                 '<h3>Sorteo de solidadridad Pepito</h3>'+
                                 '<tr>'+
                                   '<td>Nombres:</td>'+
                                   '<td>'+info.nombres+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Apellidos</td>'+
                                   '<td>'+info.apellidos+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Identidad</td>'+
                                   '<td>'+info.numero_identidad+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Celular</td>'+
                                   '<td>'+info.whatsapp+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Fecha Sorteo</td>'+
                                   '<td>'+info.fecha_sorteo+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Hora Sorteo</td>'+
                                   '<td>'+info.hora_sorteo+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Organizador</td>'+
                                   '<td>Fernando Chango</td>'+
                                 '</tr>'+
                               '</table>'+
                               '<br>'+
                             '</div>'+
                             '<div class="qr_venta_usuario_comprador">'+
                               '<img src="img/qr/'+info.qr_venta+'" alt="">'+
                               '<br><br><br><br>'+
                             '</div>'+
                           '</div>'+
                         '</form>'+
                         '<div class="codigo_sorteo">'+
                           '<p>'+info.codigo_venta+'</p>'+
                         '</div>'+
                         '<div class="redes_sorteo">'+
                           '<div class="redes_y"><a href="#"> <img src="img/reacciones/facebook.png" alt=""> </a></div>'+
                           '<div class="redes_y"><a href="#"> <img src="img/reacciones/facebook.png" alt=""> </a></div>'+

                           '<div class="redes_y"><a href="#"> <img src="img/reacciones/facebook.png" alt=""> </a></div>'+
                         '</div>'+
                       '</div><br><br>'+
                       '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                       '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_producto();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                       '</div>'+
                     '</div>'+
                    '</form>');
                    var producto = info.idp;
                    var action = 'infoproducto';
                    $.ajax({
                      url:'jquery/mis_productos.php',
                      type:'POST',
                      async: true,
                      data: {action:action,producto:producto},

                       success: function(response){
                         if (response != 'error') {
                           var info = JSON.parse(response);
                             $('.img_boleto_tt').html('<img src="img/uploads/'+info.foto+'" alt="">');

                         }
                       },
                       error:function(error){
                         console.log(error);
                         }

                       });

           }
           if (info.identificador_trabajo == 'evento') {
             $('.bodyModal_ver_producto_compra').html('<form class="form_ver_product" action="" method="post" name="add_form_ver_producto" id="add_form_ver_producto" onsubmit="event.preventDefault();" >'+
                     '<div class="titu_info">'+
                       '<h2>Información de Entrada</h2>'+
                       '<div class="sorteo_historial">'+
                         '<form class="" action="" method="post">'+
                           '<div class="contendor_boleto_sorteo">'+
                             '<div class="img_boleto_historial">'+
                               '<div class="img_boleto_tt id="img_boleto_tt""><img src="img/uploads/'+info.foto+'" alt="" width="50px;"></div>'+
                               '<h3>$'+info.precio+'</h3>'+
                             '</div>'+
                             '<div class="informacion_boleto">'+
                               '<table style="margin: 0 auto;">'+
                                 '<h3>'+info.nombre_producto+'</h3>'+
                                 '<tr>'+
                                   '<td>Nombres:</td>'+
                                   '<td>'+info.nombres+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Apellidos:</td>'+
                                   '<td>'+info.apellidos+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Identidad:</td>'+
                                   '<td>'+info.numero_identidad+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Celular:</td>'+
                                   '<td>'+info.whatsapp+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Fecha Sorteo:</td>'+
                                   '<td>'+info.fecha_evento+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Hora Sorteo:</td>'+
                                   '<td>'+info.hora_evento+'</td>'+
                                 '</tr>'+
                                 '<tr>'+
                                   '<td>Fecha de Compra:</td>'+
                                   '<td>'+info.fecha_compra+'</td>'+
                                 '</tr>'+
                               '</table>'+
                               '<br>'+
                             '</div>'+
                             '<div class="qr_venta_usuario_comprador">'+
                               '<img src="img/qr/'+info.qr_venta+'" alt="">'+
                             '</div>'+
                           '</div>'+
                         '</form>'+
                       '</div>'+
                       '<div style="display: inline-block;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;" class=""><a href="img/qr_eventos/'+info.qr_venta+'" download>Descargar Entrada Digital</a></div>'+
                       '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                       '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_producto();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                       '</div>'+
                     '</div>'+
                    '</form>');



           }

           if (info.identificador_trabajo == 'servicios') {
             $('.bodyModal_ver_producto_compra').html('<div class="contendor_historial_producto">'+
                 '<form class="body" action="" method="post">'+
                   '<div class="respuesta_sistema">'+
                     '<h3 class="">Pagado Correctamente</h3>'+
                   '</div>'+
                   '<div class="img_producto_historial">'+
                     '<img src="img/uploads/'+info.foto+'" alt="">'+
                   '</div>'+
                   '<div class="tabla_contenedor">'+
                     '<table>'+
                       '<tr>'+
                         '<td>Id</td>'+
                         '<td>'+info.id+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Producto:</td>'+
                         '<td>'+info.nombre_producto+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Precio</td>'+
                         '<td>'+info.precio+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Nombres</td>'+
                         '<td>'+info.nombres+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Apellidos</td>'+
                         '<td>'+info.apellidos+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Celular</td>'+
                         '<td>'+info.whatsapp+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Email</td>'+
                         '<td>'+info.email+'</td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Redes</td>'+
                         '<td>'+
                           '<div class="redes facebook_vie"></div>'+
                           '<div class="redes whatsapp_vie"></div>'+
                           '<div class="redes instagram_vie"></div>'+
                          '</td>'+
                       '</tr>'+
                     '</table>'+
                   '</div>'+
                   '<div class="img_qr_historial">'+
                     '<div class="qr_image qr_logo">'+
                       '<img src="img/qr/qr.png" alt="">'+
                     '</div>'+
                     '<div class="qr_image qr_logo">'+
                       '<a href="#"><img src="img/qr/qr.png" alt=""></a>'+
                     '</div>'+
                   '</div>'+
                   '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                   '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_producto();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                   '</div>'+
                 '</form>'+
               '</div>');
               if (info.facebook != '') {
                   $('.facebook_vie').html('<a href="'+info.facebook+'"> <img src="img/reacciones/facebook.png" alt=""> </a>');
               }
               if (info.whatsapp != '') {
                   $('.whatsapp_vie').html('<a href="'+info.whatsapp+'"> <img src="img/reacciones/whatsapp.png" alt=""> </a>');
               }
               if (info.instagram != '') {
                   $('.instagram_vie').html('<a href="'+info.instagram+'"> <img src="img/reacciones/instagram.png" alt=""> </a>');
               }

           }
           if (info.identificador_trabajo == 'producto') {
             $('.bodyModal_ver_producto_compra').html('<form class="body" action="" method="post">'+
             '<h3>Informacion del Producto</h3>'+
             '<div class="informacion_producto_historial_compra">'+
               '<div class="imagen_producto">'+
                 '<img src="img/uploads/'+info.foto+'" alt="">'+
               '</div>'+
               '<div class="tabla_informacion_prod_hist">'+
                 '<table>'+
                   '<tr>'+
                     '<td>Nombre:'+info.nombre_producto+'</td>'+
                     '<td>Precio :$ '+info.precio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Marca:</td>'+
                     '<td>'+info.marca+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Ciudad: '+info.ciudad2+'</td>'+
                     '<td>Provincia: '+info.provincia2+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Categorias: '+info.categorias+'</td>'+
                     '<td>Subcategorias: '+info.subcategorias+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Empresa:'+info.nombre_empresa+'</td>'+
                     '<td>Tipo: '+info.identificador_trabajo+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Redes: </td>'+
                     '<td class="redes_sociales_historial" >'+
                     '<div class="redes facebook">'+
                     '<a target="_blank" href="'+info.facebook+'"><img src="img/reacciones/facebook.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '<div class="redes instagram">'+
                     '<a target="_blank" href="'+info.instagram+'"><img src="img/reacciones/instagram.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '<div class="redes whatsapp">'+
                     '<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Leben&nbsp;https://leben-ec.com/vista-general-producto.php?idp='+info.idproducto+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>'+
                     '</div>'+
                    '</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Descripcion: </td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>'+
               '</div>'+
             '</div>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
             '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_producto();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
        '</form>');
        if (info.facebook == '') {
          $('.facebook').html();
        }
        if (info.instagram == '') {
          $('.instagram').html();
        }
        if (info.whatsapp == '') {
          $('.whatsapp').html();
        }


           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_producto_compra').fadeIn();

  });

});

function closeModaleditt_ver_producto(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_ver_producto_compra').fadeOut();
}



//Ver metodo pago

$(document).ready(function(){
  $('.ver_orden_historial').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoventa_producto';
    $.ajax({
      url:'jquery_historial_compra/historial.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},

       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.metodo_pago == 'Mi Leben') {
             $('.bodyModal_ver_orden').html('<form class="body" action="" method="post">'+
             '<h4>Metodo de Pago: '+info.metodo_pago+'</h4>'+
             '<div class="informacion_metodo_pago">'+
               '<p>El producto '+info.nombre_producto+' con un precio de <span> $'+info.precio+' </span> en la ciudad de Ambato se realizo mediante el metodo de pago con cuenta  Leben la fecha de '+info.fecha_compra+' lo cual'+
               'tiene un lapso de 6 horas para poder realizar un reporte y que el dinero sea devuelto a la cuenta principal, el reporte debe de der sustentado para no suspender la cuenta del titular</p>'+
             '</div>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
             '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_orden();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
             '</form>');

           }
           if (info.metodo_pago == 'Agregado a mi  Carrito') {
             $('.bodyModal_ver_orden').html('<form class="body" action="" method="post">'+
             '<h4>Metodo de Pago: '+info.metodo_pago+'</h4>'+
             '<div class="informacion_metodo_pago">'+
               '<p>El producto '+info.nombre_producto+' con un precio de <span> $'+info.precio+' </span> en la ciudad de '+info.ciudad2+' no se realizo ningun  pago,la fecha de '+info.fecha_compra+' lo cual'+
               'tiene que agregar el pago </p>'+
             '</div>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
             '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_orden();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
             '</form>');

           }
           if (info.metodo_pago == 'Comprobante') {
             $('.bodyModal_ver_orden').html('<form class="body" action="" method="post">'+
             '<h4>Metodo de Pago: '+info.metodo_pago+'</h4>'+
             '<div class="informacion_metodo_pago">'+
               '<p>El producto '+info.nombre_producto+' con un precio de <span> $'+info.precio+' </span> en la ciudad de '+info.ciudad2+'  se realizo  el  pago,la fecha de '+info.fecha_compra+' lo cual'+
               'entra en un proceso de verificacion, en la caso de que la informacion proporcionada se falsa se desactivara tu cuenta </p>'+
             '</div>'+
             '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
             '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_ver_orden();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
             '</div>'+
             '</form>');

           }
           console.log(info.metodo_pago);

         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_orden').fadeIn();

  });

});

function closeModal_ver_orden(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_ver_orden').fadeOut();
}




//Detalles de la compra

$(document).ready(function(){
  $('.ver_entrega_historial').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'detalles_compra';
    $.ajax({
      url:'jquery_historial_compra/historial.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},

       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.identificador_trabajo == 'producto') {
             $('.bodyModal_ver_entrega').html('<form class="body" action="" method="post">'+
             '<div class="titu_info">'+
               '<h4>Detalles de Compra de '+info.nombre+'</h4>'+
               '<div class="informacion_metodo_pago">'+
                 '<p>El producto '+info.nombre+' con un precio de <span> $'+info.precio+' </span>'+
                 'la fecha de inicio de la compra es '+info.fecha_inicio_venta+', el estado economico de tu venta es '+info.estado_financiero+', la persona que compraste este producto tiene estado  '+info.estado_fisico+', lo cual segun nuestras normas tiene fecha tope de entrega '+
                 ' '+info.fecha_tope_venta+' para entregar el producto,el comprador tiene que cambiar de estado a producto Entregado si todavia no te han entregado el producto, o el producto esta en mal estado realiza un reporte para la devolcucion del dinero '+
                 '</p>'+
               '</div>'+
               '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_entrega();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
               '</div>'+
              '</div>'+
             '</form>');

           }
           if (info.identificador_trabajo == 'evento') {
             $('.bodyModal_ver_entrega').html('<form class="body" action="" method="post">'+
             '<div class="titu_info">'+
               '<h4>Detalles de Compra de '+info.nombre+'</h4>'+
               '<div class="informacion_metodo_pago">'+
                 '<p>El producto '+info.nombre+' con un precio de <span> $'+info.precio+' </span>'+
                 'la fecha de inicio de la compra es '+info.fecha_inicio_venta+', el estado economico de tu venta es '+info.estado_financiero+', la persona que compraste este producto tiene estado  '+info.estado_fisico+', lo cual segun nuestras normas tiene fecha tope de entrega '+
                 ' '+info.fecha_tope_venta+' para entregar el producto,el comprador tiene que cambiar de estado a producto Entregado si todavia no te han entregado el producto, o el producto esta en mal estado realiza un reporte para la devolcucion del dinero '+
                 '</p>'+
               '</div>'+
               '<a class="btn_ok " href="consola-compra-evento.php?entrada='+info.id+'">Ver Consola de Compra</a>'+
               '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_entrega();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
               '</div>'+
              '</div>'+
             '</form>');
           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_entrega').fadeIn();

  });

});

function closeModaleditt_ver_entrega(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_ver_entrega').fadeOut();
}



//Reportar un problema

$(document).ready(function(){
  $('.solicitar_entrega_historial').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'infoventa_reporte';
        $('#exampleModalLong').modal();
    $.ajax({
      url:'jquery_historial_compra/historial.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);

           console.log('este es el estado fisico de la entrega :'+info.estado_fisico+'  ');

              console.log('este es el estado general de la venta  :'+info.estado+'  ');
           if (info.estado_fisico == 'NO ENTREGADO') {
             if (info.estado == "Iniciada") {
               $('.respuesta_reporte_problemas').html('<form class="form_ver_product" action="" method="post" name="add_reportar_problema" id="add_reportar_problema" onsubmit="event.preventDefault(); sendData_reportar_problema();" >'+
               '<h4>Realizar Cancelación de Compra de la venta ID #'+info.id+'</h4></h4>'+
                           '<div class="form-group">'+
                               '<label for="exampleFormControlInput1">Ingresa tu Contraseña</label>'+
                               '<input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="">'+
                           '</div>'+
                           '<div class="modal-footer">'+
                           '<input  type="hidden" name="action" value="cancelar_compra"  required><br>'+
                           '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
                           '<button type="submit" class="btn btn-primary">Cancelar la Compra</button>'+
                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                          '</div>'+
                          '<div class="alerta_reporte_final">'+
                         ' </div>'+
                       '</form>');
             }
             if (info.estado == "Cancelada") {
               var precio = info.precio;
               var cantidad_producto = info.cantidad_producto;
               var porcentaje = (cantidad_producto*precio*0.03).toFixed(2);
               var devolucion = (cantidad_producto*precio*0.97).toFixed(2);
               $('.respuesta_reporte_problemas').html('<form class="form_ver_product" action="" method="post" name="add_reportar_problema" id="add_reportar_problema" onsubmit="event.preventDefault(); sendData_reportar_problema();" >'+
               '<h4>Cancelación de Compra Exitosa </h4></h4>'+
               '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">Hola <span style="color: #900C3F;font-weight: bold;">'+info.nombres+' '+info.apellidos+'</span>, soy el sistema de reportes de Guibis.com tu compra ha sido cancelada por tu parte el <span style="color: #900C3F;font-weight: bold;">'+info.fecha_cancelacion_venta+'</span>, de '+info.nombre_producto+' de '+info.cantidad_producto+' unidades '+
                ' el porcentaje de retención de nuestro sistema es del 3% es decir el total del valor de retencion es de <span style="border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 5px;padding: 2px;background: #CF6932;">($'+porcentaje+')</span>  por lo tanto '+
                 'se ejecutó la devolución de <span style="border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 5px;padding: 2px;background:#2CB52C;"> $'+devolucion+'</span> a tu cuenta Guibis. </p>'+
                           '<div class="modal-footer">'+
                           '<input  type="hidden" name="action" value="cancelar_compra"  required><br>'+
                           '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                          '</div>'+
                          '<div class="alerta_reporte_final">'+
                         ' </div>'+
                       '</form>');



             }

             if (info.estado == "Finalizada") {
               $('.bodyModal_ver_solicitar_entrega').html('<form class="form_ver_product" action="" method="post" name="add_reportar_problema" id="add_reportar_problema" onsubmit="event.preventDefault(); sendData_reportar_problema();" >'+
               '<h4>Venta Finalizada</h4>'+
               '<input  type="hidden" name="action" value="cancelar_compra"  required><br>'+
               '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
               '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
               '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_solicitar();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
               '</div>'+
               '</form>');
             }

           }
           if (info.estado_fisico == 'ENTREGADO') {
             console.log('ffrdfvvf');
             if (info.estado == 'Reportado') {


               $('.respuesta_reporte_problemas').html('<form class="form_ver_product" action="" method="post" name="add_reportar_problema" id="add_reportar_problema" onsubmit="event.preventDefault(); sendData_reportar_problema();" >'+
                '<h4 style="font-size: 25px;background: #232F3E;color: #fff;padding: 6px;"> Compra Reportada ID #'+info.id+'</h4>'+
                '<p style="text-align: justify;padding: 9px;border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 10px;">Hola <span style="color: #900C3F;font-weight: bold;">'+info.nombres+' '+info.apellidos+'</span>, soy el sistema de reportes de Guibis.com tu compra ha sido Reportada por tu parte el <span style="color: #900C3F;font-weight: bold;">'+info.fecha_reporte+'</span>, de '+info.nombre_producto+' de '+info.cantidad_producto+' unidades'+
                 ' con fecha limite <span style="border-color: #4C5484;border-width: 1px;border-style: solid;border-radius: 9px;margin: 5px;padding: 2px;background: #CF6932;"> '+info.fecha_final_reporte+' </span>  con descripcion'+
                  '<span style="border-color: #4C5484;"> '+info.descripcion_reporte+'</span></p>'+
                           '<div class="modal-footer">'+
                           '<input  type="hidden" name="action" value="cancelar_compra"  required><br>'+
                           '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                          '</div>'+
                          '<div class="alerta_reporte_final">'+
                         ' </div>'+
                       '</form>');

             }
             if (info.estado == 'Iniciada') {
               $('.respuesta_reporte_problemas').html('<form class="form_ver_product" action="" method="post" name="add_reportar_problema" id="add_reportar_problema" onsubmit="event.preventDefault(); sendData_reportar_problema();" >'+
               '<h4>Reportar un Problema de la venta ID #'+info.id+'</h4></h4>'+
                         '<div class="form-group">'+
                             '<label for="exampleFormControlSelect1">Selecciona el tipo de Reporte</label>'+
                             '<select class="form-control" id="exampleFormControlSelect1"  name="tipo_reporte">'+
                               '<option value="Producto No Entregado" >Producto No Entregado</option>'+
                               '<option value="Producto En mal Estado">Producto En mal Estado</option>'+
                               '<option value="Otro">Otro</option>'+
                             '</select>'+
                           '</div>'+
                           '<div class="form-group">'+
                             '<label for="exampleFormControlFile1">Agrega Evidencias</label>'+
                             '<input type="file" name="foto" accept="image/png, .jpeg, .jpg" required class="form-control-file" id="exampleFormControlFile1">'+
                           '</div>'+
                           '<div class="form-group">'+
                             '<label for="exampleFormControlTextarea1">Describe tu Reporte</label>'+
                             '<textarea class="form-control" id="exampleFormControlTextarea1" name="descripcion_reporte" rows="3"></textarea>'+
                           '</div>'+
                           '<div class="form-group">'+
                               '<label for="exampleFormControlInput1">Ingresa tu Contraseña</label>'+
                               '<input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="">'+
                           '</div>'+
                           '<div class="modal-footer">'+
                           '<input  type="hidden" name="action" value="reporte_problema"  required>'+
                           '<input  type="hidden" name="venta" value="'+info.id+'"  required><br>'+
                           '<button type="submit" class="btn btn-primary">Reportar Problema</button>'+
                           '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                          '</div>'+
                          '<div class="alerta_reporte_final">'+
                         ' </div>'+
                       '</form>');
             }



           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_solicitar_entrega').fadeIn();

  });

});
function sendData_reportar_problema(){
    $('.alerta_reporte_final').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
  var parametros = new  FormData($('#add_reportar_problema')[0]);
  $.ajax({
    data: parametros,
      url:'jquery_historial_compra/historial.php',
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
      if (info.noticia  =='Error_password') {
        $('.alerta_reporte_final').html('<div class="alert alert-danger" role="alert">Error en credenciales!</div>');
      }
      if (info.noticia  =='venta_cancelada') {
        $('.alerta_reporte_final').html('<div class="alert alert-success" role="alert">Venta Cancelada Correctamente!</div>');
        $('.estado'+info.id_venta+'').html('Cancelada');


      }
      if (info.noticia  =='venta_reportada') {
        $('.alerta_reporte_final').html('<div class="alert alert-success" role="alert">Venta Reportada Correctamente!</div>');
        $('.estado'+info.id_venta+'').html('Reportado');

      }



      }

    }

  });

}

function closeModal_solicitar(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_ver_solicitar_entrega').fadeOut();
}
