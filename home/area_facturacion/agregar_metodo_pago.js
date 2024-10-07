function sendData_agregar_metodo_pago(){
  $('.noticia_agregar_nota').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_metodo_pago')[0]);
    parametros.append('sucursal_facturacion', document.getElementById('sucursal_facturacion').value);
  $.ajax({
    data: parametros,
    url: 'area_facturacion/agregar_metodo_pago.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      // Obtén una referencia a la tabla

      if (info.noticia == 'sobrepasa_total') {
          $('.notificacion_agregar_metodo_pago').html('<div class="alert alert-danger background-danger"><strong>No tiene que sobrepasar del total cantidad_metodo_pago_base '+info.total_real_factura+', cantidad_metodo_pago_base '+info.cantidad_metodo_pago_base+'  !</strong> </div>');
      }else {



      // Mapeo de códigos de formas de pago a nombres en JavaScript
      var codigoFormasPagoNombres = {
        "01": "SIN UTILIZACION DEL SISTEMA FINANCIERO",
        "15": "COMPESACION DE DE DEUDAS",
        "16": "TARJETA DE DEBITO",
        "17": "DINERO ELECTRONICO",
        "18": "TARJETA PREPAGO",
        "19": "TARJETA DE CREDITO",
        "20": "OTROS CON UTILIZACION DEL SISTEMA FINANCIERO",
        "21": "ENDOSO DE TITULOS"
      };

      // Crear el HTML de la tabla a partir de los datos del JSON
      var tablaHTML = '<table class="table table-bordered">';
      tablaHTML += '<thead>';
      tablaHTML += '<tr>';
      tablaHTML += '<th>Cantidad</th>';
      tablaHTML += '<th>Código</th>';
      tablaHTML += '<th>Nombre</th>';
      tablaHTML += '<th>Eliminar</th>';
      tablaHTML += '</tr>';
      tablaHTML += '</thead>';
      tablaHTML += '<tbody>';

      for (var i = 0; i < info.length; i++) {
        var registro = info[i];
        var cantidadMetodoPago = parseFloat(registro.cantidad_metodo_pago); // Convertir a número

        // Verificar si es un número válido antes de usar toFixed
        if (!isNaN(cantidadMetodoPago)) {
          cantidadMetodoPago = cantidadMetodoPago.toFixed(2); // Formatear a 2 decimales
        } else {
          cantidadMetodoPago = 'N/A'; // O algún otro valor predeterminado en caso de no ser un número válido
        }

        var nombreFormaPago = codigoFormasPagoNombres[registro.formaPago]; // Sin valor predeterminado

        // Agrega una salida de depuración para verificar los valores
        console.log("registro.formaPago:", registro.formaPago);
        console.log("nombreFormaPago:", nombreFormaPago);

        tablaHTML += '<tr id="fila_pago'+registro.id+'">';
        tablaHTML += '<td>$' + cantidadMetodoPago + '</td>';
        tablaHTML += '<td>' + registro.formaPago + '</td>';
        tablaHTML += '<td>' + (nombreFormaPago || "Desconocido") + '</td>'; // Mostrar "Desconocido" si es nulo
        tablaHTML += '<td class="eliminar_forma_pago" pago="'+registro.id+'" ><i class="fas fa-trash-alt"></i></td>';
        tablaHTML += '</tr>';
      }



      tablaHTML += '</tbody>';
      tablaHTML += '</table>';

      // Reemplaza el contenido del elemento con la clase "tabla_resultados_metodo_pago"
      $('.tabla_resultados_metodo_pago').html(tablaHTML);

      }
      }

    }

  });

}




$(document).on("click", ".eliminar_forma_pago", function() {
    var pago = $(this).attr("pago");
    var action = 'eliminar_metodo_pago';
    $.ajax({
      type:"post",
      url:"area_facturacion/agregar_metodo_pago.php",
      data: {action:action,pago:pago},
      success:function(response){
        console.log(response);
        if (response =='error') {
          $('.alert_general').html('<p class="alerta_negativa">Error al Cargar</p>')
        }else {
          var info = JSON.parse(response);
          if (info.respuesta == 'eliminado_correctamente') {
            console.log('fila_pago'+info.pago+'');
                document.getElementById('fila_pago'+info.pago+'').style.display = "none";

          }
          if (info.respuesta == 'error_eliminar_producto') {
             $('#errorModal').modal('show');
          }



        }

      }

    })
});
