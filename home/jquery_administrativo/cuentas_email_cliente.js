$(document).ready(function() {
    // Inicialización de DataTable
    var cliente = document.getElementById('cliente').value;
    var tabla_email_envio_cliente = $('#tabla_email_envio_cliente').DataTable({
        "ajax": {
            "url": "jquery_administrativo/cuentas_email_cliente.php",
            "type": "POST",
            "data": {
                "action": 'consultar_datos',
                "cliente": cliente
            },
            "dataSrc": "data",
            "error": function(xhr, error, thrown) {
                console.error('Error al cargar los datos:', error);
            }
        },
        "columns": [
          { "data": "id", "render": function(data, type, row) {
              return '<button type="button" cuenta_email="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_cuenta_email"><i class="fas fa-trash-alt"></i></button>';
          }},
            { "data": "correo" }
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
    function sendData_agregar_email(){
        $('.alerta_email_envio').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_email_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_administrativo/cuentas_email_cliente.php',
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
                                    $('.alerta_email_envio').html('<div class="alert alert-success background-success">'+
                                        '<strong>Email!</strong> Agregado Correctamente'+
                                    '</div>');
                                    tabla_email_envio_cliente.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.alerta_email_envio').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                  if (info.noticia == 'error_insertar_servidor') {
                      $('.alerta_email_envio').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                  if (info.noticia == 'error_envio') {
                      $('.alerta_email_envio').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong> en el envio de Email verifíca nuevamente'+
                      '</div>');
                  }
                }
            }
        });
    }


    $('#tabla_email_envio_cliente').on('click', '.eliminar_cuenta_email', function(){
        var cuenta_email = $(this).attr('cuenta_email');
        var action = 'eliminar_cuenta_email';
        $.ajax({
            url: 'jquery_administrativo/cuentas_email_cliente.php',
            type: 'POST',
            async: true,
            data: {action: action, cuenta_email: cuenta_email},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                        // Código para manejar inserción correcta
                        tabla_email_envio_cliente.ajax.reload(); // Recargar los datos en la tabla
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




    // Evento submit del formulario
    $('#add_email_cliente').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_agregar_email();
    });
});

(function() {
  $(function() {
    $('#boton_agregar_email_cliente').on('click', function() {
      $('#modal_agregar_email_cliente').modal();
      $("#nombre_almacen").val('');
      $("#responsable").val('');
      $("#direccion_almacen").val('');
      $("#descripcion").val('');
      $(".alerta_email_envio").html('');

    });
  });
})();
