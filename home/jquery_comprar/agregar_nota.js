function sendData_agregar_nota(){
  $('.noticia_agregar_nota').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_nota')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_comprar/agregar_nota.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_agregar_nota').html('<div class="alert alert-success" role="alert">Nota Agregada Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_agregar_nota').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}


(function(){
  $(function(){
    $('.realizar_tarea').on('click',function(){
      var nota = $(this).attr('nota');
      var action = 'realiar_nota';
      $('#fila'+nota+'').html(' <div class="notificacion_negativa">'+
         '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
       '</div>');
      $.ajax({
        url:'jquery_comprar/agregar_nota.php',
        type:'POST',
        async: true,
        data: {action:action,nota:nota},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
             if (info.noticia == 'insert_correct') {
              document.getElementById('fila'+info.nota+'').style.display = "none";

             }
             if (info.noticia == 'error_insertar') {
             $('.noticia_agregar_nota').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

             }

           }
         },
         error:function(error){
           console.log(error);
           }
 });

    });
  });

}());


(function(){
  $(function(){
    $('.eliminar_definitivamente').on('click',function(){
      var nota = $(this).attr('nota');
      var action = 'eliminar_nota';
      $('#fila'+nota+'').html(' <div class="notificacion_negativa">'+
         '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
       '</div>');
      $.ajax({
        url:'jquery_comprar/agregar_nota.php',
        type:'POST',
        async: true,
        data: {action:action,nota:nota},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
             if (info.noticia == 'insert_correct') {
              document.getElementById('fila'+info.nota+'').style.display = "none";

             }
             if (info.noticia == 'error_insertar') {
             $('.noticia_agregar_nota').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

             }

           }
         },
         error:function(error){
           console.log(error);
           }
 });

    });
  });

}());
