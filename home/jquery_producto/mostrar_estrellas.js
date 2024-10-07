
$(document).ready(function(){
  var producto = parseFloat(document.getElementById('producto').value);
  var action = 'info_estrellas';
  console.log('tttttttttttttttt');
  console.log(producto);
    $.ajax({
      url:'/home/jquery_producto/mostrar_estrellas.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},

       success: function(response){
    console.log(response);
         if (response != 'error') {
             document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;
      



         }

       },
       error:function(error){
         console.log(error);
         }

       });

});
