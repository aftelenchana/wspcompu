function sendData_tomar_pedido_transporte(){
  $('.notificacion_tomar_pedido_transporte').html(' <div class="notificacion_negativa">'+
   '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
 '</div>');

      if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(showPosition);
       }else {
         x.innerHTML = "No es compatible tu navegador";

         $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-danger background-danger">'+
              '<strong>Error!</strong> Tu navegador no es compatible'+
              '</div>');
       }

       function showPosition(position){
        console.log(position.coords.latitude)
        console.log(position.coords.longitude)

        var parametros = new  FormData($('#tomar_pedido_transporte')[0]);
        parametros.append('latitude', position.coords.latitude);
        parametros.append('longitude', position.coords.longitude);

        $.ajax({
          data: parametros,
          url:"transporte/tomar_pedido.php",
          type: 'POST',
          contentType: false,
          processData: false,
          beforesend: function(){
          },
          success: function(response){
            console.log(response);
            var info = JSON.parse(response);

              if (info.noticia == 'pedido_agregado_correctamente') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-success background-success">'+
                     '<strong>Viaje!</strong> Tomado agregado Correctamente '+
                     '</div>');
              }

              if (info.noticia == 'error_servidor') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-danger background-danger">'+
                     '<strong>Error en el servidor!</strong> Intenta Nuevamente '+
                     '</div>');
              }
              if (info.noticia == 'pedido_ya_accionado') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-warning background-warning">'+
                     '<strong>Viaje!</strong> Ya accionado'+
                     '</div>');
              }


              if (info.noticia == 'pedido_tomado_cocina_correctamente') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-success background-success">'+
                     '<strong>Pedido de Cocina!</strong> Recodigo Correctamente'+
                     '</div>');
              }

              if (info.noticia == 'finalizado_ya_accionado') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-warning background-warning">'+
                     '<strong>Estimado Usuario!</strong>Ya haz finalizado correctamente este viaje'+
                     '</div>');
              }

              if (info.noticia == 'entregado_finalizado_correcto') {
                $('.notificacion_tomar_pedido_transporte').html('<div class="alert alert-success background-success">'+
                     '<strong>Pedido Entregado Correctamente!</strong> Gracias por Preferirnos'+
                     '</div>');
              }




          }

        });

       }



}
