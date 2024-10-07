$(document).on("click", ".eliminar_item", function() {
    var itemId = $(this).attr("item");
    var action = 'eliminar_item';
    $.ajax({
      type:"post",
      url:"area_facturacion/eliminar_item.php",
      data: {action:action,itemId:itemId},
      success:function(response){
        console.log(response);
        if (response =='error') {
          $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
        }else {
          var info = JSON.parse(response);
          if (info.respuesta == 'eliminado_correctamente') {
            var elemento = document.getElementById('fila'+info.itemId);
            $('.conte_todo_notas_extras'+info.itemId+'').css('display', 'none');

            if (elemento) {
                elemento.style.display = "none";

                var action = 'actualizar_resumen';
                var codigoFactura = document.getElementById('codigo_factura').value;
                $.ajax({
                  url: 'area_facturacion/actualizar_resumen_pago.php',
                  type:'POST',
                  async: true,
                  data: {action:action,codigoFactura:codigoFactura},
                  success: function(response){
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
                            $(".descuento_alex").html(info.descuento_total);
                            $("#total_pagar").html(total_pagar);
                            $("#cantidad_metodo_pago").val(total_pagar);

                  },

                   });
            } else {
              //  console.log('El Elemento fila'+info.itemId+' no existe ');
            }
          }
          if (info.respuesta == 'error_eliminar_producto') {
             $('#errorModal').modal('show');
          }



        }

      }

    })
});
