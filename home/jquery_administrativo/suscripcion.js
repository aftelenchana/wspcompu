$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_productos = $('#tabla_productos').DataTable({
        "ajax": {
            "url": "jquery_administrativo/suscripcion.php",
            "type": "POST",
            "data": {
                "action": 'consultar_datos'
            },
            "dataSrc": "data",
            "error": function(xhr, error, thrown) {
                console.error('Error al cargar los datos:', error);
            }
        },
        "columns": [
            { "data": "idproducto", "render": function(data, type, row) {
              return '<button type="button" producto="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_producto"><i class="fas fa-trash-alt"></i></button>' +
       '<button type="button" producto="'+data+'" class="btn btn-warning producto_'+data+' editar_producto"><i class="fas fa-edit"></i></button>';
            }},
            { "data": "idproducto" },

            {
             "data": "foto",
             "render": function(data, type, row) {
                 // Construye la URL completa de la imagen
                 var imageUrl = row.url_upload_img + "/home/img/uploads/" + data;
                 // Devuelve el elemento img con la URL
                 return '<img  style="width: 80px;"src="' + imageUrl + '" alt="Imagen_producto" />';
             }
             },

            { "data": "nombre", "render": function(data, type, row) {
                return '<a href="servicio_suscripcion?codigo=' + row.idproducto + '">' + data + '</a>';
            }},
            { "data": "precio", "render": function(data, type, row) {
                return '<a href="servicio_suscripcion?codigo=' + row.idproducto + '">' + data + '</a>';
            }},
            { "data": "marca" },
            { "data": "cantidad" },
            { "data": "descripcion" },
            {
             "data": "qr",
             "render": function(data, type, row) {
                 // Construye la URL completa de la imagen
                 var imageUrl = row.url_upload_qr + "/home/img/qr/" + data;
                 // Devuelve el elemento img con la URL
                 return '<img  style="width: 80px;"src="' + imageUrl + '" alt="QR Code" />';
             }
             },
             {
                 "data": "codigo_barras",
                 "render": function(data, type, row) {
                     // Solo proceder si data tiene un valor "truthy"
                     if (data) {
                         // Crear un ID único para cada SVG basado en el ID del producto
                         var barcodeId = "barcode_" + row.idproducto;
                         // Retrasa la generación del código de barras hasta después de que la tabla se haya renderizado
                         setTimeout(function() {
                             JsBarcode("#" + barcodeId, data, {
                                 format: "CODE128",
                                 lineColor: "#000",
                                 width: 2,
                                 height: 30,
                                 displayValue: true
                             });
                         }, 50);
                         // Devuelve el SVG con el ID único
                         return '<svg id="' + barcodeId + '"></svg>';
                     } else {
                         // Devuelve un string vacío o algún marcador si data no es válido
                         return '';
                     }
                 }
             },
             { "data": "categorias"},
             { "data": "subcategorias"},
             { "data": "provincia"},
             { "data": "ciudad"},
             { "data": "visibilidadExterna"},
             { "data": "visibilidadInterna"}


        ],

        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "/home/guibis/data-table.json"
        },
        "order": [],
         "destroy": true,
         "autoWidth": false  // Agrega esta línea
    });

    // Función para enviar datos del formulario
    function sendData_producto(){
        $('.alerta_nuevoproducto').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_producto')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_administrativo/suscripcion.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.alerta_nuevoproducto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                                    $('.alerta_nuevoproducto').html(`
                                      <div class="alert alert-success background-success">
                                          <strong>Producto!</strong> Agregado  Correctamente
                                          <br>
                                          <button class="btn btn-primary" id="botonCompartir">
                                              <i class="fa fa-share-alt"></i> Compartir
                                          </button>
                                      </div>
                                  `);




                                      $(document).on('click', '#botonCompartir', function() {
                                      var url = 'https://guibis.com/suscripcion?codigo='+info.idproducto+''; // Reemplaza con la URL dinámica si es necesario
                                      navigator.clipboard.writeText(url).then(function() {
                                          alert("URL copiada al portapapeles: " + url);
                                      }).catch(function(error) {
                                          alert("Error al copiar la URL: ", error);
                                      });
                                  });



                                    tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error') {
                      $('.alerta_nuevoproducto').html('<div class="alert alert-danger background-danger">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<i class="icofont icofont-close-line-circled text-white"></i>'+
                          '</button>'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }


    $('#tabla_productos').on('click', '.eliminar_producto', function(){
        var producto = $(this).attr('producto');
        var action = 'eliminar_productos';
        $.ajax({
            url: 'jquery_administrativo/suscripcion.php',
            type: 'POST',
            async: true,
            data: {action: action,producto:producto},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                        // Código para manejar inserción correcta
                        tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                    }
                    if (info.noticia == 'error_insertar') {
                        // Código para manejar error al insertar
                    }
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });




    $('#tabla_productos').on('click', '.editar_producto', function(){
    $('#modal_editar_producto').modal();
    $(".notificacion_editar_producto").html('');
    var producto = $(this).attr('producto');
    var action = 'info_producto';
    $.ajax({
        url: 'jquery_administrativo/suscripcion.php',
        type: 'POST',
        async: true,
        data: {action: action, producto: producto},
        success: function(response){
            console.log(response);
            if (response != 'error') {
                var info = JSON.parse(response);
                $(".producto_a_editar").html(info.nombre);
                $(".nombre_producto_edit").val(info.nombre);
                $(".precio_edit").val(info.precio);
                $(".precio_costo_upload").val(info.precio_costo);
                $("#codigo_barras_upload").val(info.codigo_barras);
                $("#tipo_ambiente").val(info.tipo_ambiente);
                $(".codigos_impuestos_edit").val(info.codigos_impuestos);
                $(".resultado_calculo_edit").val(info.valor_unidad_final_con_impuestps);
                $(".cantidad_edit").val(info.cantidad);
                $("#marca_codigo_edit").val(info.marca);
                $(".proveedor_edit").val(info.proveedor);
                $(".descripcion_edit").val(info.descripcion);
                $(".categoria_rst_edit").val(info.categoria_rst);
                $("#idproducto").val(info.idproducto);

                $("#categorias").val(info.categorias);
                $("#subcategorias").val(info.subcategorias);
                $("#provincia").val(info.provincia);
                $("#ciudad").val(info.ciudad);
                $("#url_producto").val('https://guibis.com/producto?codigo='+info.idproducto+'');





                if(info.visibilidadExterna == "on") {
                    $("#customSwitchExterno").prop('checked', true);
                    $('.alerta_estado_visibilidad_externa').html('<div class="alert alert-success" role="alert">El producto se visualizará en la tienda digital!</div>');
                } else {
                    $("#customSwitchExterno").prop('checked', false); // Corregido el ID aquí
                    $('.alerta_estado_visibilidad_externa').html('<div class="alert alert-warning" role="alert">El producto no se visualizará en la tienda digital!</div>');
                }

                if(info.visibilidadInterna == "on") {
                    $("#customSwitchInterno").prop('checked', true); // Corregido el ID aquí
                    $('.alerta_estado_visibilidad_interna').html('<div class="alert alert-success" role="alert">El producto se visualizará en el área de productos interna!</div>');
                } else {
                    $("#customSwitchInterno").prop('checked', false); // Corregido el ID aquí
                    $('.alerta_estado_visibilidad_interna').html('<div class="alert alert-warning" role="alert">El producto no se visualizará en el área de productos interna!</div>');
                }

                $(".img_edit_noticia").html(' <img width="100px" src="'+info.url_upload_img+'/home/img/uploads/'+info.foto+'" alt="">');
                $(".notificacion_editar_producto").html('');
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

// Función para editar_almacen
function sendData_update_producto(){
    $('.notificacion_editar_producto').html(' <div class="notificacion_negativa">'+
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
    var parametros = new FormData($('#update_producto')[0]);
    $.ajax({
        data: parametros,
        url: 'jquery_administrativo/suscripcion.php',
        type: 'POST',
        contentType: false,
        processData: false,
        beforesend: function(){
        },
        success: function(response){
            console.log(response);
            if (response =='error') {
                $('.notificacion_agregar_sucursal').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
            } else {
                var info = JSON.parse(response);
                if (info.noticia == 'insert_correct') {
                                $('.notificacion_editar_producto').html('<div class="alert alert-success background-success">'+
                                    '<strong>Producto!</strong> Editado Correctamente'+
                                '</div>');





                                tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                            }
              if (info.noticia == 'error_insertar') {
                  $('.notificacion_editar_producto').html('<div class="alert alert-danger background-danger">'+
                      '<strong>Error!</strong>Error en el servidor'+
                  '</div>');
              }
            }
        }
    });
}

  // ediat_alacen
$('#update_producto').on('submit', function(e) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto
    sendData_update_producto();
});



    // Evento submit del formulario
    $('#add_producto').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_producto();
    });
});

(function() {
  $(function() {
    $('#boton_agregar_producto').on('click', function() {
      $('#modal_agregar_producto').modal();
      $("#nombre_almacen").val('');
      $("#responsable").val('');
      $("#direccion_almacen").val('');
      $("#descripcion").val('');
      $(".alerta_nuevoproducto").html('');

    });
  });
})();

function calculo_precio_final_input() {
  var elejir_tarifa_iva = $("#elejir_tarifa_iva").val();
  var precio_sin_impuestos = parseFloat($("#precio_sin_impuestos").val());

  if (elejir_tarifa_iva == '2') {
    var precio_final_con_tarifa = ((precio_sin_impuestos * 0.12) + precio_sin_impuestos).toFixed(2);;
    $("#resultado_calculo").val(precio_final_con_tarifa);
  } else {
    $("#resultado_calculo").val(precio_sin_impuestos);
  }
}



function calculo_precio_sin_impuestos() {
  var precio_final = parseFloat($("#resultado_calculo").val());
  var tarifa_iva = $("#elejir_tarifa_iva").val();

  // Asumiendo que la tarifa de IVA es del 12% como en tu función original
  var iva = 0.12;
  var precio_sin_impuestos;

  if (tarifa_iva == '2') { // Si el precio final incluye IVA
    precio_sin_impuestos = (precio_final / (1 + iva)).toFixed(2);
    $("#precio_sin_impuestos").val(precio_sin_impuestos);
  } else { // Si el precio final no incluye IVA
    $("#precio_sin_impuestos").val(precio_final.toFixed(2));
  }

  // Actualizar la selección de tarifa de IVA basada en el precio final
  // Esto es más complicado porque necesitas una lógica para determinar la tarifa de IVA basada en el precio final
  // Por ejemplo, si el precio final es igual al precio sin impuestos, entonces es 'SIN IVA'
  // Necesitarás ajustar esta lógica basándote en tus reglas de negocio específicas
  if (precio_final === precio_sin_impuestos) {
    $("#elejir_tarifa_iva").val('0'); // SIN IVA
  } else {
    // Aquí necesitas más condiciones para determinar cuándo es 'Exento de IVA' o 'No Objeto de Impuesto'
    // Por ahora, solo pondré 'CON IVA' como ejemplo
    $("#elejir_tarifa_iva").val('2'); // CON IVA
  }
}




function calculo_precio_final_input_upload() {
  var elejir_tarifa_iva = $(".elejir_tarifa_iva_upload").val();
  var precio_sin_impuestos = parseFloat($(".precio_sin_impuestos_upload").val());

  if (elejir_tarifa_iva == '2') {
    var precio_final_con_tarifa = ((precio_sin_impuestos * 0.12) + precio_sin_impuestos).toFixed(2);;
    $(".resultado_calculo_upload").val(precio_final_con_tarifa);
  } else {
    $(".resultado_calculo_upload").val(precio_sin_impuestos);
  }
}




function calculo_precio_sin_impuestos_upload() {
  var precio_final = parseFloat($(".resultado_calculo_upload").val());
  var tarifa_iva = $(".elejir_tarifa_iva_upload").val();

  // Asumiendo que la tarifa de IVA es del 12% como en tu función original
  var iva = 0.12;
  var precio_sin_impuestos;

  if (tarifa_iva == '2') { // Si el precio final incluye IVA
    precio_sin_impuestos = (precio_final / (1 + iva)).toFixed(2);
    $(".precio_sin_impuestos_upload").val(precio_sin_impuestos);
  } else { // Si el precio final no incluye IVA
    $(".precio_sin_impuestos_upload").val(precio_final.toFixed(2));
  }

  // Actualizar la selección de tarifa de IVA basada en el precio final
  // Esto es más complicado porque necesitas una lógica para determinar la tarifa de IVA basada en el precio final
  // Por ejemplo, si el precio final es igual al precio sin impuestos, entonces es 'SIN IVA'
  // Necesitarás ajustar esta lógica basándote en tus reglas de negocio específicas
  if (precio_final === precio_sin_impuestos) {
    $("#elejir_tarifa_iva").val('0'); // SIN IVA
  } else {
    // Aquí necesitas más condiciones para determinar cuándo es 'Exento de IVA' o 'No Objeto de Impuesto'
    // Por ahora, solo pondré 'CON IVA' como ejemplo
    $("#elejir_tarifa_iva").val('2'); // CON IVA
  }
}


//EDITAR PRODUCTO
$("document").ready(function(){
$( "#categorias" ).load( "server/datos.php" );
$("#categorias").change(function(){
    var id =   $("#categorias").val();
    $.get("server/datos1.php", {id:id})
    .done(function(data){
    $("#subcategorias" ).html(data);
   })
})
})

$("document").ready(function(){
$( "#provincia" ).load( "server/lugar.php" );
$("#provincia").change(function(){
var idd =   $("#provincia").val();
$.get("server/lugar1.php", {id:idd})
.done(function(data){
$("#ciudad" ).html( data );
})
})
})

function cambiarEstatus(elemento, tipo) {
    var alertaEstado;
    var mensajeVisible;
    var mensajeNoVisible;

    if (tipo === 'externa') {
        alertaEstado = $('.alerta_estado_visibilidad_externa');
        mensajeVisible = 'El producto se visualizará en la tienda digital!';
        mensajeNoVisible = 'El producto no se visualizará en la tienda digital!';
    } else if (tipo === 'interna') {
        alertaEstado = $('.alerta_estado_visibilidad_interna');
        mensajeVisible = 'El producto se visualizará en el área de productos interna!';
        mensajeNoVisible = 'El producto no se visualizará en el área de productos interna!';
    }

    if (elemento.checked) {
        alertaEstado.html('<div class="alert alert-success" role="alert">' + mensajeVisible + '</div>');
        console.log("El switch está en ON, estatus activado para " + tipo);
    } else {
        alertaEstado.html('<div class="alert alert-warning" role="alert">' + mensajeNoVisible + '</div>');
        console.log("El switch está en OFF, estatus desactivado para " + tipo);
    }
}


//AGREGAR PRODUCTO


$("document").ready(function(){
$( "#categorias2" ).load( "server/datos.php" );
$("#categorias2").change(function(){
    var id =   $("#categorias2").val();
    $.get("server/datos1.php", {id:id})
    .done(function(data){
    $("#subcategorias2" ).html(data);
   })
})
})

$("document").ready(function(){
$( "#provincia2" ).load( "server/lugar.php" );
$("#provincia2").change(function(){
var idd =   $("#provincia2").val();
$.get("server/lugar1.php", {id:idd})
.done(function(data){
$("#ciudad2" ).html( data );
})
})
})


$(document).on('click', '#botonCompartir_editar', function() {
  var url = document.getElementById('url_producto').value;
navigator.clipboard.writeText(url).then(function() {
    alert("URL copiada al portapapeles: " + url);
}).catch(function(error) {
    alert("Error al copiar la URL: ", error);
});
});
