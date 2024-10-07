$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_parametros = $('#tabla_parametros').DataTable({
        "ajax": {
            "url": "jquery_credenciales/parametros.php",
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
              return '<button type="button" parametro="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_parametro"><i class="fas fa-trash-alt"></i></button>' +
                     '<button type="button" parametro="'+data+'" class="btn btn-warning sucursal_'+data+' editar_parametro"><i class="fas fa-edit"></i></button>';
          }},
          { "data": "id" },
            { "data": "nombre" },
            { "data": "descipcion" },
            { "data": "visibilidad" },
            { "data": "fecha" }

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
    function sendData_parametro(){
        $('.noticia_agregar_parametros').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_parametro')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_credenciales/parametros.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.noticia_agregar_parametros').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);

                    if (info.noticia == 'insert_correct') {
                                    $('.noticia_agregar_parametros').html('<div class="alert alert-success background-success">'+

                                        '<strong>Parámetro!</strong> Agregado Correctamente'+
                                    '</div>');
                                    tabla_parametros.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_parametros').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }


    $('#tabla_parametros').on('click', '.eliminar_parametro', function(){
        var parametro = $(this).attr('parametro');
        var action = 'eliminar_parametro';
        $.ajax({
            url: 'jquery_credenciales/parametros.php',
            type: 'POST',
            async: true,
            data: {action: action,parametro:parametro},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                        // Código para manejar inserción correcta
                        tabla_parametros.ajax.reload(); // Recargar los datos en la tabla
                    }
                    if (info.noticia == 'error_insertar') {
                      console.log('Error en la base de datos');
                        // Código para manejar error al insertar
                    }
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });
    $('#tabla_parametros').on('click', '.editar_parametro', function(){
        $('#modal_editar_parametro').modal();
        $(".noticia_editar_parametro").html('');
        var parametro = $(this).attr('parametro');
        var action = 'info_parametro';
        $.ajax({
            url: 'jquery_credenciales/parametros.php',
            type: 'POST',
            async: true,
            data: {action: action, parametro: parametro},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#nombres_parametro_update").val(info.nombre);

                    $("#descripcion_parametro_update").val(info.descipcion);

                    if(info.visibilidad === "0") {
                     $("#customSwitch_update").prop('checked', false);
                       $('.alerta_estado_visibilidad').html('<div class="alert alert-warning" role="alert">El parámetro no estara visible en todo el sistema!</div>');
                 } else {
                     $("#customSwitch_update").prop('checked', true);
                     $('.alerta_estado_visibilidad').html('<div class="alert alert-success" role="alert">El parámetro estara visible en todo el sistema!</div>');
                 }
                    $("#id_parametro").val(info.id);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Función para editar
    function sendData_update_parametro(){
        $('.noticia_editar_parametro').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_parametro')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_credenciales/parametros.php',
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
                                    $('.noticia_editar_parametro').html('<div class="alert alert-success background-success">'+
                                        '<strong>Paramétro!</strong> Editado Correctamente'+
                                    '</div>');
                                    tabla_parametros.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_editar_parametro').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }

      // ediat_alacen
    $('#update_parametro').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_parametro();
    });



    // Evento submit del formulario
    $('#add_parametro').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_parametro();
    });
});

(function() {
  $(function() {
    $('#boton_agregar_cliente').on('click', function() {
      $('#modal_agregar_parametro').modal();
      $("#nombres_parametro").val('');
      $("#descripcion_parametro").val('');
      $(".noticia_agregar_parametros").html('');

    });
  });
})();
