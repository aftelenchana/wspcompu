
function sendData_buscar_usuarios_api(){
  $('.notificacion_buscar_api').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#buscar_usuario_api')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/buscar_usuario_api.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.notificacion_buscar_api').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
        var info = JSON.parse(response);
        if (info.noticia == 'consulta_exitosa') {
          $('.notificacion_buscar_api').html('<div class="alert alert-warning" role="alert">Busqueda Exitosa!</div>');

          $('#nombres').val(info.RAZON_SOCIAL);
          $('#email').val(info.EMAIL);
          $('#celular').val(info.DIRECCION);
          $('#direccion').val(info.CEULAR);
          $('#identificacion').val(info.NUMERO_RUC);
          $('#provincia').val(info.DESCRIPCION_PROVINCIA);
          $('#ciudad').val(info.DESCRIPCION_CANTON);
          $('#parroquia_ty').val(info.DESCRIPCION_PARROQUIA);
          //console.log(info.DESCRIPCION_PARROQUIA);
          //$('.parroquia_ty').val(info.DESCRIPCION_PARROQUIA);
          $('#actividad_economica').val(info.ACTIVIDAD_ECONOMICA);





        }


        if (info.noticia == 'consulta_no_existente') {
          $('.notificacion_buscar_api').html('<div class="alert alert-danger" role="alert">NO SE ENCUENTRA NINGUN  REGISTRO PARA ESTA BUSQUEDA!</div>');

          $('.notificacion_ruc_consultado').html('');

        }




      }

    }

  });

}
