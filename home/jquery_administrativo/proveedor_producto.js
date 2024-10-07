function sendDataedit_nuevo_proveedor_desde_productos(){
  $('.alerta_proveedor_desde_productos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_proveedor_desde_productos')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_administrativo/proveedor.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      // Parsear la respuesta JSON si no se ha hecho automáticamente
      var data = typeof response === "string" ? JSON.parse(response) : response;
      console.log(data);
      if(data.noticia === 'insert_correct') {
        // Vaciar el select actual
        var selectProveedor = document.getElementById('proveedor');
        selectProveedor.innerHTML = ''; // Limpiar el select

        // Añadir los nuevos proveedores al select
        data.proveedores.forEach(function(proveedor) {
            var option = new Option(proveedor.text, proveedor.id);
            selectProveedor.add(option);

            $('.alerta_proveedor_desde_productos').html('<div class="alert alert-success background-success">'+
                '<strong>Proveedor!</strong>Agregado Correctamente válida'+
            '</div>');


        });
      } else {
        // Manejar el error de inserción
        $('.alerta_proveedor_desde_productos').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error !</strong>Intenta mas Tarde'+
        '</div>');
      }
    }



  });
}
