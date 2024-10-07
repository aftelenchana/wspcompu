
function sendData_nota_credito(){
  $('.notifiacion_nota_credito').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_nota_creditos')[0]);
  $.ajax({
    data: parametros,
    url: '',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      //var info = JSON.parse(response);


    }

  });
}

function sendData_generar_informacion_nota_credito(){
  $('.alerta_primer_modal_hgtr').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#generar_informacion_nota_credito')[0]);
  $.ajax({
    data: parametros,
    url: 'facturacion/nota_credito/genera_informacion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='no_encuentra_archivo') {
        $('.alerta_primer_modal_hgtr').html('<div class="alert alert-danger" role="alert">Lo sentimos, no se encuentra este archivo en nuestra base de datos!</div>')

      }
      if (info.noticia =='si_da') {
        $('.dfdfdfdfdfdfdf').html('<form class="" method="post" name="generar_nota_credito_final" id="generar_nota_credito_final" onsubmit="event.preventDefault(); sendData_generar_nota_credito_final();" >'+
                    '<div class="form-group">'+
                      '<label for="exampleFormControlTextarea1">Ingrese el valor de modificiación </label>'+
                    '<input type="number" class="form-control" required step="0.00001"  name="nomnto_modificacion" id="exampleFormControlInput1" placeholder="Ingrese el monto">'+
                    '</div>'+
                    '<div class="form-group">'+
                      '<label for="exampleFormControlTextarea1">Ingrese la Razón de la nota de Crédito </label>'+
                    '<input type="text" class="form-control" required name="razon_modficiacion" id="exampleFormControlInput1" placeholder="Ingrese la Razón">'+
                    '</div>'+
                    '<div class="archivos_busqueda_jhgf">'+
                      '<a download href="/home/facturacion/facturacionphp/comprobantes/pdf/'+info.clave_acceso+'.pdf">  <img src="/home/img/reacciones/pdf.png" alt=""> </a>'+
                      '<a download href="/home/facturacion/facturacionphp/comprobantes/autorizados/'+info.clave_acceso+'.xml">  <img src="/home/img/reacciones/xml.png" alt=""> </a>'+
                      '<div class="">'+
                        '<div class="alert alert-warning" role="alert">La factura se ha realizado por un monto total de $'+info.valor_total+' !, con fecha '+info.fechaEmision+' a '+info.razonSocialComprador+' con identificación '+info.identificacionComprador+'</div>'+
                      '</div>'+
                    '</div>'+
                      '<input type="hidden" class="form-control" value="'+info.clave_acceso+'" name="clave_acceso_factura" id="exampleFormControlInput1" placeholder="">'+
                      '<button type="submit" class="btn btn-success">Generar Nota de Crédito</button>'+
                      '<div class="notificacion_envio_nota_credito_rtd">'+
                      '</div>'+
                  '</form>');

      }

      //var info = JSON.parse(response);


    }

  });
}



function sendData_generar_nota_credito_final(){
  $('.notificacion_envio_nota_credito_rtd').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#generar_nota_credito_final')[0]);
   parametros.append('sucursal_facturacion', document.getElementById('sucursal_facturacion').value);
  $.ajax({
    data: parametros,
    url: 'facturacion/facturacionphp/controladores/ctr_nota_credito.php',
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
              $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-success" role="alert">Nota de crédito generada correctamente, pero no se envio por correo revisa tus credenciales, puedes revisarla   <a target="_blank" href="facturacion/facturacionphp/comprobantes/nota-credito/pdf/'+info.clave_acceso+'.pdf">Aquí</a> !</div>')

          }

          if (info.correo == 'enviado_correctamente') {
              $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-success" role="alert">Nota de crédito enviada correctamente  puedes revisarla   <a target="_blank" href="facturacion/facturacionphp/comprobantes/nota-credito/pdf/'+info.clave_acceso+'.pdf">Aquí</a> ! !</div>')

          }

        }


        if (info.noticia == 'nota_credito_existente') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Nota de Crédito Existente!</div>')
        }

        if (info.noticia == 'clave_duplicada_insertada') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Clave '+info.clave+' Duplicada genera nuevamente el documento, genera nuevamente este documento!</div>')
        }


        if (info.noticia == 'clave_duplicada_no_insertada') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Clave '+info.clave+' el sistema ha tratado de realizar un registro, pero hubo error interno comunicate con soporte</div>')
        }

        if (info.noticia == 'secuencial_insertada') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Secuencial '+info.secuencial+' Duplicada genera nuevamente el documento, genera nuevamente este documento!</div>')
        }


        if (info.noticia == 'secuencial_no_insertada') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Secuencial '+info.secuencial+' el sistema ha tratado de realizar un registro, pero hubo error interno comunicate con soporte</div>')
        }


        if (info.noticia == 'error_devuelta') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">Devuelta Mensaje: '+info.mensaje+'!</div>')
        }

        if (info.noticia == 'error_no_autorizado') {
          $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-danger" role="alert">No Autorizado Mensaje: '+info.mensaje+'!</div>')
        }


        if (info.noticia == 'ver_pdf_prueba') {
            $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-success" role="alert">  <a target="_blank" href="/home/facturacion/facturacionphp/comprobantes/nota-credito/pdf/'+info.pdf+'.pdf">Descargar PDF</a> !</div>')

        }

        if (info.noticia == 'estado_factura_anulada_internamente') {
            $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-success" role="alert"> Se ha Anulado la Factura internamente en el sistema !</div>')

        }

        if (info.noticia == 'error_servidor_cambiando_estado_sin_sri') {
            $('.notificacion_envio_nota_credito_rtd').html('<div class="alert alert-success" role="alert">Error al ingresar la anulación al sistema !</div>')

        }


    }

  });
}
