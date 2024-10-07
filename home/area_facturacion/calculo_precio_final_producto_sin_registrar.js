function calculo_precio_final_input() {
  var elejir_tarifa_iva = $("#tipo_ambiente_2").val();
  var valor_unidad = parseFloat($("#valor_unidad_2").val());
  var cantidad_producto_2 = parseFloat($("#cantidad_producto_2").val());
  console.log(elejir_tarifa_iva);
  console.log(valor_unidad);
  console.log(cantidad_producto_2);

  if (elejir_tarifa_iva == '2') {
    var precio_final_con_tarifa = (((valor_unidad * 0.12) + valor_unidad) * cantidad_producto_2).toFixed(2);
    console.log(precio_final_con_tarifa);
    $("#precio_final_final").val(precio_final_con_tarifa);
  } else {
    var precio_final_sin_tarifa = (valor_unidad * cantidad_producto_2).toFixed(2);
    $("#precio_final_final").val(precio_final_sin_tarifa);
  }
}



function calculo_precio_sin_impuestos() {
  var precio_final = parseFloat($("#resultado_calculo").val());
  var tarifa_iva = $("#elejir_tarifa_iva").val();

  // Asumiendo que la tarifa de IVA es del 12% como en tu función original
  var iva = 0.12;
  var precio_sin_impuestos;

  if (tarifa_iva == '2') { // Si el precio final incluye IVA
    precio_sin_impuestos = (precio_final / (1 + iva)).toFixed(2);
    $("#precio_sin_impuestos").val(precio_sin_impuestos);
  } else { // Si el precio final no incluye IVA
    $("#precio_sin_impuestos").val(precio_final.toFixed(2));
  }

  // Actualizar la selección de tarifa de IVA basada en el precio final
  // Esto es más complicado porque necesitas una lógica para determinar la tarifa de IVA basada en el precio final
  // Por ejemplo, si el precio final es igual al precio sin impuestos, entonces es 'SIN IVA'
  // Necesitarás ajustar esta lógica basándote en tus reglas de negocio específicas
  if (precio_final === precio_sin_impuestos) {
    $("#elejir_tarifa_iva").val('0'); // SIN IVA
  } else {
    // Aquí necesitas más condiciones para determinar cuándo es 'Exento de IVA' o 'No Objeto de Impuesto'
    // Por ahora, solo pondré 'CON IVA' como ejemplo
    $("#elejir_tarifa_iva").val('2'); // CON IVA
  }
}
