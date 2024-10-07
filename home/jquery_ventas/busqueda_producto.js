
function generar_venta(){
  var producto = parseFloat(document.getElementById('id_producto').value);
  var comprador = parseFloat(document.getElementById('id_comprador').value);
  $.ajax({
    url:'jquery_ventas/busqueda_producto.php',
    type:'POST',
    async: true,
    data: $('#add_form_busqueda').serialize(),

     success: function(response){
       console.log('Hola mudno');
       $('.bodyModal_ver_comprar').html('  <form class="form_add_login" action="" method="post" name="add_form_login" id="" >'+
       

 '<a class="btn_ok closeModal" onclick="closeModalvista_general();" href="#"> <img id="cerrar" src="/home/img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
'</form>');
   $('.modal_ver_comprar').fadeIn();


     },
     error:function(error){
       console.log(error);
       }

     });
}


function closeModalvista_general(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_editar_producto').html('');
  $('.modal_ver_comprar').fadeOut();
}



function sendData_busqueda(){
  $('.notificacion_producto').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
    $.ajax({
      url:'jquery_ventas/busqueda_producto.php',
      type:'POST',
      async: true,
      data: $('#add_form_busqueda').serialize(),

       success: function(response){
      document.getElementById("resultado").innerHTML = response;
       },
       error:function(error){
         console.log(error);
         }

       });

}
