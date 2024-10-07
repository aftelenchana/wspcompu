

$(document).ready(function(){
  $("#estado_financiero").change(function(){
    var estado_financiero = $("#estado_financiero").val();
    if (estado_financiero == 'CREDITO') {

      console.log(estado_financiero);
      $('.contenedor_vueltos').html('<div class="alert alert-warning" role="alert">Se crea una cuenta por cobrar, genera la factura para que puedas configurar el crédito hacia tu cliente!</div>');
    }
    if (estado_financiero == 'CONTADO') {

      console.log(estado_financiero);
      $('.contenedor_vueltos').html('<h5>Efectivo</h5>'+
                              ' <div class="">'+
                              '   <input oninput="dar_vuelto();" type="text" class="form-control form-control-sm" id="efectivo" name="efectivo" value="" required placeholder="Ingrese El Efectivo">'+
                              ' </div>'+
                              ' <h5>Vuelto</h5>'+
                              '   <div class="">'+
                                '   <input type="text" class="form-control form-control-sm" id="vuelto_venta" readonly name="vuelto" value="" required placeholder="">'+
                                 '</div>');
    }


  });



});
