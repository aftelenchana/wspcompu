$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_usuarios_base = $('#tabla_usuarios_base').DataTable({
        "ajax": {
            "url": "usuarios_base/usuarios.php",
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
          {
              "data": "id",
              "render": function(data, type, row) {
                  return '<button type="button" plan="'+data+'" class="btn btn-warning sucursal_'+data+' editar_plan"><i class="fas fa-edit"></i></button>';
              }
          },
          { "data": "nombres" },
            { "data": "apellidos" },
            { "data": "email" },
            { "data": "nombre_empresa" },
            { "data": "documentos_electronicos" },
            { "data": "fecha_maxima_documentos" },
            { "data": "numero_identidad" },
            {
              "data": "url_img_upload", // Esta es la base de la URL de la imagen
              "render": function(data, type, row) {
                  // Asegúrate de que tanto la URL base como el nombre de la imagen existen
                  if(data && row.img_facturacion) {
                      var imageUrl = data + '/home/img/uploads/' + row.img_facturacion;
                      return '<img src="'+imageUrl+'" alt="Facturación" style="width:50px; height:auto;">';
                  } else {
                      return 'Sin imagen'; // O cualquier marcador de posición que prefieras
                  }
              }
          }
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





    $('#tabla_usuarios_base').on('click', '.editar_plan', function(){
        $('#modal_editar_plan').modal();
        $(".alerta_editar_plan").html('');
        var plan = $(this).attr('plan');
        var action = 'info_plan';
        $.ajax({
            url: 'usuarios_base/usuarios.php',
            type: 'POST',
            async: true,
            data: {action: action, plan: plan},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    //codigo para cuando no tiene registros
                    if (info.fecha_maxima_documentos == '' || info.fecha_maxima_documentos == null) {
                          $('.notificacion_fecha_max').html('<div class="alert alert-warning background-warning">'+
                          '<strong>Para la Fecha Máxima de Documentos</strong> No existe Datos Ingresa en el casillero correspondiente'+
                          '</div>');
                    }

                    if (info.documentos_electronicos == '' || info.documentos_electronicos == null || info.documentos_electronicos == 0) {
                          $('.notificacion_cantidad_documen').html('<div class="alert alert-warning background-warning">'+
                          '<strong>Para la Cantidad de Documentos !</strong> no existe registro, ingresa una nueva'+
                          '</div>');
                    }
                    //codigo para cuando tiene registros


                    if (info.fecha_maxima_documentos != '' || info.fecha_maxima_documentos != null) {
                          $('.notificacion_fecha_max').html('<div class="alert alert-success background-success">'+
                          '<strong> Fecha Máxima de Documentos</strong> '+info.fecha_maxima_documentos+''+
                          '</div>');
                          $("#fecha_max_doc").val(info.fecha_maxima_documentos);
                    }

                    if (info.documentos_electronicos != '' || info.documentos_electronicos != null || info.documentos_electronicos != 0) {
                          $('.notificacion_cantidad_documen').html('<div class="alert alert-success background-success">'+
                          '<strong>Cantidad de Documentos !</strong>'+info.documentos_electronicos+' '+
                          '</div>');
                          $("#cantid_docuent").val(info.documentos_electronicos);
                    }

                    $(".name_user").html(info.nombres);
                    $("#id_plan").val(info.id);

                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Función para editar_almacen
    function sendData_update_plan(){
        $('.alerta_editar_plan').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_plan')[0]);
        $.ajax({
            data: parametros,
            url: 'usuarios_base/usuarios.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.alerta_editar_plan').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                      if (info.correo == 'no_enviado') {
                        $('.alerta_editar_plan').html('<div class="alert alert-success background-success">'+
                            '<strong>Plan !</strong> Editado Correctamente,el correo no se envio revisa tus credenciales'+
                        '</div>');

                      }
                      if (info.correo == 'enviado') {
                        $('.alerta_editar_plan').html('<div class="alert alert-success background-success">'+
                            '<strong>Plan !</strong> Editado Correctamente, correo enviado Correctamente'+
                        '</div>');

                      }

                  tabla_usuarios_base.ajax.reload(); // Recargar los datos en la tabla
                  }
                  if (info.noticia == 'error_insertar') {
                      $('.alerta_editar_plan').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }

      // ediat_alacen
    $('#update_plan').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_plan();
    });



    // Evento submit del formulario
    $('#add_almacen').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_almacen();
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
      $(".alerta_almacen").html('');

    });
  });
})();
