document.addEventListener("DOMContentLoaded", function(){
    // Para abrir el modal de aumentar
    var botonAumentar = document.querySelectorAll('.boton_aumentar');
    var modalAumentar = new bootstrap.Modal(document.getElementById('modal_aumentar'));

    botonAumentar.forEach(function(button) {
        button.addEventListener('click', function() {
            modalAumentar.show();
        });
    });

    // Para abrir el modal de disminuir
    var botonDisminuir = document.querySelectorAll('.boton_disminuir');
    var modalDisminuir = new bootstrap.Modal(document.getElementById('modal_disminuir'));

    botonDisminuir.forEach(function(button) {
        button.addEventListener('click', function() {
            modalDisminuir.show();
        });
    });
});


$(document).ready(function(){
  $("#tipo_aumento").change(function(){
    var tipo_aumento = $("#tipo_aumento").val();
      console.log(tipo_aumento);
      if (tipo_aumento =='Proforma') {
        $("#fecha_maxima_proforma").html('<div class="form-group">'+
        '<label>Elije la Fecha de vencimiento</label>'+
        '<input type="date" name="fecha_vencimiento_proforma" required class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Agregue la fecha">'+
        '</div>');
      }



  });

});



function sendData_disminuir(){
  $('.noticia_disminuir_produtto').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#disminuir_producto')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/inventario.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noticia_disminuir_produtto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_disminuir_produtto').html('<div class="alert alert-success" role="alert">Producto disminuido en el Inventario Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_disminuir_produtto').html('<div class="alert alert-danger" role="alert">Error en el Servidor');
      }
      if (info.noticia == 'numero_invalido') {
      $('.noticia_disminuir_produtto').html('<div class="alert alert-danger" role="alert">Número Invalido!</div>');

      }


      }

    }

  });

}



function sendData_aumentar(){
  $('.noticia_aumentar_cantidad').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#aumentar_producto')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_producto/inventario.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noticia_aumentar_cantidad').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_aumentar_cantidad').html('<div class="alert alert-success" role="alert">Producto aumentado en el Inventario Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_aumentar_cantidad').html('<div class="alert alert-danger" role="alert">Error en el Servidor');
      }
      if (info.noticia == 'numero_invalido') {
      $('.noticia_aumentar_cantidad').html('<div class="alert alert-danger" role="alert">Número Invalido!</div>');

      }

      }

    }

  });

}
