$(document).ready(function(){
  $(document).on('click', '.sumar_producto', function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var codigo_mesa = $(this).attr('codigo_mesa');
    var action = 'agregar_producto_carrito';
    console.log(producto);

    $.ajax({
      url:'jquery_comprar/add_carrito.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto,codigo_mesa:codigo_mesa},
      success: function(response){
        console.log(response);

        if (response != 'error') {
          var info = JSON.parse(response);
          if (info.noticia == 'agregado_mas_uno') {
            $('.cant'+info.idp+'').html(info.cantidad);
            var codigo_mesa = info.codigo_mesa;
            var cliente = 1;;
            var action = 'actualizar_resumen';

            $.ajax({
              url: 'jquery_rst/actualizar_resumen_pago.php',
              type:'POST',
              async: true,
              data: {action:action,cliente:cliente,codigo_mesa:codigo_mesa},
              success: function(response){
                console.log(response);
                $('.resultado_compra_consola_restaurantes').html(response);
              }
            });
          }
          console.log(response);
        }
      },
      error:function(error){
        console.log(error);
      }
    });
  });
});


// Modal para restar el producto
$(document).ready(function() {
  $(document).on('click', '.restar_prodcuto', function(e) {
    e.preventDefault();
    var producto = $(this).attr('producto');
    var codigo_mesa = $(this).attr('codigo_mesa');
    var action = 'restar_uno_producto';
    $.ajax({
      url: 'jquery_comprar/add_carrito.php',
      type: 'POST',
      async: true,
      data: { action: action, producto: producto, codigo_mesa: codigo_mesa },
      success: function(response) {
        console.log(response);
        if (response !== 'error') {
          var info = JSON.parse(response);
          if (info.noticia == 'agregado_menos_uno') {
            $('.cant' + info.idp + '').html(info.cantidad);

            var codigo_mesa = info.codigo_mesa;
            var cliente = 1;
            var action = 'actualizar_resumen';
            $.ajax({
              url: 'jquery_rst/actualizar_resumen_pago.php',
              type: 'POST',
              async: true,
              data: { action: action, cliente: cliente, codigo_mesa: codigo_mesa },
              success: function(response) {
                console.log(response);
                $('.resultado_compra_consola_restaurantes').html(response);
              },
              error: function(error) {
                console.log(error);
              }
            });
          }
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
});






  function sendData_comprar_varios(){
       $('.notificacion_compra').html('<div class="proceso">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
       '</div>');
    var parametros = new  FormData($('#comprar_varios')[0]);
    $.ajax({
      data: parametros,
      url: '/home/jquery_comprar/add_carrito.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        console.log(response)

        if (response =='error') {
          $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
        }else {
        var info = JSON.parse(response);
        if (info.resultado == 'contrasena_incorrecta') {
            $('.notificacion_compra').html('<div class="respuesta_negativa"><img src="img/reacciones/cerrar.png" alt=""><p>Contraseña Incorrecta</p></div>')
        }
        if (info.resultado == 'saldo_insuficiente') {
          $('.notificacion_compra').html('<div class="respuesta_negativa"><img src="img/reacciones/cerrar.png" alt=""><p>Saldo Insuficiente</p></div>')
        }
        if (info.resultado == 'no_existe_ubi_producto') {
            $('.alert_compra_leben').html('<div class="compra_correcta"><p> <img src="img/reacciones/cerca.png" alt="" width="25px"><br> No existe ubicacion del producto, no es posible usar el transporte interno</p></div>')
        }
        if (info.resultado == 'elejir_opcion') {
            $('.alert_compra_leben').html('<div class="compra_correcta"><p> <img src="img/reacciones/cerca.png" alt="" width="25px"><br>Elije el medio de transporte</p></div>')
        }
        if (info.resultado == 'comprado_correctamente') {
            $('.notificacion_compra').html('<div class="respuesta_positiva"><img src="img/reacciones/garrapata.png" alt=""><p>Compra Exitosa revisa en Mis Compras</p></div>')

        }
        if (info.resultado == 'error_insertar_historial') {
            $('.alert_compra_leben').html('<p class="alerta_positiva">Error al Insertar en el Historial</p>')
        }
        if (info.resultado == 'error_insertar_saldo') {
            $('.alert_compra_leben').html('<p class="alerta_positiva">Error al modificar Saldo</p>')
        }
        if (info.resultado == 'error_insertar_en_ventas') {
            $('.alert_compra_leben').html('<p class="alerta_positiva">Error al insertar en Ventas</p>')
        }
        if (info.resultado == 'Contrea_saldo') {
            $('.alert_compra_leben').html('<p class="alerta_positiva">Contraseña Incorrecta</p>')
        }
        if (info.resultado == 'intentos_maximos') {
          $('.notificacion_compra').html('<div class="respuesta_negativa"><img src="img/reacciones/cerrar.png" alt=""><p>Intentos Maximos con Contraseña Incorrecta</p></div>')
        }


        }

      }

    });

  }




  $(document).ready(function(){
      //modal para agregar el producto
      $('.cleaner_carrito').click(function(e){
        e.preventDefault();
        var producto = $(this).attr('producto');
        var action = 'limpiar_carrito_compras';
        console.log(producto);
        $.ajax({
          url:'jquery_comprar/add_carrito.php',
          type:'POST',
          async: true,
          data: {action:action,producto:producto},
           success: function(response){
              console.log(response);

             if (response != 'error') {
               var info = JSON.parse(response);
               if (info.noticia == 'limpia_correcta') {
                  location. reload()


               }

                          console.log(response);
             }
           },
           error:function(error){
             console.log(error);
             }
           });


      });

    });
