
$(document).ready(function(){
  $("#busqueda_producto").change(function(){
    var datos = $("#busqueda_producto").val();

    if (datos == 'buscar_op') {
      console.log('escogio_boton_seleccionar');

    }
    if (datos == 'add_producto_sin_registrar') {
      console.log('escogio_boton_registrar');
      $('#modal_agregar_producto_sin_registrar').modal();
      $('.alerta_agregar_producto_sin_registrar').html('');

    }

    if (datos != 'add_producto_sin_registrar' && datos != 'buscar_op' ) {
      var action = 'buscar_productos';
      $.ajax({
        type:"post",
        url:"area_facturacion/busqueda_cliente.php",
        data: {action:action,datos:datos},
        success:function(response){
          console.log(response);
          if (response =='error') {
            $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
          }else {
            var info = JSON.parse(response);
            //variables
            var precio = info.precio;
            var valor_unidad_final_con_impuestps = info.valor_unidad_final_con_impuestps;

            var impuesto = (valor_unidad_final_con_impuestps - precio).toFixed(2);
            $("#valor_unidad").html("$" + parseFloat(info.precio).toFixed(2));
            $("#subtotal").html("$" + parseFloat(info.precio).toFixed(2));
            $("#id_producto").val(info.idproducto);
            $("#impuesto").html("$" + parseFloat(impuesto).toFixed(2));
          }
        }
      })

    }
  });
});
