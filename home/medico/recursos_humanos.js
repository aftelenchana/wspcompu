$(document).ready(function() {

    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "medico/recursos_humanos.php",
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
            {
             "data": "foto",
             "render": function(data, type, row) {
                 // Devuelve el elemento img con la URL
                 return '<img  style="width: 80px;"src="/home/img/uploads/' + data + '" alt="' + data + '" />';
             }
             },
            { "data": "nombres", "render": function(data, type, row) {
                return '<a href="perfil_usuario_recursos_humanos?code=' + row.id + '">' + data + '</a>';
            }},
            { "data": "identificacion", "render": function(data, type, row) {
                return '<a href="perfil_usuario_recursos_humanos?code=' + row.id + '">' + data + '</a>';
            }},

            { "data": "celular" },
              { "data": "telefono" },
              { "data": "mail", "render": function(data, type, row) {
                  return '<a href="perfil_usuario_recursos_humanos?codigo=' + row.id + '">' + data + '</a>';
              }},

              { "data": "documento", "render": function(data, type, row) {
                if(data) {
            return '<a href="javascript:void(0);" onclick="openPdfViewer(\'/home/archivos/documentos/' + data + '\')"><i class="fas fa-file-pdf" style="font-size:24px;"></i></a>';
            } else {
                return '';
            }
           }},

           { "data": "id", "render": function(data, type, row) {
              return '<button type="button" cliente="'+data+'" class="btn btn-info sucursal_'+data+' generar_tarjeta"><i class="fas fa-id-card"></i></button>';
            }},
            {
                "data": "qr",
                "render": function(data, type, row) {
                    // Construye la URL completa de la imagen
                    var imageUrl = "/home/img/qr/" + data;
                    // Devuelve el elemento img con el URL dentro de un enlace
                    return '<a href="historial_sensor?code='+row.id+'" ><img style="width: 80px;" src="' + imageUrl + '" alt="' + data + '" /></a>';
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




    $('#tabla_clientes').on('click', '.generar_tarjeta', function(){
        $('#modal_generar_tajeta').modal();
        $(".noticia_generar_tarjeta").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_recursos_humanos_tarjeta';
        $.ajax({
            url: 'medico/recursos_humanos.php',
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
                    $(".cargo_tarjeta").html(info.cargo);
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

    // Función para enviar datos del formulario
    function sendData_cliente(){
        $('.noticia_agregar_clientes').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'medico/recursos_humanos.php',
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
                                        '<strong>Este usuario ya se enuentra registrado intenta nuevamente con un número de identificación, el usuario registrado es con identificación '+info.identificacion+', códio '+info.id+' !</strong> Registrado'+
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
            url: 'medico/recursos_humanos.php',
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
        $(".alerta_editar_cliente").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'medico/recursos_humanos.php',
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
                    $("#categoria_recursos_humanos_update").val(info.categoria_recursos_humanos);
                    $("#cargas_familiares_update").val(info.cargas_familiares);
                    $("#id_cliente").val(info.id);
                    $(".contenedor_salida_imagen_editar").html('<img width="80px;" src="/home/img/uploads/'+info.foto+'" alt="'+info.foto+'">');
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
            url: 'medico/recursos_humanos.php',
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
                                        '<strong>Usuario!</strong> Editado Correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_editar_clientes').html('<div class="alert alert-danger background-danger">'+
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
      $(".alerta_nuevoproducto").html('');

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


$(document).ready(function(){
  $("#categoria_recursos_humanos").change(function(){
    console.log('gg');
    var textoSeleccionado = $("#categoria_recursos_humanos option:selected").text();
    if (textoSeleccionado.toUpperCase() === 'DISTRIBUIDOR') {
        var action = 'buscar_lineas_distribucion';
        $.ajax({
            url: 'jquery_administrativo/lineas_distribucion.php',
            type: 'POST',
            async: true,
            data: {action: action},
            success: function(response){
                console.log(response);
                var info = JSON.parse(response);

                $('.generador_lineas_distribucion').html('<div class="form-group"><label class="label-guibis-sm" >Línea de Dstribución</label><select class="form-control input-guibis-sm" name="lineas_distribucion" required id="lineas_distribucion">' +
                                                    '</select></select>');

                $.each(info.data, function(index, item) {
                    var newOption = $('<option>').val(item.id).text(item.nombre);
                    $('#lineas_distribucion').append(newOption);
                });
            },
            error: function(error){
                console.error('Error al cargar las líneas de distribución:', error);
            }
        });
    }else {
      $('.generador_lineas_distribucion').html('');


    }
  });
});
