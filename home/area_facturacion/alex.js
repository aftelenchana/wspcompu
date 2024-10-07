
function sendData_descarga_masiva(){
  $('.notificacion_descarga').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#descarga_masiva')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/descargar.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_descarga').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_descarga').html('<div class="notio_positiva" ><p style="background: green;width: 50%;margin: 0 auto;padding: 5px;">'+info.descargas+' Descargados</p></div>');

      }
      if (info.noticia == 'vacio') {
      $('.notificacion_descarga').html('<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>');

      }

      }

    }

  });
}


function sendData_enviar_facturar(){
  $('.notificacion_facturacion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#enviar_facturar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/resumen_pago.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_facturacion').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        if (info.tipo_documento_digital == 'Factura') {
          var cliente = 1;;
          var action = 'genear_factura';
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_venta.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);
              if (info.noticia == 'logo_vacio') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }else {
                if (info.noticia == 'imagen_invalida') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">Sube una imagen valida  en formato png, jpg, jpeg   <a href="cuenta.php">Aqui</a>!</div>')

                }
              }
              if (info.noticia == 'cedula_vacia') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'nombre_vacio') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'factura_exitosa') {
                $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Factura generada y enviada con exito se ha limpiado la consola puedes mirarla <a href="factura.php?factura='+info.factura+'">Aqui</a> !</div>')

              }
              if (info.noticia == 'clave_duplicada') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

              }
              if (info.noticia == 'error_devuelta') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

              }
              if (info.noticia == 'sri_fuera') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')
              }

              if (info.noticia == 'identificacion_invalida') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">El número de identificacion debe ser cédula o Ruc. </div>')
              }


              if (info.noticia == 'no_se_puede_firmar') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> No se puede firmar el documento error interno comuniquese con el Admnistrador. </div>')

              }
              if (info.noticia == 'no_autorizado') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> NO AUTORIZADO, mensaje: '+info.mensaje+' </div>')

              }
              if (info.noticia == 'error_envio_email') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Error al enviar el emal, puedes reenviar las facturas en facturas autorizadas</div>')

              }
              if (info.noticia == 'error_path') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Error 1124 comuniquese con el Administrador</div>')

              }
              if (info.noticia == 'generador_pdf') {
                $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert"> Mirar el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a></div>')

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
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Comprobante enviado Correctamente!</div>')

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
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Comprobante generado Imprime y Entrega al Cliente mira <a  target="_blank" href="facturacion/facturacionphp/comprobantes/proformas/pdf/'+info.clave_acc_guardar+'.pdf">Aqui</a>!</div>')

                }
                if (info.noticia =='pdf_generado') {
                  $('.notificacion_facturacion').html('<div class="alert alert-warning" role="alert">mira el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/proformas/pdf/'+info.pdf+'">Generado Aqui</a> !</div>')

                }


            },

             });
        }










      }
      if (info.noticia == 'vacio') {
      $('.notificacion_facturacion').html('<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>');

      }

      }

    }

  });
}













function sendData_enviar_facturar_prueba_pdf(){
  $('.notificacion_facturacion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#enviar_facturar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/resumen_pago.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_facturacion').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        if (info.tipo_documento_digital == 'Factura') {
          var cliente = 1;;
          var action = 'genear_factura';
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_venta_prueba_pdf.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);
              if (info.noticia == 'logo_vacio') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }else {
                if (info.noticia == 'imagen_invalida') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">Sube una imagen valida  en formato png, jpg, jpeg   <a href="cuenta.php">Aqui</a>!</div>')

                }
              }
              if (info.noticia == 'cedula_vacia') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'nombre_vacio') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'factura_exitosa') {
                $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Factura generada y enviada con exito se ha limpiado la consola!</div>')

              }
              if (info.noticia == 'clave_duplicada') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

              }
              if (info.noticia == 'error_devuelta') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

              }
              if (info.noticia == 'sri_fuera') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')

              }
              if (info.noticia == 'no_se_puede_firmar') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> No se puede firmar el documento error interno comuniquese con el Admnistrador. </div>')

              }
              if (info.noticia == 'no_autorizado') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> NO AUTORIZADO, mensaje: '+info.mensaje+' </div>')

              }
              if (info.noticia == 'error_envio_email') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Error al enviar el emal, puedes reenviar las facturas en facturas autorizadas</div>')

              }
              if (info.noticia == 'error_path') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Error 1124 comuniquese con el Administrador</div>')

              }

              if (info.noticia == 'pdf_pegenerado') {
                $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Pdf generado miralo  <a target="_blank" href="/home/facturacion/facturacionphp/comprobantes/pdf/'+info.clave+'.pdf">Aqui</a>!</div>')

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
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Comprobante enviado Correctamente!</div>')

                }


            },

             });
        }
      }
      if (info.noticia == 'vacio') {
      $('.notificacion_facturacion').html('<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>');

      }

      }

    }

  });
}















function sendData_agregar_dorma_pago(){
  $('.notificacion_forma_pago').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_forma_de_pago')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/generar_comprobante.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_forma_pago').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_forma_pago').html('<div class="notio_positiva" ><p style="background: green;width: 50%;margin: 0 auto;padding: 5px;">Forma de Pago Agregada</p></div>');

      }
      if (info.noticia == 'vacio') {
      $('.notificacion_forma_pago').html('<p style="background: #FF5733;width: 80%;margin: 0 auto;">Agrega primero un producto</p>');

      }

      }

    }

  });
}






function buscar_producto() {
  $('#total_resultados').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    var parametros = new  FormData($('#busqueda_producto')[0]);

    $.ajax({
      data: parametros,
      url: 'jquery_comprar/generar_comprobante2.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        $("#elejir_" ).html(response);


      }

    });
}

function sendData_info_usuario() {
  $('#usuario_dirigido').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    var parametros = new  FormData($('#informacion_usuario')[0]);
    $.ajax({
      data: parametros,
      url: 'jquery_comprar/generar_comprobante.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        $("#usuario_dirigido" ).html(response);





      }

    });
}

function sendData_generar_factura() {
  $('.notificacion_factura').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    var parametros = new  FormData($('#generar_factura')[0]);
    $.ajax({
      data: parametros,
      url: 'facturacion/facturacionphp/controladores/ctr_venta.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        console.log(response);
          $('.notificacion_factura').html(response)
      }

    });
}


function sendData_generar_nota_venta() {
  $('.notificacion_factura').html('<div class="proceso">'+
  '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    var parametros = new  FormData($('#generar_factura')[0]);
    $.ajax({
      data: parametros,
      url: 'facturacion/facturacionphp/controladores/ctr_nota_venta.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        console.log(response);
          $('.notificacion_factura').html(response)
      }

    });
}
function consumidor_final() {
    var tipo_identificacion =  document.getElementById("elegir_documento").value;
    if (tipo_identificacion == '07') {

    }else {
      console.log('otro');
    }

}


$(document).ready(function(){
  $('.enlace_eliminar').click(function(e){
    e.preventDefault();
    var producto  = $(this).attr('producto');
    var action = 'eliminar_actual_producto';
    console.log(producto);
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto :producto },
      success: function(response){
        console.log(response);
        if (response != 'error') {
          var info = JSON.parse(response);
          if (info.respuesta == 'elimado_correctamnete') {
            location.href ="mis-productos";
          }

        }
      },
       error:function(error){
         console.log(error);
         }
       });

  });

});
