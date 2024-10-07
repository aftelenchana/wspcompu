var logoUrl; // Variable global para almacenar la URL del logo

function drawImage() {
    var canvas = document.getElementById('logoCanvas');
    var ctx = canvas.getContext('2d');
    var hatSize = document.getElementById('hatSize').value;
    var hatPositionX = document.getElementById('hatPositionX').value;
    var hatPositionY = document.getElementById('hatPositionY').value;

    // Limpia el canvas antes de redibujar
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Carga y dibuja el logo
    var logoImg = new Image();
    logoImg.onload = function() {
        var scaleFactor = Math.min(canvas.width / logoImg.width, canvas.height / logoImg.height);
        var scaledWidth = logoImg.width * scaleFactor;
        var scaledHeight = logoImg.height * scaleFactor;
        var extraSpaceForHat = scaledHeight * 0.1;

        ctx.drawImage(logoImg, (canvas.width - scaledWidth) / 2, (canvas.height - scaledHeight) / 2 + extraSpaceForHat, scaledWidth, scaledHeight);

        // Carga y dibuja el gorrito
        var hatImg = new Image();
        hatImg.onload = function() {
            var hatWidth = scaledWidth * hatSize;
            var hatHeight = hatImg.height * (hatWidth / hatImg.width);
            var hatX = (canvas.width - hatWidth) / hatPositionX;
            var hatY = (canvas.height - scaledHeight) / 2 - hatHeight / 2 + extraSpaceForHat + (hatPositionY * 20); // Ajusta el factor multiplicador según sea necesario

            ctx.drawImage(hatImg, hatX, hatY, hatWidth, hatHeight);
        };
        hatImg.src = '/img/gorro.png';
    };
    logoImg.src = logoUrl; // Usa la URL del logo almacenada
}

$(document).ready(function(){
    $.ajax({
        url: 'SEO/verificar_existencia.php',
        type: 'POST',
        async: true,
        data: {
            action: 'info_plan'
        },
        success: function(response){
            console.log(response);
            var info = JSON.parse(response);
            if (info.noticia == 'no_existe_registro') {
                logoUrl = info.imagn_usuarios; // Almacena la URL del logo
                drawImage(); // Dibuja la imagen inicial
                  $('#modal_seo_imagen_temporal').modal();
            }
        },
        error: function(error){
            console.log(error);
        }
    });

    // Eventos para actualizar la imagen cuando se ajustan los controles
    document.getElementById('hatSize').addEventListener('input', drawImage);
    document.getElementById('hatPositionX').addEventListener('input', drawImage);
    document.getElementById('hatPositionY').addEventListener('input', drawImage);
});

document.getElementById('saveImage').addEventListener('click', function() {
    var canvas = document.getElementById('logoCanvas');
    canvas.toBlob(function(blob) {
        var formData = new FormData();
        formData.append('file', blob, 'logo-con-gorro.png');

        fetch('SEO/imagen_permanente.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Procesa la respuesta como JSON
        .then(info => {
            console.log(info); // Respuesta del servidor en formato JSON

            // Utiliza la propiedad 'noticia' para verificar el estado
            switch(info.noticia) {
                case 'insertado_correctamente_guardado':
                $('#modal_seo_imagen_temporal').modal('hide');
                    break;
                case 'guardado_no_insertado':
                case 'error_guardar':
                case 'no_se_resivio_archivo':
                    $('.notificacion_guardar_imagen_preseleccionada').html('<div class="alert alert-danger background-danger">'+
                    '<strong>Error en el servidor!</strong> Comunícate con soporte.'+
                    '</div>');
                    break;
                default:
                    console.log('Respuesta no reconocida:', info.noticia);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
    }, 'image/png');
});






document.getElementById('no_guardar').addEventListener('click', function() {

  var action = 'no_guardar_imagen';
  $.ajax({
    url:'SEO/no_guardar.php',
    type:'POST',
    async: true,
    data: {action:action},
     success: function(response){
       console.log(response);
       if (response != 'error') {
         var info = JSON.parse(response);
         if (info.noticia == 'insertado_correctamente_guardado') {
             $('#modal_seo_imagen_temporal').modal('hide');
         }
         if (info.noticia == 'guardado_no_insertado') {
           $('.notificacion_guardar_imagen_preseleccionada').html('<div class="alert alert-danger background-danger">'+
           '<strong>Error en el servidor!</strong> Comunícate con soporte.'+
           '</div>');
         }




       }
     },
     error:function(error){
       console.log(error);
       }
     });

});
