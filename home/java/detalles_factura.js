
function sendData_corregir_error_autorizacion(){
  $('.notificacion_correccion_errores').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#correccion_error_autorizacion')[0]);
  var tipo_error_autorizacion = document.getElementById('tipo_error_autorizacion').value;
  $.ajax({
    data: parametros,
    url: 'facturacion/facturacionphp/controladores/ctr_venta_correccion_error_autorizacion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
        var info = JSON.parse(response);

        if (info.noticia == 'factura_exitosa') {

          if (info.correo == 'no_enviado') {
              $('.notificacion_correccion_errores').html('<div class="alert alert-success" role="alert">Factura generada y enviada con éxito,  <a href="detalles_factura?detalles_factura=' + info.factura + '">RIDE</a>. ' +
                  'No se ha enviado el correo, ¡revisa tus credenciales!  Envio Wsp: '+info.msg_wsp+' </div>');
          }

          if (info.correo == 'enviado_correctamente') {
              $('.notificacion_correccion_errores').html('<div class="alert alert-success" role="alert">Factura generada y enviada con éxito,<a href="detalles_factura?detalles_factura=' + info.factura + '">RIDE</a>. ' +
                  'Envio Wsp: '+info.msg_wsp+'</div>');
          }
        }

        if (info.noticia == 'clave_duplicada') {
          $('.notificacion_correccion_errores').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

        }
        if (info.noticia == 'error_devuelta') {
          $('.notificacion_correccion_errores').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

        }
        if (info.noticia == 'error_no_autorizado') {
          $('.notificacion_correccion_errores').html('<div class="alert alert-danger" role="alert"> Mensaje no Autorizado '+info.mensaje+' </div>')

        }



    }

  });
}
