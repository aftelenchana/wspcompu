$(document).on('input', '.seleccionar_editar_input_cantidad', function() {
  // Obtén el valor actual del elemento input
  var valor = parseFloat($(this).val());
  var idItem = $(this).attr('idItem');
  var porcentaje_descuento = $(this).attr('porcentaje_descuento');

  if (valor < 0) {
    $(this).val("1");
  } else {
    var action = 'editar_cantidad_producto';
    $.ajax({
      type: "post",
      url: "area_facturacion/editar_cantidad_producto.php",
      data: { action: action, valor: valor, idItem: idItem,porcentaje_descuento:porcentaje_descuento },
      success: function(response) {
        console.log(response);
        if (response == 'error') {
          $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
        } else {
          var info = JSON.parse(response);
          if (info.noticia == 'cero_no_valida') {
            // Aquí puedes manejar el caso de cero no válido si es necesario
          }
          if (info.noticia == 'editado_correctamente') {
            var ivaFormateado = parseFloat(info.iva_producto).toFixed(2);
            $('.iva__' + info.idItem + ' ').val(ivaFormateado);
            var subtotalFormateado = parseFloat(info.subtotal_frontend).toFixed(2);
            $('.subtotal__' + info.idItem + ' ').html('$' + subtotalFormateado + ' ');
            $('.cantidad_descuento_'+info.idItem+'').val(info.cantidad_descuento);
            $('.porcentaje_descuento_'+info.idItem+'').val(info.porcentaje_descuento);
            $('.porcentaje_descuento_'+info.idItem+'').attr('cantidad_producto',info.cantidad_producto );

            var action = 'actualizar_resumen';
            var codigoFactura = $('#codigo_factura').val(); // Usar jQuery para obtener el valor
            $.ajax({
              url: 'area_facturacion/actualizar_resumen_pago.php',
              type: 'POST',
              async: true,
              data: { action: action, codigoFactura: codigoFactura },
              success: function(response) {
                console.log(response);
                var info = JSON.parse(response);
                   var compra_total_base_cero = (info.compra_total_base_cero);
                   var compra_total_iva = (info.compra_total_iva);
                   var compra_total_no_objeto = (info.compra_total_no_objeto);
                   var compra_total_excento_iva = (info.compra_total_excento_iva);
                   var subtotal = (info.subtotal);
                   var iva_general = (info.iva_general);
                   var subtotal = (info.subtotal);
                   var total_pagar = (info.total_pagar);

                   $(".compra_total_base_cero").html(compra_total_base_cero.toFixed(2));
                   $(".compra_total_iva").html(compra_total_iva.toFixed(2));
                   $(".no_objeto_alex").html(compra_total_no_objeto);
                   $(".exento_alex").html(compra_total_excento_iva);
                   $(".subtotal_alex").html(subtotal);
                   $(".iva_general").html(iva_general);
                   $("#total_pagar").html(total_pagar);
                   $("#cantidad_metodo_pago").val(total_pagar);
              },
            });
          }
        }
      },
    });
  }
});
