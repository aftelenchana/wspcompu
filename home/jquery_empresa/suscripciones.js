(function(){
  $(function(){
    $('.boton_agregar_suscripcion').on('click',function(){
      $('#modal_agreagr_suscripcion').modal();
          var cliente = $(this).attr('cliente');
          var action = 'buscar_suscripciones';
          $.ajax({
            url:'jquery_empresa/suscripciones.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                 var info = JSON.parse(response);
                 if (info.noticia == 'titne_susacripciones') {
                  $('.resultado_suscripciones').html('<div class="alert alert-success" role="alert">Este usuario ya tiene suscripciones !</div>');
                  $('#cliente').val(info.cliente);


                 }
                 if (info.noticia == 'no_tiene_suscripciones') {
                  $('.resultado_suscripciones').html('<div class="alert alert-warning" role="alert">Este usuario no tiene suscripciones !</div>');
                 $('#cliente').val(info.cliente);
                 console.log('hyola ');
                 }




               }
             },
             error:function(error){
               console.log(error);
               }
             });
          console.log(cliente);
    });

  });
}());



function sendData_agregar_plan_suscripcion(){
  $('.notificacion_suscripcion_agregada').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_plan_suscripcion')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/suscripciones.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_suscripcion_agregada').html('<div class="alert alert-success" role="alert">Suscripcion Agregada Correctamente!</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.notificacion_suscripcion_agregada').html('<div class="alert alert-danger" role="alert">Error en el servidor, intenta mas tarde!</div>')

      }



      //var info = JSON.parse(response);


    }

  });
}
