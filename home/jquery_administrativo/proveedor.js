$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_productos = $('#tabla_productos').DataTable({
        "ajax": {
            "url": "jquery_administrativo/proveedor.php",
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
            { "data": "id", "render": function(data, type, row) {
                return '<button type="button" proveedor="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_proveedor"><i class="fas fa-trash-alt"></i></button>' +
                       '<button type="button" proveedor="'+data+'" class="btn btn-warning sucursal_'+data+' editar_proveedor"><i class="fas fa-edit"></i></button>';
            }},
            { "data": "razon_social" },
            { "data": "direccion" },
            { "data": "email" },
            { "data": "celular" },
            { "data": "descripcion_proveedor" }
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
    function sendData_proveedor(){
        $('.alerta_proveedor').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_proveedor')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_administrativo/proveedor.php',
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
                                    $('.alerta_proveedor').html('<div class="alert alert-success background-success">'+
                                        '<strong>Proveedor!</strong> Agregado Correctamente'+
                                    '</div>');
                                    tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.alerta_proveedor').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }

                  if (info.noticia == 'identificacion_invalida') {
                      $('.alerta_proveedor').html('<div class="alert alert-warning background-warning">'+
                          '<strong>Error!</strong>Ingresa una identificación válida'+
                      '</div>');
                  }


                }
            }
        });
    }


    $('#tabla_productos').on('click', '.eliminar_proveedor', function(){
        var proveedor = $(this).attr('proveedor');
        var action = 'eliminar_proveedor';
        $.ajax({
            url: 'jquery_administrativo/proveedor.php',
            type: 'POST',
            async: true,
            data: {action: action, proveedor: proveedor},
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
    $('#tabla_productos').on('click', '.editar_proveedor', function(){
        $('#modal_editar_almacen').modal();
        $(".alerta_editar_almacen").html('');
        var proveedor = $(this).attr('proveedor');
        var action = 'info_proveedor';
        $.ajax({
            url: 'jquery_administrativo/proveedor.php',
            type: 'POST',
            async: true,
            data: {action: action, proveedor: proveedor},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#razon_social_proveedor_upload").val(info.razon_social);
                    $("#identificacion_proveedor_upload").val(info.identificacion);
                    $("#direccion_proveedro_upload").val(info.direccion);
                    $("#celular_proveedo_uploadr").val(info.celular);
                    $("#email_proveedor_upload").val(info.email);
                    $("#descripcion_proveedor_upload").val(info.descripcion_proveedor);
                    $("#id_proveedor").val(info.id);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Función para editar_almacen
    function sendData_update_proveedor(){
        $('.alerta_editar_almacen').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_proveedor')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_administrativo/proveedor.php',
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
                                    tabla_productos.ajax.reload(); // Recargar los datos en la tabla
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
    $('#update_proveedor').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_proveedor();
    });



    // Evento submit del formulario
    $('#add_proveedor').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_proveedor();
    });
});

(function() {
  $(function() {
    $('#boton_agregar_almacen').on('click', function() {
      $('#modal_agregar_almacen').modal();
      $("#nombre_almacen").val('');
      $("#responsable").val('');
      $("#direccion_almacen").val('');
      $("#descripcion").val('');
      $(".alerta_proveedor").html('');

    });
  });
})();
