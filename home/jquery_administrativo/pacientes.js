$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "jquery_administrativo/pacientes.php",
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
              return '<button type="button" cliente="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_cliente"><i class="fas fa-trash-alt"></i></button>' +
                     '<button type="button" cliente="'+data+'" class="btn btn-warning sucursal_'+data+' editar_cliente"><i class="fas fa-edit"></i></button>';
          }},
            { "data": "secuencial" },
            { "data": "nombres", "render": function(data, type, row) {
                return '<a href="paciente?codigo=' + row.id + '">' + data + '</a>';
            }},

            {
                "data": "foto",
                "render": function(data, type, row) {
                    // Verifica si url_img_upload existe y no es null, de lo contrario usa un valor predeterminado
                    var baseUrl = row.url_img_upload ? row.url_img_upload : "http://localhost";
                    var imageUrl = baseUrl + "/home/img/uploads/" + data;
                    // Construye la URL del enlace al paciente
                    var patientUrl = "paciente?codigo=" + row.id;
                    // Devuelve el enlace con la imagen
                    return '<a href="' + patientUrl + '"><img style="width: 80px;" src="' + imageUrl + '" alt="Imagen_producto" /></a>';
                }
            },


            { "data": "identificacion", "render": function(data, type, row) {
                return '<a href="init_consulta?codigo=' + row.id + '">' + data + '</a>';
            }},
            { "data": "fecha_nacimiento" },
            { "data": "genero" },

            { "data": "celular" },
              { "data": "telefono" },
              { "data": "id", "render": function(data, type, row) {
                 return '<button type="button" cliente="'+data+'" class="btn btn-info sucursal_'+data+' generar_tarjeta"><i class="fas fa-id-card"></i></button>';
               }},
              { "data": "mail", "render": function(data, type, row) {
                  return '<a href="paciente?codigo=' + row.id + '">' + data + '</a>';
              }},
              {
               "data": null,
               "render": function(data, type, row) {
                   if (row.latitud && row.longitud) {
                       return '<a href="mapa_paciente?code=' + row.id + '" class="btn btn-success">' +
                              '<i class="fas fa-map-marked-alt"></i>' +
                              '</a>';
                   } else {
                       return ''; // Deja la celda vacía si latitud o longitud están vacíos
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
            url: 'jquery_administrativo/pacientes.php',
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
            url: 'jquery_administrativo/pacientes.php',
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



    $('#tabla_clientes').on('click', '.generar_tarjeta', function(){
        $('#modal_generar_tajeta').modal();
        $(".noticia_generar_tarjeta").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'jquery_administrativo/pacientes.php',
            type: 'POST',
            async: true,
            data: {action: action, cliente: cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $(".nombres_apellidos_tarjeta").html(info.nombres);
                    $(".identificacion_tarjeta").html(info.identificacion);
                    $(".celular_tarjeta").html(info.celular);
                    $(".correo_tarjeta").html(info.mail);
                    $(".cargo_tarjeta").html(info.id);
                    $('.genarate_name_tarjeta').attr('nombre_tarjeta', info.nombres+'-'+info.identificacion);
                    $(".conte_imagen_salida_tarjeta").html('<img class= "mb-3 imagen_foto" src="/home/img/uploads/'+info.foto+'" alt="'+info.foto+'">');
                    $(".conte_qr_salida_tarjeta").html('<img class= "mb-3 qr" src="/home/img/qr/'+info.qr+'" alt="'+info.qr+'">');
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
            url: 'jquery_administrativo/pacientes.php',
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
            url: 'jquery_administrativo/pacientes.php',
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

  $(function() {
    $('#boton_agregar_cliente').on('click', function() {
      $('#modal_agregar_cliente').modal();
      $("#nombre_almacen").val('');
      $("#responsable").val('');
      $("#direccion_almacen").val('');
      $("#descripcion").val('');
      $(".noticia_agregar_pacientes").html('');

    });
  });

  document.getElementById('descargar-tarjeta').addEventListener('click', function() {
    $('.noticia_generar_tarjeta').html('<div class="notificacion_negativa">' +
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>' +
      '</div>');
    html2canvas(document.querySelector("#tarjeta-presentacion")).then(canvas => {
      // Crear un elemento <a> para iniciar la descarga
      let enlace = document.createElement('a');
      // Obtener el nombre de la tarjeta desde el atributo "nombre_tarjeta"
      let nombreTarjeta = document.getElementById('descargar-tarjeta').getAttribute('nombre_tarjeta');
      enlace.download = `${nombreTarjeta}.png`; // Asignar el nombre a la descarga
      // Convertir el canvas en una URL de datos y asignarla como href del enlace
      $('.noticia_generar_tarjeta').html('<div class="alert alert-success background-success">' +
        '<strong>Tarjeta de '+nombreTarjeta+' descargada correctamente</strong>' +
        '</div>');
      enlace.href = canvas.toDataURL('image/png');
      // Simular un clic en el enlace para descargar la imagen
      enlace.click();
    });
  });
