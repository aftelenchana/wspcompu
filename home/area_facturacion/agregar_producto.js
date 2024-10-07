function sendData_agregar_producto() {
    var parametros = new FormData($('#agregar_producto')[0]);

    parametros.append('sucursal_facturacion', document.getElementById('sucursal_facturacion').value);

    console.log(parametros);

    // Verificar si id_producto está vacío
    if (!parametros.get('id_producto')) {
        // Si id_producto está vacío, reproducir la canción "ejemplo.mp3"
        console.log('esta vacio');
        var audio = new Audio('mutimedia/sonidos/hola.mp3');
        audio.play();
    } else {
        // Si id_producto no está vacío, realizar la consulta AJAX
        $.ajax({
            data: parametros,
            url: "area_facturacion/agregar_producto.php",
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function () {

            },
            success: function (response) {
              console.log(response);

                var info = JSON.parse(response);

              if (info.noticia == 'error_sin_sucursal') {
                $('#modal_agregar_producto_sin_registrar').modal('hide');
                $('.alerta_agregar_producto_sin_registrar').html('');
                  $('#errorModal').modal();
                  $('.informacion_error_sub').html('Antes de Agregar un Producto o Servicio Selecciona tu Sucursal');

              } else {


                    $('.resultado_productos_guardados2').empty();

                    for (var i = 0; i < info.length; i++) {
                        var registro = info[i];
                        // Formatear los valores numéricos con dos decimales
                        var cantidad_formateada = (registro.cantidad_producto);
                        var precio_formateado = parseFloat(registro.valor_unidad).toFixed(2);
                        var descuento_formateado = parseFloat(registro.descuento).toFixed(2);
                        var iva_formateado = parseFloat(registro.iva_producto).toFixed(2);
                        var subtotal_formateado = parseFloat(registro.subtotal_frontend).toFixed(2);
                        var detalle_extra = registro.detalle_extra;
                        var detalle_extra2 = registro.detalle_extra2;
                        var id_producto = registro.id_producto;
                        if (id_producto == '' ||  id_producto == 0) {
                          var estado_boton_editar = 'readonly';

                        }else {
                          var estado_boton_editar = '';

                        }


                        if (detalle_extra != '') {
                          estilo_detalle_estra = '#FFC300';
                        }else {
                            estilo_detalle_estra = '';
                        }

                        if (detalle_extra2 != '') {
                          estilo_detalle_extra2 = '#FFC300';
                        }else {
                          estilo_detalle_extra2 = '';
                        }
                        var porcentaje_descuento = registro.porcentaje_descuento;

                        if (registro.porcentaje_descuento == '') {
                          var porcentaje_descuento = 0;

                        }

                        // Crear un bloque HTML para cada registro
                        var bloqueHTML = '<div class="bloque_input_informacion_producto" id="fila'+registro.id+'">';
                        bloqueHTML += '<p  class="nombre' + registro.id + '" style="display: inline-block;width: 19%;">' + registro.nombre_producto + ' </p>';
                        bloqueHTML += '<input '+estado_boton_editar+'  idItem="'+registro.id+'" class="cantidad_' + registro.id + ' seleccionar_editar_input_cantidad"  porcentaje_descuento = "' + porcentaje_descuento + '" type="text" placeholder="Cant.." name="" value="' + cantidad_formateada + '">';
                        bloqueHTML += '<input readonly class="precio_' + registro.id + '" type="text" placeholder="Prec." name="" value="' + precio_formateado + '">';
                        bloqueHTML += '<input '+estado_boton_editar+' idItem="' + registro.id + '"  required cantidad_producto = "' + cantidad_formateada + '" class="porcentaje_descuento_' + registro.id + ' respuesta_editar_descuento"  type="number" placeholder="%Des." name="" value="' + registro.porcentaje_descuento + '">';
                        bloqueHTML += '<input readonly idItem="' + registro.id + '"  required cantidad_producto = "' + cantidad_formateada + '" class="cantidad_descuento_' + registro.id + ' respuesta_cantidad_descuento"  type="number" placeholder="Descuento" name="" value="' + registro.descuento_formateado +'">';
                        bloqueHTML += '<input readonly class="iva__' + registro.id + '" type="text" placeholder="Iva" name="" value="' + iva_formateado + '">';
                        bloqueHTML += '<p class="subtotal__'+ registro.id +'" style="display: inline-block;width: 16%;text-align: center;">' + subtotal_formateado + '</p>';
                        bloqueHTML += '<p  class="nombre' + registro.id + ' eliminar_item" item="' + registro.id + '" style="display: inline-block;width: 3%;"><i class="fas fa-trash-alt"></i> </p>';
                        bloqueHTML += '</div>'
                        bloqueHTML += '<div id="accordion" class="conte_todo_notas_extras' + registro.id + '" role="tablist" aria-multiselectable="true" style="width: 100%;">'
                        bloqueHTML += '<div class="accordion-panel">'
                        bloqueHTML += '<div class="accordion-heading" role="tab" >'
                        bloqueHTML += '<a class="accordion-msg clase_dar_click_icono" id="contendeor_icono' + registro.id + '" estado="cerrado" codigo_nota = "' + registro.id +'" id="contendeir_icono_agregar_nota" data-toggle="collapse" data-parent="#accordion" href="#collapseOne' + registro.id + '"'
                        bloqueHTML += 'aria-expanded="true" aria-controls="collapseOne' + registro.id + '" style="color: #fff;">'
                        bloqueHTML += '<i class="far fa-plus-square"></i>'
                        bloqueHTML += '</a>'
                        bloqueHTML += '</div>'
                        bloqueHTML += '<div id="collapseOne' + registro.id + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">'
                        bloqueHTML += '<div class="accordion-content accordion-desc">'
                        bloqueHTML += '<span style="color: #fff;">Nota Extra 1</span>'
                        bloqueHTML += '<input style="background:' +estilo_detalle_estra+ '" codigo_nota="' + registro.id + '" id="nota_1' + registro.id + '" nivel_nota="nota_1"  class="nota_extra1' + registro.id + ' seleccionar_nota_extra" onchange="mostrarValor(this);"'
                        bloqueHTML += 'type="text" placeholder="Nota Extra" name="nota_extra" value="' + registro.detalle_extra + '">'
                        bloqueHTML += '<span style="color: #fff;">Nota Extra 2</span>'
                        bloqueHTML += '<input style="background:' +estilo_detalle_extra2+ '" codigo_nota="' + registro.id + '"  id="nota_2' + registro.id + '" nivel_nota="nota_2"  class="nota_extra2' + registro.id + ' seleccionar_nota_extra" onchange="mostrarValor(this);"'
                        bloqueHTML += 'type="text" placeholder="Nota Extra" name="nota_extra" value="' + registro.detalle_extra2 + '">'
                        bloqueHTML += '</div>'
                        bloqueHTML += '</div>'
                        bloqueHTML += '</div>'
                        bloqueHTML += '</div> <hr style="background: #FF5733;border: 1px solid #FF5733;">';
                        ;

                        // Agregar el bloque HTML al contenedor deseado (por ejemplo, un div con clase "resultado_productos_guardados2")
                        $('.resultado_productos_guardados2').append(bloqueHTML);
                    }
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
                            $(".descuento_alex").html(info.descuento_total);
                            $(".iva_general").html(iva_general);
                            $("#total_pagar").html(total_pagar);
                            $("#cantidad_metodo_pago").val(total_pagar);


                      },

                       });



                }
            }
        });
    }
}






function sendData_agregar_sin_registrar() {
  $('.alerta_agregar_producto_sin_registrar').html(' <div class="notificacion_negativa">'+
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
    var parametros = new FormData($('#agregar_producto_sin_registrar')[0]);
     parametros.append('sucursal_facturacion', document.getElementById('sucursal_facturacion').value);

        $.ajax({
            data: parametros,
            url: "area_facturacion/agregar_producto.php",
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function () {

            },
            success: function (response) {
                console.log(response);

                  var info = JSON.parse(response);

                if (info.noticia == 'error_sin_sucursal') {
                  $('#modal_agregar_producto_sin_registrar').modal('hide');
                  $('.alerta_agregar_producto_sin_registrar').html('');
                    $('#errorModal').modal();
                    $('.informacion_error_sub').html('Antes de Agregar un Producto o Servicio Selecciona tu Sucursal');

                } else {


                    $('.resultado_productos_guardados2').empty();
                      $('#modal_agregar_producto_sin_registrar').modal('hide');
                      $('.alerta_agregar_producto_sin_registrar').html('');

                    for (var i = 0; i < info.length; i++) {
                        var registro = info[i];

                        // Formatear los valores numéricos con dos decimales
                        var cantidad_formateada = (registro.cantidad_producto);
                        var precio_formateado = parseFloat(registro.valor_unidad).toFixed(2);
                        var descuento_formateado = parseFloat(registro.descuento).toFixed(2);
                        var iva_formateado = parseFloat(registro.iva_producto).toFixed(2);
                        var subtotal_formateado = parseFloat(registro.subtotal_frontend).toFixed(2);

                        // Crear un bloque HTML para cada registro
                        var bloqueHTML = '<div class="bloque_input_informacion_producto" id="fila'+registro.id+'">';
                        bloqueHTML += '<p  class="nombre' + registro.id + '" style="display: inline-block;width: 19%;">' + registro.nombre_producto + ' </p>';
                        bloqueHTML += '<input idItem="'+registro.id+'" class="cantidad_' + registro.id + ' seleccionar_editar_input_cantidad" type="text" placeholder="Cant.." name="" value="' + cantidad_formateada + '">';
                        bloqueHTML += '<input class="precio_' + registro.id + '" type="text" placeholder="Prec." name="" value="' + precio_formateado + '">';
                        bloqueHTML += '<input class="porcentaje_descuento_' + registro.id + '" type="text" placeholder="%Des." name="" value="' + descuento_formateado + '">';
                        bloqueHTML += '<input class="iva__' + registro.id + '" type="text" placeholder="Iva" name="" value="' + iva_formateado + '">';
                        bloqueHTML += '<p class="subtotal__'+ registro.id +'" style="display: inline-block;width: 16%;text-align: center;">' + subtotal_formateado + '</p>';
                        bloqueHTML += '<p  class="nombre' + registro.id + ' eliminar_item" item="' + registro.id + '" style="display: inline-block;width: 3%;"><i class="fas fa-trash-alt"></i> </p>';
                        bloqueHTML += '</div> <hr>';

                        // Agregar el bloque HTML al contenedor deseado (por ejemplo, un div con clase "resultado_productos_guardados2")
                        $('.resultado_productos_guardados2').append(bloqueHTML);
                    }

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
                            $("#total_pagar").html(total_pagar);
                            $("#cantidad_metodo_pago").val(total_pagar);



                      },

                       });





                }
            }
        });

}
