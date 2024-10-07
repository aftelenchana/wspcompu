$("a.enlace_verificacion_secuencia_factura").on("click", function(event) {
  var action = 'busqueda_secuencia';
  $.ajax({
    type:"post",
    url:"area_facturacion/busqueda_secuencia.php",
    data: {action:action},
    success:function(response){
      console.log(response);
      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
      }else {
        var info = JSON.parse(response);
        var secuencial = info.secuencial; // Suponiendo que la respuesta JSON contiene un campo "secuencial"
        window.location.href = 'facturacion_in?factura=' + secuencial;


      }

    }

  })


   });
