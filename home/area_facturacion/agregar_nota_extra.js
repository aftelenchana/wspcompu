function sendData_agregar_nota_extra(){
  $('.notificacion_agregar_nota_extra').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_nota_extra')[0]);
  $.ajax({
    data: parametros,
    url: 'area_facturacion/agregar_nota_extra.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_agregar_nota_extra').html('<div class="alert alert-success" role="alert">Nota extra agregada Correctamente.!</div>')
        $('.nota_extra_ddd').html(info.nota_extra)
      }

      if (info.noticia =='error_servidor') {
        $('.notificacion_agregar_nota_extra').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')

      }

    }

  });
}
