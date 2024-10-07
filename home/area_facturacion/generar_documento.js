$(document).ready(function(){
      var codigo_factura = document.getElementById('codigo_factura').value;
    $.ajax({
        url: 'area_facturacion/generar_documento.php',
        type: 'POST',
        async: true,
        data: {
            action: 'sacar_informacion_factura_guardada',
            codigo_factura: codigo_factura
        },
        success: function(response){
            var info = JSON.parse(response);
            if (info.noticia == 'existe_datos') {
              if (info.estado == 'GUARDADO') {
                if (info.id_receptor != '') {
                  $("#search_usuarios").val(info.id_receptor).trigger('change');
                }
                $("#documento_electronico").val(info.documento);
                $("#razon_social_cliente").val(info.nombres_receptor);
                $("#tipo_identificacion").val(info.tipo_identificacion);
                $("#numero_identidad_receptor").val(info.identificacion);
                $("#email_reeptor").val(info.email_reeptor);
                $("#direccion_reeptor").val(info.direccion_reeptor);
                $("#celular_receptor").val(info.celular_receptor);
                $("#id_usuario_receptor").val(info.id_receptor);
                $("#identificacion_cliente").val(info.numero_identidad_receptor);
                $("#idcliente").val(info.id_receptor);

              }
              if (info.estado == 'FINALIZADO') {
                if (info.id_receptor != '') {
                  $("#search_usuarios").val(info.id_receptor).trigger('change');
                }


                $("#documento_electronico").val(info.documento);
                $("#razon_social_cliente").val(info.nombres_receptor);
                $("#tipo_identificacion").val(info.tipo_identificacion);
                $("#numero_identidad_receptor").val(info.identificacion);
                $("#email_reeptor").val(info.email_reeptor);
                $("#direccion_reeptor").val(info.direccion_reeptor);
                $("#celular_receptor").val(info.celular_receptor);
                $("#id_usuario_receptor").val(info.id_receptor);
                $("#identificacion_cliente").val(info.numero_identidad_receptor);
                $("#idcliente").val(info.id_receptor);

              }

            }

        },
        error: function(error){
            console.log(error);
        }
    });
});



function sendData_generar_dcocumento(){
  $('.notificacion_facturacion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#generar_documento')[0]);

  // Agregando variables adicionales al objeto FormData
  parametros.append('documento_electronico', document.getElementById('documento_electronico').value);
  parametros.append('codigo_factura', document.getElementById('codigo_factura').value);
  parametros.append('razon_social_cliente2', document.getElementById('razon_social_cliente').value);
  parametros.append('direccion_reeptor', document.getElementById('direccion_reeptor').value);
  parametros.append('email_reeptor', document.getElementById('email_reeptor').value);
  parametros.append('celular_receptor', document.getElementById('celular_receptor').value);
  parametros.append('idcliente', document.getElementById('idcliente').value);
  parametros.append('identificacion_cliente', document.getElementById('identificacion_cliente').value);
  parametros.append('tipo_identificacion', document.getElementById('tipo_identificacion').value);
  parametros.append('sucursal_facturacion', document.getElementById('sucursal_facturacion').value);

  $.ajax({
    data: parametros,
    url: 'area_facturacion/generar_documento.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alerta_generar_documento').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);



      if (info.noticia == 'fecha_mayor') {

        $('.notificacion_facturacion').html('<div class="alert alert-warning background-warning">'+
        '<strong>Tu paquete a caducado  !</strong> comunícate con el administrador'+
        '</div>');
      }

      if (info.noticia == 'fecha_menor') {
        if (info.cantidad == 'cantidad_incorrecta') {
          $('.notificacion_facturacion').html('<div class="alert alert-warning background-warning">'+
          '<strong>No tienes documentos disponibles !</strong> comunícate con el administrador'+
          '</div>');

        }
      }







      if (info.noticia == 'insert_correct') {
        if (info.tipo_documento_digital == 'Facturación') {
          var codigo_factura = info.codigo_factura;
          var action = 'sistema_central'
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_venta.php',
            type:'POST',
            async: true,
            data: {codigo_factura:codigo_factura,action:action},
            success: function(response){
              console.log(response);
              var info = JSON.parse(response);



              if (info.noticia == 'sri_fuera') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')
              }

              if (info.noticia == 'cedula_vacia') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="config_facturacion.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'nombre_vacio') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

              }
              if (info.noticia == 'secuencial_registrada_corregida') {
                $('.notificacion_facturacion').html('<div class="alert alert-warning" role="alert">Secuencial interna '+info.secuencial+' de factura registrada, envia nuevamente la factura </div>')

              }
              if (info.noticia == 'secuencial_registrada_error_base_datos') {
                $('.notificacion_facturacion').html('<div class="alert alert-warning" role="alert">Secuencial interna '+info.secuencial+' de factura registrada,error en el servidor comunicate con soporte</div>')

              }
             if (info.noticia == 'error_clave_firma') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">Revisa tu clave o tu firma electrónica!</div>')

              }
              if (info.noticia == 'factura_exitosa') {

                if (info.correo == 'no_enviado') {
                    $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Factura generada y enviada con éxito,  <a href="detalles_factura?detalles_factura=' + info.factura + '">RIDE</a>. ' +
                        'No se ha enviado el correo, ¡revisa tus credenciales! Tiker de Factura <a href="fpdfarchivos/comprobante_facturacion?codigo_factura=' + info.codigo_factura_SC + '&clave_acc_guardar=' + info.factura + '&numDocModificado=' + info.numDocModificado + '">Tiket</a> Envio Wsp: '+info.msg_wsp+' </div>');
                }

                if (info.correo == 'enviado_correctamente') {
                    $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Factura generada y enviada con éxito,<a href="detalles_factura?detalles_factura=' + info.factura + '">RIDE</a>. ' +
                        'Se ha enviado correctamente al correo. Tiker de Factura <a href="fpdfarchivos/comprobante_facturacion?codigo_factura=' + info.codigo_factura_SC + '&clave_acc_guardar=' + info.factura + '&numDocModificado=' + info.numDocModificado + '">Tiket</a> Envio Wsp: '+info.msg_wsp+'</div>');
                }




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

              if (info.noticia == 'error_no_autorizado') {
                $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert"> '+info.mensaje+' </div>')

              }



              if (info.noticia == 'generador_pdf') {
                $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert"> Mirar el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a></div>')

              }





            },

             });
        }
        if (info.tipo_documento_digital == 'Tiket Venta') {
          var codigo_factura = info.codigo_factura;
          var action = 'generar_nota_venta';
          $.ajax({
          url: 'facturacion/facturacionphp/controladores/ctr_nota_venta.php',
            type:'POST',
            async: true,
            data: {action:action,codigo_factura:codigo_factura},
            success: function(response){
              console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'logo_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Comprobante enviado Correctamente puedes mirarlo <a target="_blank" href="facturacion/facturacionphp/comprobantes/tikets/'+info.clave_acc_guardar+'.pdf">Aqui</a>!</div>')

                }


            },

             });
        }

        if (info.tipo_documento_digital == 'Nota de Venta Autorizada') {
          var codigo_factura = info.codigo_factura;
          var action = 'generar_nota_venta';
          $.ajax({
            url: 'facturacion/facturacionphp/controladores/ctr_nota_autorizada.php',
            type:'POST',
            async: true,
            data: {action:action,codigo_factura:codigo_factura},
            success: function(response){
              console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'logo_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }


                if (info.noticia =='insert_correct') {
                  $('.notificacion_facturacion').html('<div class="alert alert-success" role="alert">Comprobante enviado Correctamente puedes mirarlo <a target="_blank" href="facturacion/facturacionphp/comprobantes/nota_venta_autorizada/'+info.clave_acc_guardar+'.pdf">Aqui</a>!</div>')

                }


            },

             });
        }



        if (info.tipo_documento_digital == 'Proforma') {

          var codigo_factura = info.codigo_factura;
          var action = 'generar_proforma';
          $.ajax({
          url: 'facturacion/facturacionphp/controladores/ctr_proforma.php',
            type:'POST',
            async: true,
            data: {action:action,codigo_factura:codigo_factura},
            success: function(response){
              console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'logo_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'cedula_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'firma_vacia') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

                }
                if (info.noticia == 'nombre_vacio') {
                  $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="config_facturacion.php">Aqui</a>!</div>')

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
      if (info.noticia == 'metodo_pago_diferente_cantidad') {
      $('.notificacion_facturacion').html('<div class="alert alert-danger" role="alert">La cantidad en método pago de tu Factura  es diferente  al valor total de la Factura, el valor de la factura es de $'+info.valor_factura+' y el valor en metodo de pago es de '+info.cantidad_metodo_pago_base+'!</div>');

      }

      }

    }

  });

}
