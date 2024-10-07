$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "medico/ingresos.php",
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
          { "data": "codigo_consulta", "render": function(data, type, row) {
              return '<button type="button" cliente="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_cliente"><i class="fas fa-trash-alt"></i></button>' +
                     '<button type="button" cliente="'+data+'" class="btn btn-warning sucursal_'+data+' editar_cliente"><i class="fas fa-edit"></i></button>';
          }},

          { "data": "codigo_consulta", "render": function(data, type, row) {
              return '<a href="detalle_consulta?codigo=' + row.codigo_unico + '">' + data + '</a>';
          }},
          { "data": "estado", "render": function(data, type, row) {
              return '<a href="detalle_consulta?codigo=' + row.codigo_unico + '">' + data + '</a>';
          }},
            {
                "data": "foto_paciente",
                "render": function(data, type, row) {
                    // Verifica si url_img_upload existe y no es null, de lo contrario usa un valor predeterminado
                    var baseUrl = row.url_img_paciente ? row.url_img_paciente : "http://localhost";
                    var imageUrl = baseUrl + "/home/img/uploads/" + data;
                    // Construye la URL del enlace al paciente
                    var patientUrl = "paciente?codigo=" + row.id_cliente;
                    // Devuelve el enlace con la imagen
                    return '<a href="' + patientUrl + '"><img style="width: 80px;" src="' + imageUrl + '" alt="Imagen_producto" /></a>';
                }
            },
            { "data": "nombres_paciente", "render": function(data, type, row) {
                return '<a href="paciente?codigo=' + row.id_cliente + '">' + data + '</a>';
            }},
            { "data": "historia_clinica", "render": function(data, type, row) {
                return '<a href="paciente?codigo=' + row.id_cliente + '">' + data + '</a>';
            }},
            { "data": "mail_paciente", "render": function(data, type, row) {
                return '<a href="paciente?codigo=' + row.id_cliente + '">' + data + '</a>';
            }},
            { "data": "celular", "render": function(data, type, row) {
                return '<a href="paciente?codigo=' + row.historia_clinica + '">' + data + '</a>';
            }},

            { "data": "fecha_ingreso", "render": function(data, type, row) {
                return '<a href="detalle_consulta?codigo=' + row.codigo_unico + '">' + data + '</a>';
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
        "destroy": true,
        "autoWidth": false  // Agrega esta línea
    });

    // Función para enviar datos del formulario
    function sendData_cliente(){
        $('.noticia_agregar_pacientes').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'medico/ingresos.php',
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

                    if (info.noticia == 'usuario_existente') {
                                    $('.noticia_agregar_pacientes').html('<div class="alert alert-warning background-warning">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                        '</button>'+
                                        '<strong>Este usuario ya ha sido registrado aqui te proporcionamos el ID del usuario registrado  !</strong> '+info.cliente+' con identificación '+info.identificacion+'  '+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                    if (info.noticia == 'identificacion_invalida') {
                                    $('.noticia_agregar_pacientes').html('<div class="alert alert-warning background-warning">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                        '</button>'+
                                        '<strong>Identificación !</strong> Inválido'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                    if (info.noticia == 'insert_correct') {
                                    $('.noticia_agregar_pacientes').html('<div class="alert alert-success background-success">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                        '</button>'+
                                        '<strong>Paciente!</strong> Agregado Correctamente, '+info.mensaje_wsp+' '+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_pacientes').html('<div class="alert alert-danger background-danger">'+
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


    $('#tabla_clientes').on('click', '.eliminar_cliente', function(){
        var cliente = $(this).attr('cliente');
        var action = 'eliminar_cliente';
        $.ajax({
            url: 'medico/ingresos.php',
            type: 'POST',
            async: true,
            data: {action: action,cliente:cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                        // Código para manejar inserción correcta
                        tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
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
    $('#tabla_clientes').on('click', '.editar_cliente', function(){
        $('#modal_editar_cliente').modal();
        $(".noticia_editar_clientes").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'medico/ingresos.php',
            type: 'POST',
            async: true,
            data: {action: action, cliente: cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#nombres_update").val(info.nombres);
                    $("#paciente_name").html(info.nombres);
                    $("#email_update").val(info.mail);
                    $("#tipo_identificacion_update").val(info.tipo_identificacion);
                    $("#direccion_update").val(info.direccion);
                    $("#identificacion_update").val(info.identificacion);
                    $("#celular_update").val(info.celular);
                    $("#tipo_cliente_update").val(info.tipo_cliente);
                    $("#actividad_economica_update").val(info.actividad_economica);
                    $("#parroquia_update").val(info.parroquia);
                    $("#ciudad_update").val(info.ciudad);
                    $("#provincia_update").val(info.provincia);
                    $("#telefono_update").val(info.telefono);
                    $("#id_cliente").val(info.id);

                    $("#historial_medico_update").val(info.historial_medico);
                    $("#estado_civil_update").val(info.estado_civil);
                    $("#alergias_update").val(info.alergias);

                    $("#fecha_nacimiento_update").val(info.fecha_nacimiento);
                    $("#genero_update").val(info.genero);

                    $(".img_edit_noticia").html(' <img width="100px" src="'+info.url_img_upload+'/home/img/uploads/'+info.foto+'" alt="">');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Función para editar
    function sendData_update_cliente(){
        $('.alerta_editar_almacen').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'medico/ingresos.php',
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
                                    $('.noticia_editar_clientes').html('<div class="alert alert-success background-success">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                        '</button>'+
                                        '<strong>Paciente!</strong> Editado Correctamente'+
                                    '</div>');

                                      $(".img_edit_noticia").html(' <img width="100px" src="'+info.url_img_upload+'/home/img/uploads/'+info.imagen_cliente+'" alt="">');
                                     tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_editar_clientes').html('<div class="alert alert-danger background-danger">'+
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
    $('#update_cliente').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_cliente();
    });



    // Evento submit del formulario
    $('#add_cliente').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_cliente();
    });
});

(function() {
  $(function() {
    $('#boton_agregar_cliente').on('click', function() {
      $('#modal_agregar_cliente').modal();
      $("#nombre_almacen").val('');
      $("#responsable").val('');
      $("#direccion_almacen").val('');
      $("#descripcion").val('');
      $(".alerta_nuevoproducto").html('');

    });
  });
})();
