function sendData_epicrisis(){
  $('.alerta_epicrisis').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#epicrisis')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/epicrisis.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_epicrisis').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.alerta_epicrisis').html('<div class="alert alert-success background-success">'+
            '<strong>Epicrisis Realizada con Éxito!</strong>  '+info.wsp+' '+
        '</div>');

      }

      if (info.noticia == 'error') {
        $('.alerta_epicrisis').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> Intenta mas tarde, comunicate con el administrador '+
        '</div>');

      }


      }
    }

  });
}
