$(document).ready(function() {
    // Inicialización de DataTable
    var codigo_farmacia = document.getElementById('codigo_farmacia').value;

    var tabla_productos = $('#tabla_productos').DataTable({
        "ajax": {
            "url": "jquery_administrativo/productos.php",
            "type": "POST",
            "data": {
                "action": 'consultar_datos',
                "codigo_farmacia":codigo_farmacia
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
                return '<a href="view-product?p=' + row.idproducto + '">' + data + '</a>';
            }},
            { "data": "precio", "render": function(data, type, row) {
                return '<a href="producto?codigo=' + row.idproducto + '">' + data + '</a>';
            }},
            { "data": "marca" },
            { "data": "cantidad" },
            { "data": "descripcion" },


               { "data": "descripcion_tienda" },
               { "data": "via_administracion" },
               {
                   "data": "idproducto",
                   "render": function(data, type, row) {
                       // Solo proceder si data tiene un valor "truthy"
                    return '<button type="button" class="btn btn-success" onclick="descargarCodigoBarras(\'' + data + '\')">Descargar</button>';
                   }
               },


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
            url: 'jquery_administrativo/productos.php',
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
                      var  idProducto =info.idproducto;
                                    $('.alerta_nuevoproducto').html(`
                                      <div class="alert alert-success background-success">
                                          <strong>Producto!</strong> Agregado  Correctamente
                                      </div>
                                  `);

                                  $('.boton_compartir_producto_nuevo').html(`
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <button class="btn btn-primary" id="botonCompartir">
                                            <i class="fa fa-share-alt"></i> Compartir
                                        </button>
                                        <a href="publicidad_producto?codigo=${encodeURIComponent(idProducto)}" class="btn btn-success" id="botonWhatsApp">
                                            <i class="fab fa-whatsapp"></i> Realizar Campaña por WhatsApp
                                        </a>

                                        <a href="producto?codigo=${encodeURIComponent(idProducto)}" class="btn btn-info"">
                                            <i class="fas fa-wave-square"></i> Enlace de mi Producto
                                        </a>
                                    </div>
                                `);

                                  $("#producto_creado_estante").val(info.idproducto);

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
            url: 'jquery_administrativo/productos.php',
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
        url: 'jquery_administrativo/productos.php',
        type: 'POST',
        async: true,
        data: {action: action, producto: producto},
        success: function(response){
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

                $("#presentacion_edit").val(info.descripcion_tienda);
                $("#via_administracion_update").val(info.via_administracion);

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
        url: 'jquery_administrativo/productos.php',
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

$(document).ready(function() {
    // Mapeo de códigos de tarifas de IVA a sus porcentajes correspondientes
    var ivaTarifas = {
        '0': 0.00, // 0%
        '2': 0.12, // 12%
        '3': 0.14, // 14%
        '4': 0.15, // 15%
        '5': 0.05, // 5%
        '6': 0.00, // No Objeto de Impuestos
        '7': 0.00, // Exento de IVA
        '8': 0.00, // Iva Diferenciado
        '10': 0.13  // 13%
    };

    function calculoDesdePrecioSinImpuestos() {
        var precioSinImpuestos = parseFloat($("#precio_sin_impuestos").val()) || 0;
        var tarifaIvaCodigo = $("#elejir_tarifa_iva").val();
        var ivaSeleccionado = ivaTarifas[tarifaIvaCodigo] || 0;
        var precioFinalConIva = precioSinImpuestos * (1 + ivaSeleccionado);
        $("#resultado_calculo").val(precioFinalConIva.toFixed(2));
    }

    function calculoDesdePrecioFinal() {
        var precioFinalConIva = parseFloat($("#resultado_calculo").val()) || 0;
        var tarifaIvaCodigo = $("#elejir_tarifa_iva").val();
        var ivaSeleccionado = ivaTarifas[tarifaIvaCodigo] || 0;
        var precioSinImpuestos = precioFinalConIva / (1 + ivaSeleccionado);
        $("#precio_sin_impuestos").val(precioSinImpuestos.toFixed(2));
    }

    // Asignación de eventos a los campos y selectores
    $("#precio_sin_impuestos").on('input', calculoDesdePrecioSinImpuestos);
    $("#elejir_tarifa_iva").on('change', function() {
        // Al cambiar la tarifa de IVA, necesitamos determinar qué campo fue editado por última vez
        if (document.activeElement.id === "resultado_calculo") {
            calculoDesdePrecioFinal();
        } else {
            calculoDesdePrecioSinImpuestos();
        }
    });
    $("#resultado_calculo").on('input', calculoDesdePrecioFinal);
});







$(document).ready(function() {
    // Mapeo de códigos de tarifas de IVA a sus porcentajes correspondientes
    var ivaTarifas = {
        '0': 0.00, // 0%
        '2': 0.12, // 12%
        '3': 0.14, // 14%
        '4': 0.15, // 15%
        '5': 0.05, // 5%
        '6': 0.00, // No Objeto de Impuestos
        '7': 0.00, // Exento de IVA
        '8': 0.00, // Iva Diferenciado
        '10': 0.13  // 13%
    };

    function calculoDesdePrecioSinImpuestos_update() {
        var precioSinImpuestos = parseFloat($("#precio_sin_impuestos_update").val()) || 0;
        var tarifaIvaCodigo = $("#elejir_tarifa_iva_update").val();
        var ivaSeleccionado = ivaTarifas[tarifaIvaCodigo] || 0;
        var precioFinalConIva = precioSinImpuestos * (1 + ivaSeleccionado);
        $("#resultado_calculo_update").val(precioFinalConIva.toFixed(2));
    }

    function calculoDesdePrecioFinal_update() {
        var precioFinalConIva = parseFloat($("#resultado_calculo_update").val()) || 0;
        var tarifaIvaCodigo = $("#elejir_tarifa_iva_update").val();
        var ivaSeleccionado = ivaTarifas[tarifaIvaCodigo] || 0;
        var precioSinImpuestos = precioFinalConIva / (1 + ivaSeleccionado);
        $("#precio_sin_impuestos_update").val(precioSinImpuestos.toFixed(2));
    }

    // Asignación de eventos a los campos y selectores
    $("#precio_sin_impuestos_update").on('input', calculoDesdePrecioSinImpuestos_update);
    $("#elejir_tarifa_iva_update").on('change', function() {
        // Al cambiar la tarifa de IVA, necesitamos determinar qué campo fue editado por última vez
        if (document.activeElement.id === "resultado_calculo_update") {
            calculoDesdePrecioFinal_update();
        } else {
            calculoDesdePrecioSinImpuestos_update();
        }
    });
    $("#resultado_calculo_update").on('input', calculoDesdePrecioFinal_update);
});









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


function descargarCodigoBarras(codigoBarras) {
    // Crear un elemento canvas y generar el código de barras
    var canvas = document.createElement('canvas');
    JsBarcode(canvas, codigoBarras, {
        format: "CODE128",
        lineColor: "#000",
        width: 3,
        height: 40,
        displayValue: true
    });
    // Crear un enlace para la descarga y simular un clic para descargar
    var downloadLink = document.createElement('a');
    downloadLink.download = codigoBarras + '.png';
    downloadLink.href = canvas.toDataURL('image/png');
    downloadLink.click();
}
