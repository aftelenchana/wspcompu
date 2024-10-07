$(document).ready(function(){
  $("#tipo_reporte").change(function(){
    var tipo_reporte = $("#tipo_reporte").val();
      console.log(tipo_reporte);
      if (tipo_reporte =='General') {
        $(".contenedor_iconos_acciones").html('<a class="btn btn-danger" href="pdf/generar_reporte_ventas_restaurant_general.php"><i class="fas fa-file-pdf"></i></a>');
      }
      if (tipo_reporte =='Diario') {
        $(".contenedor_iconos_acciones").html('<a class="btn btn-danger" href="pdf/generar_reporte_ventas_restaurant_diario.php"><i class="fas fa-file-pdf"></i></a>');
      }
      if (tipo_reporte =='Fecha') {
        $(".contenedor_iconos_acciones").html('<div class="formulario_respuesta_fechas">'+
          '<form class="" action="pdf/generar_reporte_ventas_restaurant_fecha.php" method="get">'+
            '<div class="form-group">'+
            '<label for="exampleFormControlInput1">Elije una Fecha</label>'+
            '<input type="date" required name="fecha1" class="form-control" id="exampleFormControlInput1">'+
          '</div>'+
          '<div class="form-group">'+
          '<label for="exampleFormControlInput1">Elije una Segunda Fecha</label>'+
          '<input type="date" required name="fecha2" class="form-control" id="exampleFormControlInput1">'+
        '</div>'+
        '<button style="float: right;" type="submit" class="btn btn-info">Generar Reporte</button>'+
          '</form>'+
        '</div>');
      }




  });

});




//Agregar nuevo producto
$(document).ready(function(){
  $('.cobrar_pedido').click(function(e){
  var idrolpuntoventa = $(this).attr('idrolpuntoventa');
  $('#idrolpuntoventa').val(idrolpuntoventa);
  var secuencial_cuenta = $(this).attr('secuencial_cuenta');
    $('#secuencial_cuenta').val(secuencial_cuenta);
   $('#modal_cobro_cuenta').modal();
    var action = 'informacion_pedido';
    $.ajax({
      url:'jquery_empresa/cobrar_pedidos.php',
      type:'POST',
      async: true,
      data: {action:action,secuencial_cuenta:secuencial_cuenta,idrolpuntoventa:idrolpuntoventa},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
             $('.informacion_gn_pedidos').html(info.fial_pedidos);
             $('.resultado_resumen_pago_orden').html(info.resumen_pago_orden);
             $('.codigo_mesa_orden').html(info.codigo_mesa);


         }
       },
       error:function(error){
         console.log(error);
         }
       });



  });

});







function sendData_procesar_pedido_facturar(){
  $('.notificacion_envio_pedido').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#procesar_pedido_facturar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/cobrar_pedidos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {

        if (info.tipo_documento_digital == 'Factura') {
          var cliente = 1;;
          var action = 'genear_factura_y_nota_credito';
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_venta.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);
              if (info.noticia == 'logo_vacio') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }else {
                if (info.noticia == 'imagen_invalida') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">Sube una imagen valida  en formato png, jpg, jpeg   <a href="cuenta.php">Aqui</a>!</div>')

                }
              }
              if (info.noticia == 'cedula_vacia') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'nombre_vacio') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }

              if (info.noticia == 'factura_exitosa') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert">Factura generada y enviada con exito se ha limpiado la consola puedes mirarla <a target="_blank" download href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf"><img src="img/reacciones/pdf.png" width="40px" alt=""></a> y la nota de venta aqui  <a target="_blank" download href="facturacion/facturacionphp/comprobantes/nota_venta/'+info.factura+'.pdf"><img src="img/reacciones/pdf.png" width="40px" alt=""></a>  !</div>')

              }



              if (info.noticia == 'clave_duplicada') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

              }
              if (info.noticia == 'error_devuelta') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

              }
              if (info.noticia == 'sri_fuera') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')

              }
              if (info.noticia == 'no_se_puede_firmar') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> No se puede firmar el documento error interno comuniquese con el Admnistrador. </div>')

              }
              if (info.noticia == 'no_autorizado') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> NO AUTORIZADO, mensaje: '+info.mensaje+' </div>')

              }
              if (info.noticia == 'error_envio_email') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Error al enviar el emal, puedes reenviar las facturas en facturas autorizadas</div>')

              }
              if (info.noticia == 'error_path') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Error 1124 comuniquese con el Administrador</div>')

              }
              if (info.noticia == 'generador_pdf') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert"> Mirar el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a></div>')

              }

            },

             });
        }


        if (info.tipo_documento_digital == 'Factura y Nota de Venta') {
          var cliente = '1';
          var action = 'genear_factura_y_nota_credito';
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_venta.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);
              if (info.noticia == 'logo_vacio') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }else {
                if (info.noticia == 'imagen_invalida') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">Sube una imagen valida  en formato png, jpg, jpeg   <a href="cuenta.php">Aqui</a>!</div>')

                }
              }
              if (info.noticia == 'cedula_vacia') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'nombre_vacio') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'factura_exitosa') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert">Factura generada y enviada con exito se ha limpiado la consola puedes mirarla <a target="_blank" download href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf"><img src="img/reacciones/pdf.png" width="40px" alt=""></a> y la nota de venta aqui  <a target="_blank" download href="facturacion/facturacionphp/comprobantes/nota_venta/'+info.factura+'.pdf"><img src="img/reacciones/pdf.png" width="40px" alt=""></a>  !</div>')
              }
              if (info.noticia == 'clave_duplicada') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

              }
              if (info.noticia == 'error_devuelta') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

              }
              if (info.noticia == 'sri_fuera') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')

              }
              if (info.noticia == 'no_se_puede_firmar') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> No se puede firmar el documento error interno comuniquese con el Admnistrador. </div>')

              }
              if (info.noticia == 'no_autorizado') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> NO AUTORIZADO, mensaje: '+info.mensaje+' </div>')

              }
              if (info.noticia == 'error_envio_email') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Error al enviar el emal, puedes reenviar las facturas en facturas autorizadas</div>')

              }
              if (info.noticia == 'error_path') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert"> Error 1124 comuniquese con el Administrador</div>')

              }
              if (info.noticia == 'generador_pdf') {
                $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert"> Mirar el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a></div>')

              }





            },

             });
        }


        if (info.tipo_documento_digital == 'Ticket') {

          var cliente = 1;;
          var action = 'Generar_tiket';
          $.ajax({
          url: 'facturacion/facturacionphp/controladores/ctr_nota_venta.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'logo_vacio') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert">Comprobante enviado Correctamente!</div>')

                }


            },

             });
        }



        if (info.tipo_documento_digital == 'Proforma') {

          var cliente = 1;;
          var action = 'Generar_tiket';
          $.ajax({
          url: 'facturacion/facturacionphp/controladores/ctr_proforma.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'logo_vacio') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-success" role="alert">Comprobante generado Imprime y Entrega al Cliente!</div>')

                }
                if (info.noticia =='pdf_generado') {
                  $('.notificacion_envio_pedido').html('<div class="alert alert-warning" role="alert">mira el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/proformas/pdf/'+info.pdf+'">Generado Aqui</a> !</div>')

                }


            },

             });
        }


      }
      if (info.noticia == 'vacio') {
      $('.notificacion_envio_pedido').html('<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>');

      }



      //var info = JSON.parse(response);


    }

  });
}
