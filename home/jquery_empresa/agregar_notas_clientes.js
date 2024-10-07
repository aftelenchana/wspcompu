function sendData_agregar_notas_clientes(){
  $('.notificacion_nota_cliente').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_notas_clientes')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/agregar_notas_clientes.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_nota_cliente').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_nota_cliente').html('<div class="alert alert-success" role="alert">Nota Creada Correctamente !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_nota_cliente').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
