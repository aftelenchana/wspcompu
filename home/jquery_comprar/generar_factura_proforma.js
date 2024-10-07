function sendData_generaar_factura_proforma(){
    $('.notificacion_envio_proforma_facturar').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#generar_factura_proforma')[0]);
$.ajax({
data: parametros,
url: 'jquery_comprar/generar_factura_proforma.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.notificacion_envio_proforma_facturar').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'insert_correct') {
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
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">No has subido el logo de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

        }else {
          if (info.noticia == 'imagen_invalida') {
            $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">Sube una imagen valida  en formato png, jpg, jpeg   <a href="cuenta.php">Aqui</a>!</div>')

          }
        }
        if (info.noticia == 'cedula_vacia') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">No has subido tu ruc súbelo <a href="cuenta.php">Aqui</a>!</div>')

        }
        if (info.noticia == 'firma_vacia' || info.noticia =='son_leer_firma') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">No has subido la firma electrónica de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

        }
        if (info.noticia == 'nombre_vacio') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">No has subido el nombre de tu empresa Súbelo  <a href="cuenta.php">Aqui</a>!</div>')

        }
        if (info.noticia == 'factura_exitosa') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-success" role="alert">Factura generada y enviada con exito se ha limpiado la consola puedes mirarla <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a> !</div>')

        }
        if (info.noticia == 'clave_duplicada') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">Clave de Acceso duplicada '+info.clave+'!, genera de nuevo la factura o ve a configuraciones y digita un secuencial seguido al de tus facturas  <a target="_blank" href="avanzadas.php">Aqui</a> </div>')

        }
        if (info.noticia == 'error_devuelta') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> Mensaje devuelta '+info.mensaje+' </div>')

        }
        if (info.noticia == 'sri_fuera') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> Sistema del SRI fuera de servicio. </div>')

        }
        if (info.noticia == 'no_se_puede_firmar') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> No se puede firmar el documento error interno comuniquese con el Admnistrador. </div>')

        }
        if (info.noticia == 'no_autorizado') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> NO AUTORIZADO, mensaje: '+info.mensaje+' </div>')

        }
        if (info.noticia == 'error_envio_email') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> Error al enviar el emal, puedes reenviar las facturas en facturas autorizadas</div>')

        }
        if (info.noticia == 'error_path') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert"> Error 1124 comuniquese con el Administrador</div>')

        }
        if (info.noticia == 'generador_pdf') {
          $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-success" role="alert"> Mirar el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/pdf/'+info.factura+'.pdf">Aqui</a></div>')

        }





      },

       });

  }
  if (info.noticia == 'error') {
    $('.notificacion_envio_proforma_facturar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

  }

  }

}

});

}
