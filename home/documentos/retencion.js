function sendData_procesar_retencion(){
  $('.notificacion_procesar_retencion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#procesar_retencion')[0]);
  $.ajax({
    data: parametros,
    url: 'facturacion/facturacionphp/controladores/ctr_retencion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
        var info = JSON.parse(response);
        if (info.noticia == 'envio_exitoso') {
          if (info.correo == 'no_enviado') {
              $('.notificacion_procesar_retencion').html('<div class="alert alert-success" role="alert">Nota de crédito generada correctamente, pero no se envio por correo revisa tus credenciales!</div>')

          }

          if (info.correo == 'enviado_correctamente') {
              $('.notificacion_procesar_retencion').html('<div class="alert alert-success" role="alert">Nota de crédito enviada correctamente!</div>')

          }

        }

        if (info.noticia == 'nota_credito_existente') {
          $('.notificacion_procesar_retencion').html('<div class="alert alert-danger" role="alert">Nota de Crédito Existente!</div>')
        }

        if (info.noticia == 'clave_duplicada') {
          $('.notificacion_procesar_retencion').html('<div class="alert alert-danger" role="alert">Clave Duplicada genera nuevamente el documento, esto se debe a que se haya generado en otro sistema de facturación, genera nuevamente este documento!</div>')
        }


        if (info.noticia == 'ver_pdf_prueba') {
            $('.notificacion_procesar_retencion').html('<div class="alert alert-success" role="alert">  <a target="_blank" href="/home/facturacion/facturacionphp/comprobantes/nota-credito/pdf/'+info.pdf+'.pdf">Descargar PDF</a> !</div>')

        }

        if (info.noticia == 'error_devuelta') {
          $('.notificacion_procesar_retencion').html('<div class="alert alert-danger" role="alert">Error devuelta Mensaje: '+info.mensaje+' !</div>')
        }

        if (info.noticia == 'error_no_autorizado') {
          $('.notificacion_procesar_retencion').html('<div class="alert alert-danger" role="alert">Error no autorizado Mensaje: '+info.mensaje+' !</div>')
        }



    }

  });
}


$("document").ready(function(){
$( "#proceso_retencion" ).load( "server/retenciones.php" );
$("#proceso_retencion").change(function(){
    var codigo =   $("#proceso_retencion").val();
    $.get("server/porcentajes_retencion.php", {codigo:codigo})
    .done(function(data){
    $("#porcentajes_retencion" ).html(data);
   })
})
})



$("document").ready(function(){
$( "#tabla_4_ats" ).load( "server/tabla_4_ats.php" );
$("#tabla_4_ats").change(function(){
    var codigo =   $("#tabla_4_ats").val();
    $.get("server/tabla_5_ats.php", {codigo:codigo})
    .done(function(data){
    $("#tabla_5_ats" ).html(data);
   })
})
})






$(document).ready(function() {
    $('.proceso_retencion').select2();
});
