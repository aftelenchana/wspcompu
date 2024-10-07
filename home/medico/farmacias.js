$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_plan_cuentas = $('#tabla_plan_cuentas').DataTable({
        "ajax": {
            "url": "medico/farmacias.php",
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
          {
              "data": "id",
              "render": function(data, type, row) {
             return '<button type="button" parametro="'+data+'" class="btn btn-warning editar_parametro" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="fas fa-pencil-alt"></i></button>' +
                    '<button type="button" parametro="'+data+'" class="btn btn-danger eliminar_parametro" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="fas fa-times"></i></button>';
           }
              },
              {
               "data": "imagen",
               "render": function(data, type, row) {
                   // Devuelve el elemento img con la URL
                   return '<img  style="width: 80px;"src="/home/img/uploads/' + data + '" alt="' + data + '" />';
               }
               },

            { "data": "nombre_farmacia" },
            { "data": "email", "render": function(data, type, row) {
                return '<a href="productos?farmacias=' + row.id + '">' + data + '</a>';
            }},
            { "data": "password" },
            { "data": "fecha" },


            // ... tus otras columnas ...
        ],

        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "/home/guibis/data-table.json" // Asegúrate de que esta sea la URL correcta y actual
        },
        "order": [],
        "destroy": true,
        "lengthChange": true,
        "lengthMenu": [[ 10, 20, 25, 50, -1], [ 10, 20, 25, 50, "Todos"]],

            // ... el resto de tu configuración ...

            dom: 'Bfrtip', // El elemento DOM B para botones
            buttons: [
                 {
                     extend: 'pdfHtml5',
                     text: '<i class="fa fa-file-pdf"></i> Exportar a PDF',
                     titleAttr: 'PDF',
                     className: 'btn btn-danger',
                     title: 'Reporte de Plan de Cuentas',
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     text: '<i class="fa fa-file-excel"></i> Exportar a Excel',
                     titleAttr: 'Excel',
                     className: 'btn btn-success',
                     title: 'Reporte de Plan de Cuentas',
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 // ... otros botones que necesites ...
             ],
    });


          // AGREGAR ASIENTO CONTABLE
        $('#agregar_asiento_contable').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío del formulario por defecto
            sendData_agregar_asiento_contable();
        });

    // Función para editar
    function sendData_agregar_asiento_contable(){
        $('.noticia_agregar_farmacias').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#agregar_asiento_contable')[0]);
        $.ajax({
            data: parametros,
            url: 'medico/farmacias.php',
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
                                    $('.noticia_agregar_farmacias').html('<div class="alert alert-success background-success">'+
                                        '<strong>Datos !</strong> Agregados Correctamente'+
                                    '</div>');
                                    tabla_plan_cuentas.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_farmacias').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                  if (info.noticia == 'correo_administrador') {
                      $('.noticia_agregar_farmacias').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Correo no válido!</strong> Utiliza un correo diferente al Administrador'+
                      '</div>');
                  }
                  if (info.noticia == 'cuenta_existente') {
                      $('.noticia_agregar_farmacias').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Identificación no disponible!</strong> ya tienes un usuario con esta identificación '+
                      '</div>');
                  }
                }
            }
        });
    }




        $('#tabla_plan_cuentas').on('click', '.eliminar_parametro', function(){

            var parametro = $(this).attr('parametro');
            console.log(parametro);
            var action = 'eliminar_parametro';
            $.ajax({
                url: 'medico/farmacias.php',
                type: 'POST',
                async: true,
                data: {action: action,parametro:parametro},
                success: function(response){
                    console.log(response);
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        if (info.noticia == 'insert_correct') {
                            // Código para manejar inserción correcta
                            tabla_plan_cuentas.ajax.reload(); // Recargar los datos en la tabla
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




    // EDITAR PARAMETRO DEL ASIENTO CONTABLE
  $('#editar_asiento_contable').on('submit', function(e) {
      e.preventDefault(); // Prevenir el envío del formulario por defecto
      sendData_editar_asientio_contable();
  });

// Función para editar
function sendData_editar_asientio_contable(){
  $('.noticia_editar_farmacia').html(' <div class="notificacion_negativa">'+
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new FormData($('#editar_asiento_contable')[0]);
  $.ajax({
      data: parametros,
      url: 'medico/farmacias.php',
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
                              $('.noticia_editar_farmacia').html('<div class="alert alert-success background-success">'+
                                  '<strong>Datos !</strong> Editados Correctamente'+
                              '</div>');
                              tabla_plan_cuentas.ajax.reload(); // Recargar los datos en la tabla
                          }
            if (info.noticia == 'error_insertar') {
                $('.noticia_editar_farmacia').html('<div class="alert alert-danger background-danger">'+
                    '<strong>Error!</strong>Error en el servidor'+
                '</div>');
            }
            if (info.noticia == 'cuenta_existente') {
                $('.noticia_editar_farmacia').html('<div class="alert alert-danger background-danger">'+
                    '<strong>Correo existente!</strong> Utiliza un correo diferente'+
                '</div>');
            }
          }
      }
  });
}


    $('#tabla_plan_cuentas').on('click', '.editar_parametro', function(){
        $('#modal_editar_asientos_contables').modal();
        $(".noticia_editar_asiento_contable").html('');
        var parametro = $(this).attr('parametro');
        var action = 'info_parametro';
        $.ajax({
            url: 'medico/farmacias.php',
            type: 'POST',
            async: true,
            data: {action: action, parametro: parametro},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $("#nombre_farmacia_update").val(info.nombre_farmacia);
                    $("#email_update").val(info.email);
                    $("#password_update").val(info.password);
                    $(".contenedor_salida_imagen_editar").html('<img class= "mb-3 imagen_foto" src="/home/img/uploads/'+info.imagen+'" alt="'+info.imagen+'">');
                    $("#asiento_contable_update").val(info.id);


                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

});

  $(function() {
    $('#boton_agregar_asiento_contable').on('click', function() {
      $('#modal_agregar_asiento_contable').modal();
      $("#nombre").val('');
      $("#url").val('');
      $("#user_name").val('');
      $("#password").val('');
      $("#descripcion").val('');
      $(".noticia_agregar_asientos_contables").html('');

    });
  });
