$("#foto").on("change",function(){
  var uploadFoto = document.getElementById("foto").value;
    var foto       = document.getElementById("foto").files;
    var nav = window.URL || window.webkitURL;
    var contactAlert = document.getElementById('form_alert');

        if(uploadFoto !='')
        {
            var type = foto[0].type;
            var name = foto[0].name;
            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
            {
                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                $("#img").remove();
                $(".delPhoto").addClass('notBlock');
                $('#foto').val('');
                return false;
            }else{
                    contactAlert.innerHTML='';
                    $("#img").remove();
                    $(".delPhoto").removeClass('notBlock');
                    var objeto_url = nav.createObjectURL(this.files[0]);
                    $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                    $(".upimg label").remove();

                }
          }else{
            alert("No selecciono foto");
            $("#img").remove();
          }
});

$('.delPhoto').click(function(){
  $('#foto').val('');
  $(".delPhoto").addClass('notBlock');
  $("#img").remove();

});
























//Agregar nuevo producto
$(document).ready(function(){
  //modal para agregar el producto
  $('.enviar_boucher').click(function(e){
    e.preventDefault();
    var usuario = $(this).attr('usuario');
    var action = 'infoUsuario';
    $.ajax({
      url:'jquery/general.php',
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

    $('.modal_enviar_boucher').fadeIn();


  });

});
function sendDataedit_enviar_boucher(){
  var parametros = new  FormData($('#add_form_enviar_boucher')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery/compra_final.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      if (response =='error') {
        $('.alerteditt_enviar_boucher').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>');
      }else {
      var info = JSON.parse(response);

      if (info.respuest == "positiva") {

          $('.alerteditt_enviar_boucher').html('<p class="alerta_positiva">Comprobante Ingresado Correctamente</p>');
      }
      if (info.noticia == 'codigo_existente') {
        console.log('codigo_existe');
        $('.alerteditt_enviar_boucher').html('<p class="alerta_negativa">Codigo Unico Existente</p>');

      }


      }

    }

  });

}
function closeModaleditt_enviar_boucher(){

  $('.modal_enviar_boucher').fadeOut();
}
