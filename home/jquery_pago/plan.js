$(document).ready(function(){
      var codigo_factura = document.getElementById('codigo_factura').value;
    $.ajax({
        url: 'jquery_pago/plan.php',
        type: 'POST',
        async: true,
        data: {
            action: 'info_plan',
            codigo_factura: codigo_factura
        },
        success: function(response){
          console.log(response);
            var info = JSON.parse(response);
            if (info.noticia == 'fecha_mayor') {
              $('#modal_pago').modal();

              $('.noti_auto_pago').html('<div class="alert alert-warning background-warning">'+
              '<strong>Paquete Caducado !</strong> comunícate con el administrador'+
              '</div>');

              $('.notificacion_resumen_pago_paquete').html(info.resumen);
            }

            if (info.noticia == 'fecha_menor') {
              if (info.cantidad == 'cantidad_incorrecta') {
                $('#modal_pago').modal();
                $('.noti_auto_pago').html('<div class="alert alert-warning background-warning">'+
                '<strong>Paquete en Cantidad Limítado !</strong> comunícate con el administrador'+
                '</div>');
                $('.notificacion_resumen_pago_paquete').html(info.resumen);

              }
            }


        },
        error: function(error){
            console.log(error);
        }
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    var myModal = new bootstrap.Modal(document.getElementById('modal_pago'), {
        backdrop: 'static',
        keyboard: false
    });


});
