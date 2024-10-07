$(document).ready(function(){
  $('.eliminar_fila_venta_masiva').click(function(e){
    e.preventDefault();
    var venta = $(this).attr('venta');
    var action = 'eliminar_venta_masiva';
    $('#fila_'+venta+'').html(' <div class="notificacion_negativa">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url: 'jquery_empresa/agregar_ventas_masivas2.php',
      type:'POST',
      async: true,
      data: {action:action,venta:venta},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.noticia == 'elimado_correctamnete') {
            document.getElementById('fila_'+info.venta+'').style.display = "none";

           }
           if (info.noticia == 'error_servidor') {
           $('.notificacion_habilitar_plataforma').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

           }
           if (info.noticia == 'no_factura') {
           $('.notificacion_habilitar_plataforma').html('<div class="alert alert-danger" role="alert">Estas intentando subir un documento no valido '+info.mensaje+'!</div>');

           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });


  });

});
