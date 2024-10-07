  $(document).ready(function() {
var codigo_sucursal = document.getElementById('codigo_sucursal').value;

var tabla_sucursales = $('#tabla_sucursales').DataTable({
    "ajax": {
        "url": "jquery_administrativo/punto_emision_sucursal.php",
        "type": "POST",
        "data": {
            "action": 'consultar_datos',
            "codigo_sucursal":codigo_sucursal
        },
        "dataSrc": "data",
        "error": function(xhr, error, thrown) {
            console.error('Error al cargar los datos:', error);
        }
    },
    "columns": [
        { "data": "id", "render": function(data, type, row) {
            return '<button type="button" sucursal="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_sucursal"><i class="fas fa-trash-alt"></i></button>' +
                   '<button type="button" sucursal="'+data+'" class="btn btn-warning sucursal_'+data+' editar_sucursal"><i class="fas fa-edit"></i></button>';
        }},
        { "data": "direccion_sucursal" },
        {
            "data": "punto_emision",
            "render": function(data, type, row) {
                return ('000' + data).slice(-3);
            }
        },

        { "data": "id", "render": function(data, type, row) {
                return '<a href="editar_secuencial_sucursal?codigo_sucursal=' + data + '">Secuencial Facturación</a>';
        }},
        { "data": "id", "render": function(data, type, row) {
                return '<a href="editar_secuencial_sucursal_notas_credito?codigo_sucursal=' + data + '">Secuencial Nota de Crédito</a>';
        }}




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
function sendData_sucursal(){
    $('.notificacion_agregar_sucursal').html(' <div class="notificacion_negativa">'+
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
    var parametros = new FormData($('#add_sucursal')[0]);
    $.ajax({
        data: parametros,
        url: 'jquery_administrativo/punto_emision_sucursal.php',
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
                                $('.notificacion_agregar_sucursal').html('<div class="alert alert-success background-success">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                    '</button>'+
                                    '<strong>Sucursal!</strong> Agregado Correctamente'+
                                '</div>');
                                tabla_sucursales.ajax.reload(); // Recargar los datos en la tabla
                            }
              if (info.noticia == 'error_insertar') {
                  $('.notificacion_agregar_sucursal').html('<div class="alert alert-danger background-danger">'+
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


$('#tabla_sucursales').on('click', '.eliminar_sucursal', function(){
    var sucursal = $(this).attr('sucursal');
    var action = 'eliminar_sucursal';
    $.ajax({
        url: 'jquery_administrativo/punto_emision_sucursal.php',
        type: 'POST',
        async: true,
        data: {action: action, sucursal: sucursal},
        success: function(response){
            console.log(response);
            if (response != 'error') {
                var info = JSON.parse(response);
                if (info.noticia == 'insert_correct') {
                    // Código para manejar inserción correcta
                    tabla_sucursales.ajax.reload(); // Recargar los datos en la tabla
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
$('#tabla_sucursales').on('click', '.editar_sucursal', function(){
    $('#modal_editar_sucursal').modal();
    $(".alerta_editar_sucursal").html('');
    var sucursal = $(this).attr('sucursal');
    var action = 'info_sucursal';
    $.ajax({
        url: 'jquery_administrativo/punto_emision_sucursal.php',
        type: 'POST',
        async: true,
        data: {action: action, sucursal: sucursal},
        success: function(response){
            console.log(response);
            if (response != 'error') {
                var info = JSON.parse(response);
                $("#direccion_sucursal_update").val(info.direccion_sucursal);
                $("#punto_emision_update").val(info.punto_emision);
                $("#establecimiento_update").val(info.establecimiento);
                $("#id_sucursal").val(info.id);
                $("#codigo_sucursal_in").html(info.id);
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

// Función para editar_almacen
function sendData_update_sucursal(){
    $('.alerta_editar_sucursal').html(' <div class="notificacion_negativa">'+
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
    var parametros = new FormData($('#update_sucursal')[0]);
    $.ajax({
        data: parametros,
        url: 'jquery_administrativo/punto_emision_sucursal.php',
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
                                $('.alerta_editar_sucursal').html('<div class="alert alert-success background-success">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                    '</button>'+
                                    '<strong>Sucursal!</strong> Agregado Correctamente'+
                                '</div>');
                                tabla_sucursales.ajax.reload(); // Recargar los datos en la tabla
                            }
              if (info.noticia == 'error_insertar') {
                  $('.alerta_editar_sucursal').html('<div class="alert alert-danger background-danger">'+
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
$('#update_sucursal').on('submit', function(e) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto
    sendData_update_sucursal();
});



// Evento submit del formulario
$('#add_sucursal').on('submit', function(e) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto
    sendData_sucursal();
});
});



        (function() {
          $(function() {
            $('#boton_agregar_sucursal').on('click', function() {
              $('#modal_agregar_sucursal').modal();
              $("#direccion_sucursal").val('');
              $("#punto_emision").val('');
              $("#establecimiento").val('');
              $(".notificacion_agregar_sucursal").html('');

            });
          });
        })();
