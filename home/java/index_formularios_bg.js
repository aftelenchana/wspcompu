
$(document).ready(function(){
  $("#tipo_documento_digital").change(function(){
    var tipo_documento_digital = $("#tipo_documento_digital").val();
      console.log(tipo_documento_digital);
      if (tipo_documento_digital =='Proforma') {
        $("#fecha_maxima_proforma").html('<div class="form-group">'+
        '<label>Elije la Fecha de vencimiento</label>'+
        '<input type="date" name="fecha_vencimiento_proforma" required class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Agregue la fecha">'+
        '</div>');
      }else {
        $("#fecha_maxima_proforma").html('');
      }
  });

});
















function sendData_agregar_usuaio_unico_bg(){
  var parametros = new  FormData($('#agregar_usuario_unico_bg')[0]);
  $.ajax({
    data: parametros,
    url:"busquea.php",
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noti_ad_ususario_bg').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      var info = JSON.parse(response);
          $("#nombres_receptor").val(info.nombres);
          $("#identificacion").val(info.tipo_identificacion);
          $("#numero_identidad_receptor").val(info.identificacion);
          $("#email_reeptor").val(info.mail);
          $("#direccion_reeptor").val(info.direccion);
          $("#celular_receptor").val(info.celular);
          $("#id_usuario_receptor").val(info.id);


      }

    }

  });

}



function sendData_unico_producto_bg(){
  var parametros = new  FormData($('#formu_usuario_barra')[0]);
  $.ajax({
    data: parametros,
    url:"busquea.php",
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){


      if (response =='error') {
        $('.noti_ad_ususario_bg').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      document.getElementById("formUsuarios").style.display = "block";
      $("#cantidad").val('');
      $("#detalles_extra").val('');
      $("#nombre_producto").val(info.nombre);
      $("#valor_unidad").val(info.precio);
      $("#id_producto").val(info.idproducto);
      $("#descripcion_producto").val(info.descripcion);
      $("#foto_dl").val(info.foto);
      $("#cantidad_producto").val('');
      $("#detalle_extra_s").val('');
      $("#imagen_producto_hyy").html('<img src="img/uploads/'+info.foto+'" alt="" width="80px;">');
      $("#valor_unidad_final_con_impuestps").val(info.valor_unidad_final_con_impuestps);
      $("#tipo_ambiente").val(info.tipo_ambiente);
      $("#codigos_impuestos").val(info.codigos_impuestos);
      $('#alerta_conatidad_existente').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
            '<strong>Hola !</strong> existen <span id="">'+info.cantidad+'</span> Unidades de <span>'+info.nombre+'</span> en tu Inventario'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '  <span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>');


      }

    }

  });

}


function sensor_cantidad_descuento() {
var cantidad_producto =  document.getElementById("cantidad_producto").value;
var id_producto       =  document.getElementById("id_producto").value;
var porcentaje_descuento =  document.getElementById("porcentaje_descuento").value;
var action = 'verificar_descuento';
console.log(porcentaje_descuento);
$.ajax({
  url: 'jquery_comprar/resumen_pago.php',
  type:'POST',
  async: true,
  data: {action:action,cantidad_producto:cantidad_producto,id_producto:id_producto,porcentaje_descuento:porcentaje_descuento},
  success: function(response){
    console.log(response);
   var info = JSON.parse(response);
   $('#cantidad_descuento').val(info.descuento)

  },

   });
}

function sensor_cantidad_descuento2() {
var cantidad_producto =  document.getElementById("cantidad_producto_2").value;
var valor_unidad_2       =  document.getElementById("valor_unidad_2").value;
var porcentaje_descuento =  document.getElementById("porcentaje_descuento2").value;
var action = 'verificar_descuento_sin_id';
console.log(porcentaje_descuento);
$.ajax({
  url: 'jquery_comprar/resumen_pago.php',
  type:'POST',
  async: true,
  data: {action:action,cantidad_producto:cantidad_producto,valor_unidad_2:valor_unidad_2,porcentaje_descuento:porcentaje_descuento},
  success: function(response){
    console.log(response);
   var info = JSON.parse(response);
   $('#cantidad_descuento2').val(info.descuento)

  },

   });
}
