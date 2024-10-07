$(document).ready(function() {
var user_id, opcion;
opcion = 4;

tablaUsuarios = $('#tablaUsuarios').DataTable({
    "ajax":{
        "url": "jquery_empresa/tomar_pedido.php",
        "method": 'POST', //usamos el metodo POST
        "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
        "dataSrc":""

    },
    "columns":[
      {"data": "id"},
      /*{
         "data": function(row, type, val, meta) {
           return '<img width="30px" src="img/uploads/' + row.imagen + '">'; // Concatenar "ID: " con el valor de la columna "id"
         }
       },*/
        {"data": "id_producto"},
        {"data": "nombre_producto"},
        {
           "data": function(row, type, val, meta) {
             return "$" + row.valor_unidad; // Concatenar "ID: " con el valor de la columna "id"
           }
         },

        {"data": "cantidad_producto"},
        {"data": "descripcion_producto"},
        {"data": "detalle_extra"},

        {
           "data": function(row, type, val, meta) {
             return "$" + row.descuento; // Concatenar "ID: " con el valor de la columna "id"
           }
         },
        {
           "data": function(row, type, val, meta) {
             return "$" + row.iva_producto; // Concatenar "ID: " con el valor de la columna "id"
           }
         },

        {
           "data": function(row, type, val, meta) {
             return "$" + row.subtotal_frontend; // Concatenar "ID: " con el valor de la columna "id"
           }
         },
        {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
    ],
    "responsive": true,
    "paging":   false,
    "searching": false,
    "info": false,
    "language": {
      "emptyTable":           "No hay datos disponibles en la tabla.",
      "info":                 "Del _START_ al _END_ de _TOTAL_ ",
      "infoEmpty":            "Mostrando 0 registros de un total de 0.",
      "infoFiltered":         "(filtrados de un total de _MAX_ registros)",
      "infoPostFix":          "(actualizados)",
      "lengthMenu":           "Mostrar _MENU_ registros",
      "loadingRecords":       "Cargando...",
      "processing":           "Procesando...",
      "search":               "Buscar:",
      "searchPlaceholder":    "Dato para buscar",
      "zeroRecords":          "No se han encontrado coincidencias.",
      "paginate": {
      "first":                "Primera",
      "last":                 "Última",
      "next":                 ">>",
      "previous":             "<<",
      "colvis":               "Columnas"
      }
    }

});

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#formUsuarios').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    nombre_producto   = $.trim($('#nombre_producto').val());
    descripcion_producto = $.trim($('#descripcion_producto').val());
    valor_unidad  = $.trim($('#valor_unidad').val());
    cantidad_producto  = $.trim($('#cantidad_producto').val());
    tipo_ambiente  = $.trim($('#tipo_ambiente').val());
    codigos_impuestos  = $.trim($('#codigos_impuestos').val());
    cantidad_descuento  = $.trim($('#cantidad_descuento').val());
    foto  = $.trim($('#foto_dl').val());
    detalle_extra  = $.trim($('#detalle_extra_s').val());
    idproducto  = $.trim($('#id_producto').val());
    var opcion = 1;
    var id = 1;
        $.ajax({
          url: "jquery_empresa/tomar_pedido.php",
          type: "POST",
          datatype:"json",
          data:  {id:id, nombre_producto:nombre_producto, descripcion_producto:descripcion_producto, valor_unidad:valor_unidad,opcion:opcion,cantidad_producto:cantidad_producto,tipo_ambiente:tipo_ambiente,codigos_impuestos:codigos_impuestos,detalle_extra:detalle_extra,idproducto:idproducto,cantidad_descuento:cantidad_descuento,foto:foto},
          success: function(data) {
            console.log(data);
            tablaUsuarios.ajax.reload(null, false);
            var info = JSON.parse(data);
            const secuencial = info[0].secuencial;
            $('#pedido_generado').val(secuencial);

            var cliente = 1;;
            var action = 'actualizar_resumen';
            $.ajax({
             url: "jquery_empresa/tomar_pedido2.php",
              type:'POST',
              async: true,
              data: {action:action,cliente:cliente},
              success: function(response){
                console.log(response);
                $('#resumen_pago_tabla').html(response)

              },

               });



           }
        });
        $("#cantidad_producto").val('');
        $("#detalle_extra_s").val('');
        document.getElementById("formUsuarios").style.display = "none";

});




$('#enviar_pedido_restaurant').submit(function(e){
  $('.notificacion_agregar_pedido').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    var opcion = 10;
    pedido_generado  = $.trim($('#pedido_generado').val());
    codigo_mesa  = $.trim($('#codigo_mesa').val());
        $.ajax({
          url: "jquery_empresa/tomar_pedido.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion,pedido_generado:pedido_generado,codigo_mesa:codigo_mesa},
          success: function(data){
            console.log(data);
            tablaUsuarios.ajax.reload(null, false);
            $('.notificacion_agregar_pedido').html('<div class="alert alert-success" role="alert">Pedido Enviado Correctamente!</div>');
           }
        });

});









$('#formproductos2').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    nombre_producto   = $.trim($('#nombre_producto_2').val());
    descripcion_producto = $.trim($('#descripcion_producto_2').val());
    valor_unidad  = $.trim($('#valor_unidad_2').val());
    cantidad_producto  = $.trim($('#cantidad_producto_2').val());
    tipo_ambiente  = $.trim($('#tipo_ambiente_2').val());
    codigos_impuestos  = $.trim($('#codigos_impuestos_2').val());
    detalle_extra  = $.trim($('#detalle_extra_s_2').val());
    idproducto  = $.trim($('#id_producto_2').val());
    cantidad_descuento  = $.trim($('#cantidad_descuento2').val());
    var opcion = 1;
    var id = 1;
        $.ajax({
          url: "jquery_empresa/tomar_pedido.php",
          type: "POST",
          datatype:"json",
          data:  {id:id, nombre_producto:nombre_producto, descripcion_producto:descripcion_producto, valor_unidad:valor_unidad,opcion:opcion,cantidad_producto:cantidad_producto,tipo_ambiente:tipo_ambiente,codigos_impuestos:codigos_impuestos,detalle_extra:detalle_extra,idproducto:idproducto,cantidad_descuento:cantidad_descuento},
          success: function(data){
            tablaUsuarios.ajax.reload(null, false);

            var cliente = 1;;
            var action = 'actualizar_resumen';
            $.ajax({
               url: "jquery_empresa/tomar_pedido2.php",
              type:'POST',
              async: true,
              data: {action:action,cliente:cliente},
              success: function(response){
                console.log(response);
                $('#resumen_pago_tabla').html(response)

              },

               });
           }
        });
        $("#cantidad_producto").val('');
        $("#detalle_extra_s").val('');
        document.getElementById("formUsuarios").style.display = "none";

});


var URL_SERVER = '../../code_garantia/agregar_producto.php';

function guardar_codigo_escaneado(result_qr){

  var data = {
    'codigo': result_qr
  };
  $.ajax({
      url: URL_SERVER,
      data: data,
      type: "POST",
      datatype:"json",
      success: function(data){
        console.log(data);
              tablaUsuarios.ajax.reload(null, false);

    }
  });
}
var initial_code_result = true;
var video = document.createElement("video");
var canvasElement = document.getElementById("canvas");
var canvas = canvasElement.getContext("2d");
var loadingMessage = document.getElementById("preMensaje");
var outputContainer = document.getElementById("datosSalida");
var outputMessage = document.getElementById("mensajeSalida");
var outputData = document.getElementById("qrDetectado");
var sonido = document.querySelector('#sonido_qr');
function drawLine(begin, end, color) {
  canvas.beginPath();
  canvas.moveTo(begin.x, begin.y);
  canvas.lineTo(end.x, end.y);
  canvas.lineWidth = 4;
  canvas.strokeStyle = color;
  canvas.stroke();
}
navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
  video.srcObject = stream;
  video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
  video.play();
  requestAnimationFrame(tick);
});
function tick() {
  loadingMessage.innerText = "Cargando Video...";
  if (video.readyState === video.HAVE_ENOUGH_DATA) {
    loadingMessage.hidden = true;
    canvasElement.hidden = false;
    outputContainer.hidden = false;
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
    var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
    var code = jsQR(imageData.data, imageData.width, imageData.height, {
      inversionAttempts: "dontInvert",
    });
    if (code && initial_code_result) {
      drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
      drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
      drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
      drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
      if(code.data!=''){
        outputMessage.hidden = true;
        outputData.parentElement.hidden = false;
        outputData.innerText = code.data;
        sonido.setAttribute("autoplay", true);
        sonido.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        sonido.play();
        sonido.play();
        guardar_codigo_escaneado(code.data);
        initial_code_result = false;
        setTimeout(function(){
          initial_code_result = true;
        },6000);
      }else{
      }
    } else {
      if(initial_code_result){
        outputMessage.hidden = false;
        outputData.parentElement.hidden = true;
      }
    }
  }
  requestAnimationFrame(tick);
}







//para limpiar los campos antes de dar de Alta una Persona
$("#btnNuevo").click(function(){
    opcion = 1; //alta
    id=null;
    $("#formUsuarios").trigger("reset");
    $(".modal-header").css( "background-color", "#17a2b8");
    $(".modal-header").css( "color", "white" );
    $(".modal-title").text("Alta de Usuario");
    $('#modalCRUD').modal('show');
});

//Editar
$(document).on("click", ".btnEditar", function(){
    opcion = 2;//editar
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
    nombre_producto = fila.find('td:eq(1)').text();
    $("#username").val(username);
    $("#first_name").val(first_name);
    $("#last_name").val(last_name);
    $("#gender").val(gender);
    $("#password").val(password);
    $("#status").val(status);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white" );
    $(".modal-title").text("Editar Usuario");
    $('#modalCRUD').modal('show');
});


 $(document).on("click", ".limipiar_consola_h", function(){
      var opcion = 8;
      $.ajax({
        url: "jquery_empresa/tomar_pedido.php",
        type: "POST",
        datatype:"json",
        data:  {opcion:opcion},
        success: function(data) {
          console.log(data);
          tablaUsuarios.ajax.reload(null, false);
          var cliente = 1;;
          var action = 'actualizar_resumen';
          $.ajax({
             url: "jquery_empresa/tomar_pedido2.php",
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
            success: function(response){
              $('#resumen_pago_tabla').html(response)

            },

             });
         }
      });




  });

//Borrar
$(document).on("click", ".btnBorrar", function(){
    fila = $(this);
    id_fila = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;
    console.log(id_fila);
    opcion = 3; //eliminar
    var respuesta = confirm("¿Está seguro de borrar el registro "+id_fila+"?");
    if (respuesta) {
        $.ajax({
          url: "jquery_empresa/tomar_pedido.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion, id_fila:id_fila},
          success: function(response) {
              tablaUsuarios.row(fila.parents('tr')).remove().draw();
              var cliente = 1;;
              var action = 'actualizar_resumen';
              $.ajax({
                 url: "jquery_empresa/tomar_pedido2.php",
                type:'POST',
                async: true,
                data: {action:action,cliente:cliente},
                success: function(response){
                  console.log(response);
                  $('#resumen_pago_tabla').html(response)

                },

                 });
           }
        });
    }
 });

});
