$(document).ready(function(){
  //modal para agregar el producto
  $('.add_producto').click(function(e){
    e.preventDefault();
    var usuario = $(this).attr('usuario');
    var action = 'infoUsuario';
    $.ajax({
      url:'scripts/general.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);







         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_add_servicios').fadeIn();


  });

});
