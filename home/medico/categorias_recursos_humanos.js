$(document).ready(function() {

var tabla_sucursales = $('#tabla_sucursales').DataTable({
  "ajax": {
      "url": "medico/categorias_recursos_humanos.php",
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
          return '<button type="button" categoria="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_categoria"><i class="fas fa-trash-alt"></i></button>' +
                 '<button type="button" categoria="'+data+'" class="btn btn-warning sucursal_'+data+' editar_categoria"><i class="fas fa-edit"></i></button>';
      }},

      { "data": "nombre" },

      { "data": "descripcion" },
      { "data": "fecha" },
      { "data": "salario" }
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
function sendData_categoria_wsp(){
  $('.notificacion_agregar_categoria_wsp').html(' <div class="notificacion_negativa">'+
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new FormData($('#add_categoria_wsp')[0]);
  $.ajax({
      data: parametros,
      url: 'medico/categorias_recursos_humanos.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){
      },
      success: function(response){
          console.log(response);
          if (response =='error') {
              $('.notificacion_agregar_categoria_wsp').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
          } else {
              var info = JSON.parse(response);
              if (info.noticia == 'insert_correct') {
                              $('.notificacion_agregar_categoria_wsp').html('<div class="alert alert-success background-success">'+
                                  '<strong>Cargo!</strong> Agregado Correctamente'+
                              '</div>');
                              tabla_sucursales.ajax.reload(); // Recargar los datos en la tabla
                          }
            if (info.noticia == 'error_insertar') {
                $('.notificacion_agregar_categoria_wsp').html('<div class="alert alert-danger background-danger">'+
                    '<strong>Error!</strong>Error en el servidor'+
                '</div>');
            }
          }
      }
  });
}


$('#tabla_sucursales').on('click', '.eliminar_categoria', function(){
  var categoria = $(this).attr('categoria');
  var action = 'eliminar_categoria';
  $.ajax({
      url: 'medico/categorias_recursos_humanos.php',
      type: 'POST',
      async: true,
      data: {action: action, categoria: categoria},
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
$('#tabla_sucursales').on('click', '.editar_categoria', function(){
  $('#modal_editar_sucursal').modal();
  $(".alerta_editar_categoria").html('');
  var categoria = $(this).attr('categoria');
  var action = 'info_categoria';
  $.ajax({
      url: 'medico/categorias_recursos_humanos.php',
      type: 'POST',
      async: true,
      data: {action: action, categoria: categoria},
      success: function(response){
          console.log(response);
          if (response != 'error') {
              var info = JSON.parse(response);
              $("#nombre_categoria_upload").val(info.nombre);
              $("#descripcion_upload").val(info.descripcion);
              $("#id_categoria").val(info.id);
              $("#salario_upload").val(info.salario);
              $("#codigo_categoria").html(info.nombre);
          }
      },
      error: function(error){
          console.log(error);
      }
  });
});

// Función para editar_almacen
function sendData_update_categoria(){
  $('.alerta_editar_categoria').html(' <div class="notificacion_negativa">'+
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new FormData($('#update_categoria')[0]);
  $.ajax({
      data: parametros,
      url: 'medico/categorias_recursos_humanos.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){
      },
      success: function(response){
          console.log(response);
          if (response =='error') {
              $('.notificacion_agregar_categoria_wsp').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
          } else {
              var info = JSON.parse(response);
              if (info.noticia == 'insert_correct') {
                              $('.alerta_editar_categoria').html('<div class="alert alert-success background-success">'+
                                  '<strong>Cargo!</strong> Editado Correctamente'+
                              '</div>');
                              tabla_sucursales.ajax.reload(); // Recargar los datos en la tabla
                          }
            if (info.noticia == 'error_insertar') {
                $('.alerta_editar_categoria').html('<div class="alert alert-danger background-danger">'+
                    '<strong>Error!</strong>Error en el servidor'+
                '</div>');
            }
          }
      }
  });
}

// ediat_alacen
$('#update_categoria').on('submit', function(e) {
  e.preventDefault(); // Prevenir el envío del formulario por defecto
  sendData_update_categoria();
});



// Evento submit del formulario
$('#add_categoria_wsp').on('submit', function(e) {
  e.preventDefault(); // Prevenir el envío del formulario por defecto
  sendData_categoria_wsp();
});
});




        $(function() {
          $('#boton_agregar_sucursal').on('click', function() {
            $('#modal_agregar_sucursal').modal();
            $("#nombre_categoria").val('');
            $("#salario").val('');
            $("#descripcion").val('');
            $(".notificacion_agregar_categoria_wsp").html('');

          });
        });
