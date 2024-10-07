
//Vista para comprar
$(document).ready(function(){
  //modal para agregar el producto
  $('.vista_comprar').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'infoproducto';
    $.ajax({
      url:'/home/java/producto.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         console.log('dd');
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.identificador_trabajo == 'producto') {
             $('.bodyModal_ver_comprar').html('  <form class="form_add_login" action="" method="post" name="add_form_login" id="" >'+
                 '<div class=producto_general>'+
           '<div class="cotenido_imagen">'+
             '<div class="imaegen_unica">'+
               '<div class="img" id="img_principal">'+
                 '<img src="/home/img/uploads/'+info.foto+'" alt="">'+
               '</div>'+
             '</div>'+
           '</div>'+
           '<div class="contendido_informacion">'+
             '<div class="titulo">'+
               '<h2>'+info.nombre+'</h2>'+
               '<a href="https://guibis.com/home/perfil.php?id='+info.ide+'">Visita la tienda completa <span class="name_tienda"></span></a>'+
               '<div class="tabla_informcacion">'+
                 '<table>'+
                   '<tr>'+
                     '<td class="bl">ID:</td>'+
                     '<td>'+info.idproducto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Fecha Creacion: </td>'+
                     '<td>'+info.fecha_producto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Nombre: </td>'+
                     '<td>'+info.nombre+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl">Precio:</td>'+
                     '<td>$'+info.precio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Descripcion:</td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>      '+
               '</div>      '+
             '</div>      '+
           '</div>    '+
         '</div>  '+
         '<a class="btn_ok closeModal"  href="/home/producto?idp='+info.idproducto+'">Ver Producto</a>'+
         '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
         '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModalvista_general();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
         '</div>'+
       '</div>'+
     '</form>');
     if (info.nombre_empresa == '') {
         $('.name_tienda').html(info.nombre_usuario);

     }else {
       $('.name_tienda').html(info.nombre_empresa);
     }

             console.log('esto es un producto');

           }


           if (info.identificador_trabajo == 'evento') {
             $('.bodyModal_ver_comprar').html('  <form class="form_add_login" action="" method="post" name="add_form_login" id="" >'+
             '<div class="contador">'+
               '<br>'+
               '<div id="cuenta"></div>'+
             '</div>'+
                 '<div class=producto_general>'+
           '<div class="cotenido_imagen">'+
             '<div class="diversas_imagenes">'+
               '<ul>'+
                 '<li onmouseover="cambio1()" ><div class=><img id="image1" src="img/uploads/'+info.foto+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image1" value="img/uploads/'+info.foto+'">'+
                 '<li onmouseover="cambio4()" ><div class=><img id="image4" src="img/qr/'+info.qr+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image4" value="img/qr/'+info.qr+'">'+
               '</ul>'+
             '</div>'+
             '<div class="imaegen_unica">'+
               '<div class="img" id="img_principal">'+
                 '<img src="img/uploads/'+info.foto+'" alt="">'+
               '</div>'+
             '</div>'+
           '</div>'+
           '<div class="contendido_informacion">'+
             '<div class="titulo">'+
               '<h2>'+info.nombre+'</h2>'+
               '<a href="#">Visita la tienda completa Leben</a>'+
               '<p> <span>Precio</span> <span class="precio_unico">$ '+info.precio+'</span> + <span> US$ 0 de envio y depositos de derechos de transporte(Compra esta entrada y realiza una simulacion en tu historial)</span> </p>'+
               '<div class="tabla_informcacion">'+
                 '<table>'+
                   '<tr>'+
                     '<td class="bl">ID:</td>'+
                     '<td>'+info.idproducto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Fecha Evento:</td>'+
                     '<td>'+info.fecha_evento+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Hora Evento</td>'+
                     '<td>'+info.hora_evento+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl">Provincia</td>'+
                     '<td>'+info.provincia+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Ciudad:</td>'+
                     '<td>'+info.ciudad+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Descripcion:</td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>      '+
               '</div>      '+
             '</div>      '+
           '</div>    '+
         '</div>  '+
         '<a class="btn_ok closeModal"  href="producto?idp='+info.idproducto+'">Ver Producto</a>'+
       '<a class="btn_ok closeModal" onclick="closeModalvista_general();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
     '</form>');


     var producto = info.idproducto;
     var action = 'cuenta_evento';

     $.ajax({
       url:'java/cuenta_regresiva.php',
       type:'POST',
       async: true,
       data: {action:action,producto:producto},

        success: function(response){
          if (response != 'error') {
            var info = JSON.parse(response);
            simplyCountdown('#cuenta', {
             year: info.ano, // required
             month: info.mes, // required
             day: info.dia, // required
             hours: info.hora, // Default is 0 [0-23] integer
             minutes: info.minuto, // Default is 0 [0-59] integer
             seconds: 0, // Default is 0 [0-59] integer
             words: { //words displayed into the countdown
               days: 'Día',
               hours: 'Hora',
               minutes: 'Minuto',
               seconds: 'Segundo',
               pluralLetter: 's'
             },
             plural: true, //use plurals
             inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
             inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
             // in case of inline set to false
             enableUtc: true, //Use UTC as default
             onEnd: function() {


             }, //Callback on countdown end, put your own function here
             refresh: 1000, // default refresh every 1s
             sectionClass: 'simply-section', //section css class
             amountClass: 'simply-amount', // amount css class
             wordClass: 'simply-word', // word css class
             zeroPad: false,
             countUp: false
            });



          }

        },
        error:function(error){
          console.log(error);
          }

        });
             console.log('esto es un evento');

           }


           if (info.identificador_trabajo == 'servicios') {
             $('.bodyModal_ver_comprar').html('  <form class="form_add_login" action="" method="post" name="add_form_login" id="" >'+
                 '<div class=producto_general>'+
           '<div class="cotenido_imagen">'+
             '<div class="diversas_imagenes">'+
               '<ul>'+
                 '<li onmouseover="cambio1()" ><div class=><img id="image1" src="img/uploads/'+info.foto+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image1" value="img/uploads/'+info.foto+'">'+
                 '<li onmouseover="cambio4()" ><div class=><img id="image4" src="img/qr/'+info.qr+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image4" value="img/qr/'+info.qr+'">'+
               '</ul>'+
             '</div>'+
             '<div class="imaegen_unica">'+
               '<div class="img" id="img_principal">'+
                 '<img src="img/uploads/'+info.foto+'" alt="'+info.foto+'">'+
               '</div>'+
             '</div>'+
           '</div>'+
           '<div class="contendido_informacion">'+
             '<div class="titulo">'+
               '<h2>'+info.nombre+'</h2>'+
               '<a href="#">Visita la tienda completa Leben</a>'+
               '<p> <span>Precio</span> <span class="precio_unico">$ '+info.precio+'</span> + <span> US$ 0 de envio y depositos de derechos de transporte por ser un control digital</span> </p>'+
               '<div class="tabla_informcacion">'+
                 '<table>'+
                   '<tr>'+
                     '<td class="bl">ID</td>'+
                     '<td>'+info.idproducto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Nombre:</td>'+
                     '<td>'+info.nombre+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Provincia</td>'+
                     '<td>'+info.provincia+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl">Ciudad:</td>'+
                     '<td>'+info.ciudad+'s</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Tipo Servicio:</td>'+
                     '<td>'+info.tipo_servicio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Descripcion:</td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>      '+
               '</div>      '+
             '</div>      '+
           '</div>    '+
         '</div>  '+
         '<a class="btn_ok closeModal"  href="producto?idp='+info.idproducto+'">Ver Servicio</a>'+
       '<a class="btn_ok closeModal" onclick="closeModalvista_general();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
     '</form>');
             console.log('esto es un servicios');

           }


           if (info.identificador_trabajo == 'sorteos') {
             $('.bodyModal_ver_comprar').html('  <form class="form_add_login" action="" method="post" name="add_form_login" id="" >'+
             '<div class="contador">'+
               '<br>'+
               '<div id="cuenta"></div>'+
             '</div>'+
                 '<div class=producto_general>'+
           '<div class="cotenido_imagen">'+
             '<div class="diversas_imagenes">'+
               '<ul>'+
                 '<li onmouseover="cambio1()" ><div class=><img id="image1" src="img/uploads/'+info.foto+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image1" value="img/uploads/'+info.foto+'">'+
                 '<li onmouseover="cambio4()" ><div class=><img id="image4" src="img/qr/'+info.qr+'" alt=""></div></li>'+
                 '<input type="hidden" name="" id="input_image4" value="img/qr/'+info.qr+'">'+
               '</ul>'+
             '</div>'+
             '<div class="imaegen_unica">'+
               '<div class="img" id="img_principal">'+
                 '<img src="img/uploads/'+info.foto+'" alt="">'+
               '</div>'+
             '</div>'+
           '</div>'+
           '<div class="contendido_informacion">'+
             '<div class="titulo">'+
               '<h2>'+info.nombre+'</h2>'+
               '<a href="#">Visita la tienda completa Leben</a>'+
               '<p> <span>Precio</span> <span class="precio_unico">$ '+info.precio+'</span> + <span> US$ 0 de envio y depositos de derechos de transporte por ser un producto digital </span> </p>'+
               '<div class="tabla_informcacion">'+
                 '<table>'+
                   '<tr>'+
                     '<td class="bl">ID:</td>'+
                     '<td>'+info.idproducto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Fecha Sorteo</td>'+
                     '<td>'+info.fecha_sorteo+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl" >Hora Sorteo</td>'+
                     '<td>'+info.hora_sorteo+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td  class="bl">Ciudad</td>'+
                     '<td>'+info.ciudad+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Provincia:</td>'+
                     '<td>'+info.provincia+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="bl">Descripcion:</td>'+
                     '<td>'+info.descripcion+'</td>'+
                   '</tr>'+
                 '</table>      '+
               '</div>      '+
             '</div>      '+
           '</div>    '+
         '</div>  '+
         '<a class="btn_ok closeModal"  href="producto?idp='+info.idproducto+'">Ver Producto</a>'+
       '<a class="btn_ok closeModal" onclick="closeModalvista_general();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
     '</form>');

          var producto = info.idproducto;
          var action = 'cuenta_sorteo';

          $.ajax({
            url:'java/cuenta_regresiva.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

             success: function(response){
               if (response != 'error') {
                 var info = JSON.parse(response);
                 simplyCountdown('#cuenta', {
                  year: info.ano, // required
                  month: info.mes, // required
                  day: info.dia, // required
                  hours: info.hora, // Default is 0 [0-23] integer
                  minutes: info.minuto, // Default is 0 [0-59] integer
                  seconds: 0, // Default is 0 [0-59] integer
                  words: { //words displayed into the countdown
                    days: 'Día',
                    hours: 'Hora',
                    minutes: 'Minuto',
                    seconds: 'Segundo',
                    pluralLetter: 's'
                  },
                  plural: true, //use plurals
                  inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
                  inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
                  // in case of inline set to false
                  enableUtc: true, //Use UTC as default
                  onEnd: function() {


                  }, //Callback on countdown end, put your own function here
                  refresh: 1000, // default refresh every 1s
                  sectionClass: 'simply-section', //section css class
                  amountClass: 'simply-amount', // amount css class
                  wordClass: 'simply-word', // word css class
                  zeroPad: false,
                  countUp: false
                 });



               }

             },
             error:function(error){
               console.log(error);
               }

             });
             console.log('esto es un sorteos');

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_comprar').fadeIn();

  });



});

function closeModalvista_general(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_editar_producto').html('');
  $('.modal_ver_comprar').fadeOut();
}
