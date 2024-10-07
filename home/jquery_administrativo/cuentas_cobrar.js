function insercion_cuetas() {
  var agregar_plan_cuotas = $("#agregar_plan_cuotas").val();
  if (agregar_plan_cuotas == 'SI') {
    $(".resultado_plan_cuentas").html('<div class="mb-3">'+
        '  <label for="precio_sin_impuestos" class="form-label">Indique el número de cuotas.</label>'+
        '  <input oninput="calculo_precio_final_input()" type="number" step="0.00001" class="form-control" name="numero_cuotas" id="numero_cuotas" placeholder="Ingrese el valor">'+
        '  <small class="form-text text-muted">Ingrese el número de cuotas que se va a insertar para el control</small>'+
      '  </div>');
  } else {
    $(".resultado_plan_cuentas").html('');
  }
}

function sendData_agregar_cuentas_pagar(){
  $('.notificacion_cuentas_cobrar').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_cuentas_pagar')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_administrativo/cuentas_cobrar.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_cuentas_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_cuentas_cobrar').html('<div class="alert alert-success" role="alert">Factura Agregada Correctamente a Cuentas por Cobrar !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_cuentas_cobrar').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      if (info.noticia == 'factura_procesada') {
      $('.notificacion_cuentas_cobrar').html('<div class="alert alert-warning" role="alert">Esta Factura ya se encuentra en cuentas por cobrar!</div>');

      }
      if (info.noticia == 'valor_inicial_exedente') {
      $('.notificacion_cuentas_cobrar').html('<div class="alert alert-warning" role="alert">El monto inicial no tiene que ser mayor al valor total de la factura!</div>');

      }

      }

    }

  });

}
