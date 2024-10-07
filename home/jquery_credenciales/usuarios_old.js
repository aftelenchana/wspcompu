$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "jquery_credenciales/usuarios.php",
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

            { "data": "id" },
            {
                "data": "nombres",
                "render": function(data, type, row) {
                    return '<div parametro="nombres" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },

            {
                "data": "identificacion",
                "render": function(data, type, row) {
                    return '<div parametro="identificacion" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },

            {
                "data": "celular",
                "render": function(data, type, row) {
                    return '<div parametro="celular" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },

            {
                "data": "telefono",
                "render": function(data, type, row) {
                    return '<div parametro="telefono" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },

            {
                "data": "mail",
                "render": function(data, type, row) {
                    return '<div parametro="mail" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_sri",
                "render": function(data, type, row) {
                    return '<div parametro="clave_sri" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },

            {
                "data": "clave_mrl_contratos",
                "render": function(data, type, row) {
                    return '<div parametro="clave_mrl_contratos" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_mrl_decimos",
                "render": function(data, type, row) {
                    return '<div parametro="clave_mrl_decimos" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_turismo",
                "render": function(data, type, row) {
                    return '<div parametro="clave_turismo" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_municipio",
                "render": function(data, type, row) {
                    return '<div parametro="clave_municipio" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_turismo_municipio",
                "render": function(data, type, row) {
                    return '<div parametro="clave_turismo_municipio" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_bombero",
                "render": function(data, type, row) {
                    return '<div parametro="clave_bombero" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_ambiental",
                "render": function(data, type, row) {
                    return '<div parametro="clave_ambiental" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_intendencia",
                "render": function(data, type, row) {
                    return '<div parametro="clave_intendencia" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_iees_personal",
                "render": function(data, type, row) {
                    return '<div parametro="clave_iees_personal" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_iees_domestica",
                "render": function(data, type, row) {
                    return '<div parametro="clave_iees_domestica" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_ambiente",
                "render": function(data, type, row) {
                    return '<div parametro="clave_ambiente" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "usuario_arcsa",
                "render": function(data, type, row) {
                    return '<div parametro="usuario_arcsa" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_arcsa",
                "render": function(data, type, row) {
                    return '<div parametro="clave_arcsa" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_firma_electronica",
                "render": function(data, type, row) {
                    return '<div parametro="clave_firma_electronica" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "usuario_facturacion_electronica",
                "render": function(data, type, row) {
                    return '<div parametro="usuario_facturacion_electronica" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_facturacion_electronica",
                "render": function(data, type, row) {
                    return '<div parametro="clave_facturacion_electronica" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "usuario_sercop",
                "render": function(data, type, row) {
                    return '<div parametro="usuario_sercop" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_sercop",
                "render": function(data, type, row) {
                    return '<div parametro="clave_sercop" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "usuario_gerente_superior",
                "render": function(data, type, row) {
                    return '<div parametro="usuario_gerente_superior" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_gerente_superior",
                "render": function(data, type, row) {
                    return '<div parametro="clave_gerente_superior" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },


            {
                "data": "lave_super_compania",
                "render": function(data, type, row) {
                    return '<div parametro="lave_super_compania" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "representante_legal",
                "render": function(data, type, row) {
                    return '<div parametro="representante_legal" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },


            {
                "data": "cedula",
                "render": function(data, type, row) {
                    return '<div parametro="cedula" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },
            {
                "data": "clave_correo",
                "render": function(data, type, row) {
                    return '<div parametro="clave_correo" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
                }
            },


            {
                "data": "clavr_iees_patronal",
                "render": function(data, type, row) {
                    return '<div parametro="clavr_iees_patronal" usuario="' + row.id + '" class="editar_parametro">' + data + '</div>';
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

    // Función para enviar datos del formulario
    function sendData_cliente(){
        $('.noticia_agregar_clientes').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'jquery_credenciales/usuarios.php',
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
                                    $('.noticia_agregar_clientes').html('<div class="alert alert-warning background-warning">'+
                                        '<strong>Usuario !</strong> Registrado con código '+info.cliente+' y correo '+info.mail+''+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                    if (info.noticia == 'identificacion_invalida') {
                                    $('.noticia_agregar_clientes').html('<div class="alert alert-warning background-warning">'+
                                        '<strong>Identificación !</strong> Inválido'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                    if (info.noticia == 'insert_correct') {
                                    $('.noticia_agregar_clientes').html('<div class="alert alert-success background-success">'+
                                        '<strong>Usuario!</strong> Agregado Correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_clientes').html('<div class="alert alert-danger background-danger">'+
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
            url: 'jquery_credenciales/usuarios.php',
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
    $('#tabla_clientes').on('click', '.editar_parametro', function(){
        $('#modal_editar_parametro').modal();
        $(".noticia_editar_parametro").html('');
        var parametro = $(this).attr('parametro');
        var usuario = $(this).attr('usuario');
        var action = 'info_parametro';
        $.ajax({
            url: 'jquery_credenciales/usuarios.php',
            type: 'POST',
            async: true,
            data: {action: action, parametro: parametro, usuario: usuario},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $(".name_parametro").html(info.name_parametro);

                    $('.contenedor_parametro_analizar').html('<div class="form-group">'+
                                            '  <label for="exampleInputEmail1">Parámetro '+info.name_parametro+' para '+info.nombres_cliente+'</label>'+
                                            '  <input type="text" class="form-control" id="nombres_update" name="contenido_parametro" value="'+info.parametro+'" aria-describedby="emailHelp" placeholder="Nombres del Usuario" />'+
                                        '  </div>');
                    $("#id_cliente_edit_param").val(info.usuario);
                    $("#action_edit_param").val(info.name_parametro);

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
            url: 'jquery_credenciales/usuarios.php',
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
                                        '<strong>Parámetro !</strong> Editado Correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
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




    $('#tabla_clientes').on('click', '.editar_cliente', function(){
        $('#modal_editar_cliente').modal();
        $(".noticia_editar_clientes").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'jquery_credenciales/usuarios.php',
            type: 'POST',
            async: true,
            data: {action: action, cliente: cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#nombres_update").val(info.nombres);
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
            url: 'jquery_credenciales/usuarios.php',
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
                                        '<strong>Cliente!</strong> Editado Correctamente'+
                                    '</div>');
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
    $('#update_parametro').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_parametro();
    });



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
      $('#modal_agregar_usuarios_credenciales').modal();
      $("#nombres").val('');
      $("#email").val('');
      $("#celular").val('');
      $("#telfono").val('');
      $("#identificacion").val('');
      $("#direccion").val('');
      $(".noticia_agregar_clientes").html('');

    });
  });
})();
