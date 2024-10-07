$(document).ready(function() {
  var tabla_pagos_cuentas_cobrar = $('#tabla_pagos_cuenta_cobrar').DataTable({
      "ajax": {
          "url": "jquery_administrativo/pagos_cuentas_cobrar.php",
          "type": "POST",
          "data": {
              "action": 'consultar_datos'
          },
          "dataSrc": "data",
          "error": function(xhr, error, thrown) {
              console.error('Error al cargar los datos:', error);
               console.log('Respuesta del servidor:', xhr.responseText); // Añadido para depuración
          }
      },
      "columns": [
        { "data": "id", "render": function(data, type, row) {
            return '<button type="button" producto="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_producto"><i class="fas fa-trash-alt"></i></button>';
        }},
          { "data": "cantidad_deposito" },
          { "data": "descripcion" },
          { "data": "fecha" },
          { "data": "estado_financiero" }
      ],
      "dom": 'Bfrtip',
      "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "language": {
          "url": "/home/guibis/data-table.json"
      },
      "order": [],
      "destroy": true
  });


// Función para enviar datos del formulario
function sendData_pago_cuentas_pagar(){
    $('.alerta_agregar_cuenta_cobrar').html(' <div class="notificacion_negativa">'+
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
    var parametros = new FormData($('#add_pago_cuentas_cobrar')[0]);
    $.ajax({
        data: parametros,
        url: 'jquery_administrativo/pagos_cuentas_cobrar.php',
        type: 'POST',
        contentType: false,
        processData: false,
        beforesend: function(){
        },
        success: function(response){
            console.log(response);
            if (response =='error') {
                $('.alerta_agregar_cuenta_cobrar').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
            } else {
                var info = JSON.parse(response);
                if (info.noticia == 'insert_correct') {
                                $('.alerta_agregar_cuenta_cobrar').html('<div class="alert alert-success background-success">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                    '</button>'+
                                    '<strong>Almacen!</strong> Agregado Correctamente'+
                                '</div>');
                                tabla_pagos_cuentas_cobrar.ajax.reload(); // Recargar los datos en la tabla
                            }
              if (info.noticia == 'error_insertar') {
                  $('.alerta_agregar_cuenta_cobrar').html('<div class="alert alert-danger background-danger">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                      '<i class="icofont icofont-close-line-circled text-white"></i>'+
                      '</button>'+
                      '<strong>Error!</strong>Error en el servidor'+
                  '</div>');
              }
              if (info.noticia == 'valor_no_valido') {
                  $('.alerta_agregar_cuenta_cobrar').html('<div class="alert alert-warning background-warning">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                      '<i class="icofont icofont-close-line-circled text-white"></i>'+
                      '</button>'+
                      '<strong>Error!</strong>La cantidad no tiene que superar el valor total'+
                  '</div>');
              }
            }
        }
    });
}


$('#tabla_pagos_cuentas_cobrar').on('click', '.eliminar_almacen', function(){
    var almacen = $(this).attr('almacen');
    var action = 'eliminar_almacen';
    $.ajax({
        url: 'jquery_administrativo/almacen.php',
        type: 'POST',
        async: true,
        data: {action: action, almacen: almacen},
        success: function(response){
            console.log(response);
            if (response != 'error') {
                var info = JSON.parse(response);
                if (info.noticia == 'insert_correct') {
                    // Código para manejar inserción correcta
                    tabla_pagos_cuentas_cobrar.ajax.reload(); // Recargar los datos en la tabla
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
$('#tabla_pagos_cuentas_cobrar').on('click', '.editar_almacen', function(){
    $('#modal_editar_almacen').modal();
    $(".alerta_editar_almacen").html('');
    var almacen = $(this).attr('almacen');
    var action = 'info_almacen';
    $.ajax({
        url: 'jquery_administrativo/almacen.php',
        type: 'POST',
        async: true,
        data: {action: action, almacen: almacen},
        success: function(response){
            console.log(response);
            if (response != 'error') {
                var info = JSON.parse(response);
                $("#nombre_almacen_upload").val(info.nombre_almacen);
                $("#responsable_upload").val(info.direccion_almacen);
                $("#direccion_almacen_upload").val(info.direccion_sucursal);
                $("#sucursal_upload").val(info.cod_sucursal);
                $("#descripcion_upload").val(info.descripcion);
                $("#id_almacen").val(info.id);
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

// Función para editar_almacen
function sendData_update_almacen(){
    $('.alerta_editar_almacen').html(' <div class="notificacion_negativa">'+
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
    var parametros = new FormData($('#update_almacen')[0]);
    $.ajax({
        data: parametros,
        url: 'jquery_administrativo/almacen.php',
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
                                $('.alerta_editar_almacen').html('<div class="alert alert-success background-success">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                    '</button>'+
                                    '<strong>Almacen!</strong> Agregado Correctamente'+
                                '</div>');
                                tabla_pagos_cuentas_cobrar.ajax.reload(); // Recargar los datos en la tabla
                            }
              if (info.noticia == 'error_insertar') {
                  $('.alerta_editar_almacen').html('<div class="alert alert-danger background-danger">'+
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

  // ediat_alacen
$('#update_almacen').on('submit', function(e) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto
    sendData_update_almacen();
});



// Evento submit del formulario
$('#add_pago_cuentas_cobrar').on('submit', function(e) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto
    sendData_pago_cuentas_pagar();
});
});
