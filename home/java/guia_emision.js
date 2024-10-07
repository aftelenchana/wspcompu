function sendData_guis_aemision(){
  $('.notificacion_guia_emision').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#generar_guia_emision')[0]);
  $.ajax({
    data: parametros,
    url: 'facturacion/facturacionphp/controladores/ctr_venta_guia_emision.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='no_existe_archivo') {
        $('.notificacion_guia_emision').html('<div class="alert alert-danger" role="alert">No se ha encontrado ningun archivo para generar la guia de emisión!</div>');
      }
      if (info.noticia =='guia_emision_creada') {
        $('.notificacion_guia_emision').html('<div class="alert alert-success" role="alert">Guia de Emisión creada correctamente puedes verlo <a target="_blank" href="/home/facturacion/facturacionphp/comprobantes/guia-remision/si_firmados/'+info.clave_acceso+'.xml">Aqui</a> !</div>');
      }


      if (info.noticia =='pdf_creado') {
        $('.notificacion_guia_emision').html('<div class="alert alert-success" role="alert">PDf creado miralo   <a target="_blank" href="facturacion/facturacionphp/comprobantes/guia-remision/pdf/'+info.clave_acc_guardar+'.pdf">Aqui</a> !</div>');
      }



    }

  });
}



function sendData_agregar_transportista(){
  var parametros = new  FormData($('#agregar_transportista')[0]);
  $.ajax({
    data: parametros,
    url:"jquery_empresa/transportista.php",
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noti_ad_ususario_bg').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      $("#razon_social_transportista").val(info.razon_social_transportista);
      $("#tipo_identificacion_transportista").val(info.tipo_identificacion_transportista);
      $("#ruc_transportista").val(info.identificacion_transportista);
      $("#placa_transportista").val(info.placa);



      }

    }

  });

}
