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
                var canvas = document.getElementById('logoCanvas');
                var ctx = canvas.getContext('2d');

                // Carga el logo
                var logoImg = new Image();
                logoImg.onload = function() {
                    // Ajusta estos valores para mantener la proporción del logo
                    var scaleFactor = Math.min(canvas.width / logoImg.width, canvas.height / logoImg.height);
                    var scaledWidth = logoImg.width * scaleFactor;
                    var scaledHeight = logoImg.height * scaleFactor;

                    // Calcula el espacio adicional en la parte superior para el gorro
                    var extraSpaceForHat = scaledHeight * 0.1; // Ajusta este valor según sea necesario

                    // Dibuja el logo en el canvas, desplazado hacia abajo para hacer espacio para el gorro
                    ctx.drawImage(logoImg, (canvas.width - scaledWidth) / 2, (canvas.height - scaledHeight) / 2 + extraSpaceForHat, scaledWidth, scaledHeight);

                    // Carga y dibuja el gorrito
                    var hatImg = new Image();
                    hatImg.onload = function() {
                        // Escala y posiciona el gorrito dinámicamente
                        var hatWidth = scaledWidth * 0.4; // Ajusta este valor para cambiar el tamaño del gorro
                        var hatHeight = hatImg.height * (hatWidth / hatImg.width);
                        var hatX = (canvas.width - hatWidth) / 1.3; // Centra el gorro horizontalmente
                        var hatY = (canvas.height - scaledHeight) / 2 - hatHeight / 2 + extraSpaceForHat; // Posiciona el gorro encima del logo

                        // Dibujar el gorro
                        ctx.drawImage(hatImg, hatX, hatY, hatWidth, hatHeight);
                    };
                    hatImg.src = '/img/gorro.png'; // URL del gorrito de Navidad
                };
              //  logoImg.src = info.imagn_usuarios; // URL del logo
                logoImg.src = 'https://facturacion.guibis.com/img/guibis.png'; // URL del logo

                $('#modal_seo_imagen_temporal').modal();
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});
