
function calculo_precio_final_input() {
  var elejir_tarifa_iva = $("#elejir_tarifa_iva").val();
  var precio_sin_impuestos = parseFloat($("#precio").val());

  if (elejir_tarifa_iva == '2') {
    var precio_final_con_tarifa = ((precio_sin_impuestos * 0.12) + precio_sin_impuestos).toFixed(2);;
    $("#resultado_calculo").val(precio_final_con_tarifa);
  } else {
    $("#resultado_calculo").val(precio_sin_impuestos);
  }
}



(function(){
  $(function(){
    $('.boton_editar_producto').on('click',function(){
      console.log('Hola mundo');
      $('#modal_editar_producto').modal();
      var idproducto = $("#idproducto").val();
      var action = 'buscar_producto';
      $.ajax({
        type:"post",
        url: 'jquery_producto/producto.php',
        data: {action:action,idproducto:idproducto},
        success:function(response){
          console.log(response);
          if (response =='error') {
            $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
          }else {
          var info = JSON.parse(response);
          $(".producto_a_editar").html(info.nombre);
          $("#nombre_producto").val(info.nombre);
          $("#precio").val(info.precio);
          $("#precio_costo").val(info.precio_costo);
          $("#tipo_ambiente").val(info.tipo_ambiente);
          $("#codigos_impuestos").val(info.codigos_impuestos);
          $("#resultado_calculo").val(info.valor_unidad_final_con_impuestps);
          $("#cantidad").val(info.cantidad);
          $("#marca_codigo").val(info.marca);
          $("#proveedor").val(info.proveedor);
          $("#codigo_barras").val(info.codigo_barras);
          $("#descripcion").val(info.descripcion);
          $(".img_edit_noticia").html(' <img width="100px" src="'+info.url_upload_img+'/home/img/uploads/'+info.foto+'" alt="">');
          $(".notificacion_editar_producto").html('');



          }
        }
      })
    });


  });

}());



function sendData_editar_producto(){
  $('.notificacion_editar_producto').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#editar_producto')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/producto.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_editar_producto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_editar_producto').html('<div class="alert alert-success" role="alert">Producto Editado Correctamente!</div>');
              $('.port_big_img').html('<img class="img img-fluid" src="img/uploads/'+info.imgProducto+'" alt="Big_ Details" />');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_editar_producto').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }




      }

    }

  });

}
