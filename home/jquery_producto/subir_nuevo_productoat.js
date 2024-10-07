

function calculo_precio_final_input() {
  var elejir_tarifa_iva = $("#elejir_tarifa_iva").val();
  var precio_sin_impuestos = parseFloat($("#precio_sin_impuestos").val());

  if (elejir_tarifa_iva == '2') {
    var precio_final_con_tarifa = ((precio_sin_impuestos * 0.12) + precio_sin_impuestos).toFixed(2);;
    $("#resultado_calculo").val(precio_final_con_tarifa);
  } else {
    $("#resultado_calculo").val(precio_sin_impuestos);
  }
}






function sendDataedit_nuevo_producto(){
    $('.alerta_nuevoproducto').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    '</div>');
var parametros = new  FormData($('#add_form_nuevo_producto')[0]);
$.ajax({
data: parametros,
url: 'jquery_producto/nuevo-producto.php',
type: 'POST',
contentType: false,
processData: false,
beforesend: function(){

},
success: function(response){
  console.log(response);

  if (response =='error') {
    $('.alert_general').html('<p class="alerta_negativa">Error al insertar el producto</p>')
  }else {
  var info = JSON.parse(response);
  if (info.noticia == 'add_ok_prod') {
    console.log('SIE NTRA');
    $('.alerta_nuevoproducto').html('<div class="alert alert-success" role="alert">Producto Agregado Correctamente mira <a target="_blank" href="view-product?p='+info.idproduto+'">Aqui</a> o mira todos los productos <a target="_blank" href="productos">Aqui</a>  !</div>');
    //window.location.href = "mis-productos";

  }
  if (info.noticia == 'error') {
    $('.alerta_nuevoproducto').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

  }

  }

}

});

}
