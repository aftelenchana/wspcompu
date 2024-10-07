

$(document).ready(function(){
    $.ajax({
      url:'java/datos_generados.php',
      type:'POST',
      async: true,

       success: function(response){
         console.log(response);
         if (response != 'error') {

         }

       },
       error:function(error){
         console.log(error);
         }

       });

});
