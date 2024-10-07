
$(document).ready(function(){
  //modal para agregar el producto
  $('.eliminar_cliente').click(function(e){
    e.preventDefault();

    var cliente = $(this).attr('cliente');
    var action = 'eliminar_cliente_elejido';
    $('.prut'+cliente+'').html(' <div class="notificacion_negativa">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'jquery_empresa/clientes.php',
      type:'POST',
      async: true,
      data: {action:action,cliente:cliente},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.respuesta == 'elimado_correctamnete') {
             document.getElementById('fila_cliente'+info.cliente+'').style.display = "none";
           }
           if (info.respuesta == 'error_insertar') {
             $('.prut'+info.cliente+'').html('<div class="alert alert-danger" role="alert">Error en el Servidor</div>');

           }



         }
       },
       error:function(error){
         console.log(error);
         }
       });

  });

});
