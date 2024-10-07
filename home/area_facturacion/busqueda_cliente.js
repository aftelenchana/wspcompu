

$(document).ready(function(){
  $("#search_usuarios").change(function(){
    var datos = $("#search_usuarios").val();
    var action = 'buscar_usuarios_id';
    if (datos == 0) {
      $("#email_reeptor").val('factura@facturacion.guibis.com');
      $("#direccion_reeptor").val('Ninguno');
      $("#celular_receptor").val('999999999');
      $("#identificacion_cliente").val('9999999999999');
      $("#razon_social_cliente").val('Consumidor Final');
      $("#idcliente").val('0');
      $("#tipo_identificacion").val('07');

    }

    if (datos == 'agregar_nuevo') {
      $("#email_reeptor").val('');
      $("#direccion_reeptor").val('');
      $("#celular_receptor").val('');
      $("#identificacion_cliente").val('');
      $("#razon_social_cliente").val('');
      $("#idcliente").val('');



    }
    if (datos != 0 && datos != 'agregar_nuevo' ) {

      $.ajax({
        type:"post",
        url:"area_facturacion/busqueda_cliente.php",
        data: {action:action,datos:datos},
        success:function(response){

          if (response =='error') {
            $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
          }else {
          var info = JSON.parse(response);
          $("#razon_social_cliente").val(info.nombres);
          $("#tipo_identificacion").val(info.tipo_identificacion);
          $("#numero_identidad_receptor").val(info.identificacion);
          $("#email_reeptor").val(info.mail);
          $("#direccion_reeptor").val(info.direccion);
          $("#celular_receptor").val(info.celular);
          $("#id_usuario_receptor").val(info.id);
          $("#identificacion_cliente").val(info.identificacion);
          $("#idcliente").val(info.id);

          }

        }

      })

    }








  });

});
