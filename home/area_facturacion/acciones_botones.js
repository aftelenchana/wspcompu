$(document).on("click", ".guardar_documento", function() {
    var documento_electronico = document.getElementById('documento_electronico').value;
    var codigo_factura = document.getElementById('codigo_factura').value;
    var razon_social_cliente2 = document.getElementById('razon_social_cliente').value;
    var direccion_reeptor = document.getElementById('direccion_reeptor').value;
    var email_reeptor = document.getElementById('email_reeptor').value;

    var celular_receptor = document.getElementById('celular_receptor').value;
    var idcliente = document.getElementById('idcliente').value;
    var identificacion_cliente = document.getElementById('identificacion_cliente').value;



    console.log(documento_electronico);
    var action = 'guardar_documento';
    $.ajax({
      type:"post",
      url:"area_facturacion/acciones_botones.php",
      data: {action:action,documento_electronico:documento_electronico,codigo_factura:codigo_factura,razon_social_cliente2:razon_social_cliente2,direccion_reeptor:direccion_reeptor,email_reeptor:email_reeptor,celular_receptor:celular_receptor,idcliente:idcliente,identificacion_cliente:identificacion_cliente},
      success:function(response){
        console.log(response);
        if (response =='error') {
          $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
        }else {
          var info = JSON.parse(response);
          if (info.noticia == 'guardado_correctamente') {
              window.location.href = 'facturacion_in?factura=' + info.secuencial;



          }
          if (info.noticia == 'error_eliminar_producto') {
             $('#errorModal').modal('show');
          }



        }

      }

    })
});


$(document).on("click", ".previzualizar_pdf", function() {
    var documento_electronico = (document.getElementById('documento_electronico').value);
    var codigo_factura = (document.getElementById('codigo_factura').value);
    var razon_social_cliente2 = encodeURIComponent(document.getElementById('razon_social_cliente').value);
    var direccion_reeptor = encodeURIComponent(document.getElementById('direccion_reeptor').value);
    var email_reeptor = (document.getElementById('email_reeptor').value);
    var celular_receptor = (document.getElementById('celular_receptor').value);
    var idcliente = (document.getElementById('idcliente').value);
    var identificacion_cliente = (document.getElementById('identificacion_cliente').value);
    var sucursal_facturacion = (document.getElementById('sucursal_facturacion').value);
    var action = 'previzualizar_pdf';

    if (documento_electronico == 'Facturación') {
        var url_envio = 'pdf/previzualizar_pdf.php';
        var queryString = `?documento_electronico=${documento_electronico}&codigo_factura=${codigo_factura}&razon_social_cliente2=${razon_social_cliente2}&direccion_reeptor=${direccion_reeptor}&email_reeptor=${email_reeptor}&celular_receptor=${celular_receptor}&idcliente=${idcliente}&identificacion_cliente=${identificacion_cliente}&sucursal_facturacion=${sucursal_facturacion}`;

        window.location = url_envio + queryString;
console.log(url_envio + queryString);
    }
});



$(document).on("click", ".generar_documento", function() {
    var documento_electronico = document.getElementById('documento_electronico').value;
    var codigo_factura = document.getElementById('codigo_factura').value;
    var razon_social_cliente2 = document.getElementById('razon_social_cliente').value;
    var direccion_reeptor = document.getElementById('direccion_reeptor').value;
    var email_reeptor = document.getElementById('email_reeptor').value;
    var celular_receptor = document.getElementById('celular_receptor').value;
    var idcliente = document.getElementById('idcliente').value;
    var identificacion_cliente = document.getElementById('identificacion_cliente').value;
    var total_pagar = document.getElementById('total_pagar').innerHTML;
    var action = 'previzualizar_pdf';
    console.log(documento_electronico);
     $(".documento_a_generar").html(documento_electronico);
     $(".client_a_generar").html(razon_social_cliente2);
     $(".identi_a_generar").html(identificacion_cliente);
     $(".email_a_generar").html(email_reeptor);
     $(".total_a_generar").html(total_pagar);
     $(".notificacion_facturacion").html('');
    $('#modal_informacion_documento').modal();
});



$(document).ready(function(){
  $(".tipo_documento_electronico_elejir").change(function(){
      var tipo_documento_electronico_elejir = $(".tipo_documento_electronico_elejir").val();
      var action = 'buscar_scuenccia_documento';
      $.ajax({
        url:'area_facturacion/busqueda_secuencia.php',
        type:'POST',
        async: true,
        data: {action:action,tipo_documento_electronico_elejir:tipo_documento_electronico_elejir},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
              $('.resultado_busqueda_secuencia_documento_l').html(info.resultado_documento_secuencial);




           }
         },
         error:function(error){
           console.log(error);
           }
         });

  });

});
