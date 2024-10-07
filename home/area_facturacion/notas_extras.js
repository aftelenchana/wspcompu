$(document).ready(function() {
    $(document).on('change', '.seleccionar_nota_extra', function() {
        console.log("Valor del input:", $(this).val());
        // Corrección: Usar $(this) en lugar de input

        var codigo_nota = $(this).attr('codigo_nota');
        var nivel_nota = $(this).attr('nivel_nota');
        var action = 'agregar_nota';
        var nota = $(this).val();

        $.ajax({
            url: 'area_facturacion/notas_extras.php',
            type: 'POST',
            async: true,
            data: {action: action, nota: nota, codigo_nota: codigo_nota, nivel_nota: nivel_nota},
            success: function(response) {
                console.log(response);
                var info = JSON.parse(response);
                if (info.noticia == 'insert_correct') {
                  if (info.contenido_nota != '') {
                        $('#'+info.nivel_nota+''+info.codigo_nota+'').css('background-color', '#FFC300');

                  }else {
                    $('#'+info.nivel_nota+''+info.codigo_nota+'').css('background-color', '');

                  }

                }
            },
        });
    });
});




$(document).on("click", ".clase_dar_click_icono", function() {
     var codigo_nota = $(this).attr('codigo_nota');
     var estado = $(this).attr('estado');
     if (estado == 'cerrado') {
       $('#contendeor_icono'+codigo_nota+'').html('<i class="fas fa-minus-square"></i>');
       $('.clase_dar_click_icono').attr('estado', 'abierto');
     }
     if (estado == 'abierto') {
       $('#contendeor_icono'+codigo_nota+'').html('<i class="far fa-plus-square"></i>');
       $('.clase_dar_click_icono').attr('estado', 'cerrado');
     }



});
