

$(document).ready(function(){
  var producto = parseFloat(document.getElementById('producto').value);
  var action = 'infoproducto';
    $.ajax({
      url:'java/producto.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},

       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.title').html(info.nombre);
           if (info.identificador_trabajo == 'producto') {
             $('.producto_general').html('<div class="cotenido_imagen">'+
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
                        '<a href="https://guibis.com/home/perfil.php?id='+info.ide+'">Visita la tienda completa <span class="name_tienda"></span></a>'+
                       '<p> <span>Precio</span> <span class="precio_unico">$'+info.precio+' </p>'+
                       '<div class="resultado_calificaciones" style="width: 80%;text-align: center;font-size: 15px;">'+
                             '<div class="" id="calificacion_resultado">'+

                            '</div>'+

                       '</div>'+
                       '<div class="tabla_informcacion">'+
                         '<table>'+
                         '<tr>'+
                           '<td class="bl">ID Producto:</td>'+
                           '<td>'+info.idproducto+'</td>'+
                         '</tr>'+
                           '<tr>'+
                             '<td class="bl">Nombre Producto:</td>'+
                             '<td>'+info.nombre+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Marca:</td>'+
                             '<td>'+info.marca+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl" >Subcategorias</td>'+
                             '<td>'+info.subcategorias+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl" >Ciudad</td>'+
                             '<td>'+info.ciudad+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl">Fecha Producto:</td>'+
                             '<td>'+info.fecha_producto+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Descripcion:</td>'+
                             '<td>'+info.descripcion+'</td>'+
                           '</tr>'+
                         '</table>'+
                       '</div>'+
                     '</div>'+
                   '</div>'+
                   '<div class="contenido_entrega">'+
                     '<p class="precio_entrega">US $ '+info.precio+'</p>'+
                     '<p class="disponible">Disponible</p>'+
                     '<p class="seg_tr">Transaccion Segura <img id="candado" src="img/carro_compras.png" alt=""> </p>'+
                     '<div class="envio_empaque_vendido">'+
                       '<table>'+
                         '<tr>'+
                           '<td class="bd_we">Envio desde</td>'+
                           '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Vendido Por</td>'+
                           '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Empaque</td>'+
                           '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                         '</tr>'+
                       '</table>'+
                     '</div>'+
                     '<div class="redes_sociales">'+
                     '<div class="redes_general facebook_p">'+
                       '<a target="_blank" href="'+info.facebook+'"><img src="img/reacciones/facebook.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '<div class="redes_general instagram_p">'+
                       '<a target="_blank" href="'+info.instagram+'"><img src="img/reacciones/instagram.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '<div class="redes_general whatsapp_p">'+
                       '<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;https://guibis.com/vista-general-producto.php?idp='+info.idproducto+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '<div class="redes_general tiktok_p">'+
                       '<a target="_blank" href="https://'+info.tiktok+'"><img src="img/reacciones/tiktok.png" alt="" width="30px"> </a>'+
                     '</div>'+
                     '</div>'+

                     '<div style="background: #232F3E;color: #fff;padding: 10px;margin: 5px;" class="add_tienda">'+
                       '<a style="color: #fff;padding: 5px;"  onclick="agregar_tienda_interes();" producto="'+info.idproducto+'" href="#">Seguir a esta tienda</a>'+
                     '</div>'+
                     '<div class="">'+
                       '<h3>Calificar</h3>'+
                     '<div class="rating-css">'+
                       '<div class="star-icon">'+
                         '<form class="" action="index.html" method="post">'+
                           '<input type="radio" name="rating1" id="rating1" value="1" oninput="calificar_1_estrella()">'+
                           '<label for="rating1" class="fa fa-star"></label>'+

                           '<input type="radio" name="rating1" id="rating2" value="2" oninput="calificar_2_estrella()">'+
                           '<label for="rating2" class="fa fa-star"></label>'+

                           '<input type="radio" name="rating1" id="rating3" value="3" oninput="calificar_3_estrella()">'+
                           '<label for="rating3" class="fa fa-star"></label>'+

                           '<input type="radio" name="rating1" id="rating4" value="4" oninput="calificar_4_estrella()">'+
                           '<label for="rating4" class="fa fa-star"></label>'+

                           '<input type="radio" name="rating1" id="rating5" value="5" oninput="calificar_5_estrella()">'+
                           '<input type="hidden" name="id_producto" id="id_producto" value="'+info.idproducto+'">'+
                           '<label for="rating5" class="fa fa-star"></label>'+
                         '</form>'+
                       '</div>'+

                     '</div>'+
                    '</div>'+
                   '</div>');

                   if (info.nombre_empresa == '') {
                       $('.name_tienda').html(info.nombre_usuario);

                   }else {
                     $('.name_tienda').html(info.nombre_empresa);
                   }



                   var idproducto = info.idproducto;
                   var action = 'info_tienda_interes';
                   $.ajax({
                     url:'jquery_producto/informacion.php',
                     type:'POST',
                     async: true,
                     data: {action:action,idproducto:idproducto},
                      success: function(response){
                        if (response != 'error') {
                          var info = JSON.parse(response);
                          if (info.noticia == 'tienda_agregada_como_favorita' ) {
                            $('.add_tienda').html( '<a style="color: #fff;padding: 5px;" onclick="quitar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Dejar de Seguir</a>');

                          }
                          if (info.noticia == 'inactivo_en_tienda_favorita' ) {
                            $('.add_tienda').html( '<a style="color: #fff;padding: 5px;" onclick="agregar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Seguir a esta tienda</a>');

                          }
                          if (info.noticia == 'no_existe_en_tienda_favorita' ) {
                            $('.add_tienda').html( '<a style="color: #fff;padding: 5px;" onclick="agregar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Seguir a esta tienda</a>');

                          }



                        }
                      },
                      error:function(error){
                        console.log(error);
                        }

                      });
                   if (info.nombre_empresa != '') {
                        $('.envio_empaque_vendido').html( '<table>'+
                           '<tr>'+
                             '<td class="bd_we">Envio desde</td>'+
                             '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bd_we">Vendido Por</td>'+
                             '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bd_we">Empaque</td>'+
                             '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                           '</tr>'+
                         '</table>');

                   }
                   if (info.facebook == '') {
                     $('.facebook_p').html('');
                   }
                   if (info.instagram == '') {
                     $('.instagram_p').html('');
                   }
                   if (info.whatsapp == '') {
                     $('.whatsapp_p').html('');
                   }
                   if (info.tiktok == '') {
                     $('.tiktok_p').html('');
                   }


           }
           if (info.identificador_trabajo == 'evento') {
              $('.producto_general').html('<div class="cotenido_imagen">'+
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
                        '<p> <span>Precio</span> <span class="precio_unico">$'+info.precio+'</span>  <span class="precio_envio_total">  </span> </p>'+
                        '<div class="tabla_informcacion">'+
                          '<table>'+
                            '<tr>'+
                              '<td class="bl">Evento:</td>'+
                              '<td>'+info.nombre+'</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td  class="bl" >Fecha Evento</td>'+
                              '<td>'+info.fecha_evento+'</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td  class="bl" >Hora Evento</td>'+
                              '<td>'+info.hora_evento+'</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="bl">Detalle:</td>'+
                              '<td>Compra esta entra digital, ve a tus cuenta y realiza la simulacion de entrada</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="bl">Descripcion:</td>'+
                              '<td>'+info.descripcion+'</td>'+
                            '</tr>'+
                          '</table>'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                    '<div class="contenido_entrega">'+
                      '<p class="precio_entrega">US $ '+info.precio+'</p>'+
                      '<p class="disponible">Disponible</p>'+
                      '<label for="">Cantidad</label>'+
                      '<select class="cantidad" name="cantidad" placeholder="Cantidad">'+
                        '<option value="">1</option>'+
                        '<option value="">2</option>'+
                      '</select>'+
                      '<div class="agregar_carrito boton_acc">'+
                        '<a href="#"> <img src="img/carro_compras.png" alt=""> Agregar Al Carrito</a>'+
                      '</div> <span class="espacio_br"></span>'+
                      '<div class="comprar_ahora boton_acc">'+
                                  '<a href="#"> <img src="img/carro_compras.png" alt=""> Comprar Ahora</a>'+
                      '</div>'+
                      '<p class="seg_tr">Transaccion Segura <img id="candado" src="img/carro_compras.png" alt=""> </p>'+
                      '<div class="envio_empaque_vendido">'+
                        '<table>'+
                          '<tr>'+
                            '<td class="bd_we">Envio desde</td>'+
                            '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                          '</tr>'+
                          '<tr>'+
                            '<td class="bd_we">Vendido Por</td>'+
                            '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                          '</tr>'+
                          '<tr>'+
                            '<td class="bd_we">Empaque</td>'+
                            '<td><a href="perfil.php?id='+info.ide+'">'+info.nombre_usuario+' '+info.apellidos_usuarios+'</a></td>'+
                          '</tr>'+
                        '</table>'+
                      '</div>'+
                      '<div class="redes_sociales">'+
                      '<div class="redes_general facebook_p">'+
                        '<a target="_blank" href="'+info.facebook+'"><img src="img/reacciones/facebook.png" alt="" width="30px"> </a>'+
                      '</div>'+
                      '<div class="redes_general instagram_p">'+
                        '<a target="_blank" href="'+info.instagram+'"><img src="img/reacciones/instagram.png" alt="" width="30px"> </a>'+
                      '</div>'+
                      '<div class="redes_general whatsapp_p">'+
                        '<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;https://guibis.com/vista-general-producto.php?idp='+info.idproducto+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>'+
                      '</div>'+
                      '</div>'+

                      '<div class="add_tienda">'+
                        '<a onclick="agregar_tienda_interes();" producto="'+info.idproducto+'" href="#">Seguir a esta tienda</a>'+
                      '</div>'+
                    '</div>');
                    var idproducto = info.idproducto;
                    var action = 'info_tienda_interes';
                    $.ajax({
                      url:'jquery_producto/informacion.php',
                      type:'POST',
                      async: true,
                      data: {action:action,idproducto:idproducto},
                       success: function(response){

                         if (response != 'error') {
                           var info = JSON.parse(response);
                           if (info.noticia == 'tienda_agregada_como_favorita' ) {
                             $('.add_tienda').html( '<a onclick="quitar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Dejar de seguir</a>');

                           }
                           if (info.noticia == 'inactivo_en_tienda_favorita' ) {
                             $('.add_tienda').html( '<a onclick="agregar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Seguir a esta tienda</a>');

                           }
                           if (info.noticia == 'no_existe_en_tienda_favorita' ) {
                             $('.add_tienda').html( '<a onclick="agregar_tienda_interes();" tienda="'+info.id_tienda+'" href="#">Seguir a esta tienda</a>');

                           }



                         }
                       },
                       error:function(error){
                         console.log(error);
                         }

                       });
                    if (info.nombre_empresa != '') {
                         $('.envio_empaque_vendido').html( '<table>'+
                            '<tr>'+
                              '<td class="bd_we">Envio desde</td>'+
                              '<td><a href="perfil-general.php?ide='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="bd_we">Vendido Por</td>'+
                              '<td><a href="perfil-general.php?ide='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="bd_we">Empaque</td>'+
                              '<td><a href="perfil-general.php?ide='+info.ide+'">'+info.nombre_empresa+'</a></td>'+
                            '</tr>'+
                          '</table>');

                    }
                    if (info.facebook == '') {
                      $('.facebook_p').html('');
                    }
                    if (info.instagram == '') {
                      $('.instagram_p').html('');
                    }
                    if (info.whatsapp == '') {
                      $('.whatsapp_p').html('');
                    }



           }
           if (info.identificador_trabajo == 'servicios') {
             $('.producto_general').html('<div class="cotenido_imagen">'+
                     '<div class="diversas_imagenes">'+
                       '<ul>'+
                         '<li onmouseover="cambio1()" ><div class=><img id="image1" src="home/img/uploads/'+info.foto+'" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image1" value="home/img/uploads/'+info.foto+'">'+
                         '<li onmouseover="cambio2()" ><div class=><img id="image2" src="img/seguro.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image2" value="img/seguro.png">'+
                         '<li onmouseover="cambio3()" ><div class=><img id="image3" src="img/salud.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image3" value="img/salud.png">'+
                         '<li onmouseover="cambio4()" ><div class=><img id="image4" src="img/seguro.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image4" value="img/seguro.png">'+
                       '</ul>'+

                     '</div>'+
                     '<div class="imaegen_unica">'+
                       '<div class="img" id="img_principal">'+
                         '<img src="home/img/uploads/'+info.foto+'" alt="">'+
                       '</div>'+
                     '</div>'+
                   '</div>'+
                   '<div class="contendido_informacion">'+
                     '<div class="titulo">'+
                       '<h2>'+info.nombre+'</h2>'+
                       '<a href="#">Visita la tienda completa Leben</a>'+
                       '<p> <span>Precio</span> <span class="precio_unico">$'+info.precio+'</span>  <span class="precio_envio_total">  </span> </p>'+
                       '<div class="tabla_informcacion">'+
                         '<table>'+
                           '<tr>'+
                             '<td class="bl">Servicios:</td>'+
                             '<td>'+info.nombre+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl" >Fecha Creacion</td>'+
                             '<td>'+info.fecha_producto+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Tipo Servicio:</td>'+
                             '<td>'+info.tipo_servicio+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Descripcion:</td>'+
                             '<td>'+info.descripcion+'</td>'+
                           '</tr>'+
                         '</table>'+
                       '</div>'+
                     '</div>'+
                   '</div>'+
                   '<div class="contenido_entrega">'+
                     '<p class="precio_entrega">US $ '+info.precio+'</p>'+
                     '<p class="precio_envio_total"> </p>'+
                     'LLega:<span class="fecha_entrega"> 9 de Junio de 2021</span>'+
                     '<p class="disponible">Disponible</p>'+
                     '<label for="">Cantidad</label>'+
                     '<select class="cantidad" name="cantidad" placeholder="Cantidad">'+
                       '<option value="">1</option>'+
                       '<option value="">2</option>'+
                     '</select>'+
                     '<div class="agregar_carrito boton_acc">'+
                       '<a href="#"> <img src="img/carro_compras.png" alt=""> Agregar Al Carrito</a>'+
                     '</div> <span class="espacio_br"></span>'+
                     '<div class="comprar_ahora boton_acc">'+
                                 '<a href="#"> <img src="img/carro_compras.png" alt=""> Comprar Ahora</a>'+
                     '</div>'+
                     '<p class="seg_tr">Transaccion Segura <img id="candado" src="img/carro_compras.png" alt=""> </p>'+
                     '<div class="">'+
                       '<table>'+
                         '<tr>'+
                           '<td class="bd_we">Envio desde</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Vendido Por</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Empaque</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                       '</table>'+
                     '</div>'+
                     '<div class="add_lista">'+
                       '<a href="#">Agregar a la lista</a>'+
                     '</div>'+
                   '</div>');


           }
           if (info.identificador_trabajo == 'sorteos') {
             $('.producto_general').html('<div class="cotenido_imagen">'+
                     '<div class="diversas_imagenes">'+
                       '<ul>'+
                         '<li onmouseover="cambio1()" ><div class=><img id="image1" src="home/img/uploads/'+info.foto+'" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image1" value="home/img/uploads/'+info.foto+'">'+
                         '<li onmouseover="cambio2()" ><div class=><img id="image2" src="img/seguro.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image2" value="img/seguro.png">'+
                         '<li onmouseover="cambio3()" ><div class=><img id="image3" src="img/salud.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image3" value="img/salud.png">'+
                         '<li onmouseover="cambio4()" ><div class=><img id="image4" src="img/seguro.png" alt=""></div></li>'+
                         '<input type="hidden" name="" id="input_image4" value="img/seguro.png">'+
                       '</ul>'+

                     '</div>'+
                     '<div class="imaegen_unica">'+
                       '<div class="img" id="img_principal">'+
                         '<img src="home/img/uploads/'+info.foto+'" alt="">'+
                       '</div>'+
                     '</div>'+
                   '</div>'+
                   '<div class="contendido_informacion">'+
                     '<div class="titulo">'+
                       '<h2>'+info.nombre+'</h2>'+
                       '<a href="#">Visita la tienda completa Leben</a>'+
                       '<p> <span>Precio</span> <span class="precio_unico">$'+info.precio+'</span>  <span class="precio_envio_total">  </span> </p>'+
                       '<div class="tabla_informcacion">'+
                         '<table>'+
                           '<tr>'+
                             '<td class="bl">Evento:</td>'+
                             '<td>'+info.nombre+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl" >Fecha Evento</td>'+
                             '<td>'+info.fecha_sorteo+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl" >Hora Evento</td>'+
                             '<td>'+info.hora_sorteo+'</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td  class="bl">Peso de Articulo:</td>'+
                             '<td> 0 libras</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Detalle:</td>'+
                             '<td>Compra esta entra digital, ve a tus cuenta y realiza la simulacion de entrada</td>'+
                           '</tr>'+
                           '<tr>'+
                             '<td class="bl">Descripcion:</td>'+
                             '<td>'+info.descripcion+'</td>'+
                           '</tr>'+
                         '</table>'+
                       '</div>'+
                     '</div>'+
                   '</div>'+
                   '<div class="contenido_entrega">'+
                     '<p class="precio_entrega">US $ '+info.precio+'</p>'+
                     '<p class="precio_envio_total"> </p>'+
                     'LLega:<span class="fecha_entrega"> 9 de Junio de 2021</span>'+
                     '<p class="disponible">Disponible</p>'+
                     '<label for="">Cantidad</label>'+
                     '<select class="cantidad" name="cantidad" placeholder="Cantidad">'+
                       '<option value="">1</option>'+
                       '<option value="">2</option>'+
                     '</select>'+
                     '<div class="agregar_carrito boton_acc">'+
                       '<a href="#"> <img src="img/carro_compras.png" alt=""> Agregar Al Carrito</a>'+
                     '</div> <span class="espacio_br"></span>'+
                     '<div class="comprar_ahora boton_acc">'+
                                 '<a href="#"> <img src="img/carro_compras.png" alt=""> Comprar Ahora</a>'+
                     '</div>'+
                     '<p class="seg_tr">Transaccion Segura <img id="candado" src="img/carro_compras.png" alt=""> </p>'+
                     '<div class="">'+
                       '<table>'+
                         '<tr>'+
                           '<td class="bd_we">Envio desde</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Vendido Por</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td class="bd_we">Empaque</td>'+
                           '<td><a href="perfil-general.php?ide='+info.ide+'">Leben.com</a></td>'+
                         '</tr>'+
                       '</table>'+
                     '</div>'+
                     '<div class="add_lista">'+
                       '<a href="#">Agregar a la lista</a>'+
                     '</div>'+
                   '</div>');


           }


         }

       },
       error:function(error){
         console.log(error);
         }

       });

});





$(document).ready(function(){
  var producto = parseFloat(document.getElementById('producto').value);
  var action = 'infoproducto';
    $.ajax({
      url:'java/precio_traslado.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.noticia == 'no_existe_ubicacion') {

           }
           if (info.longitud1 != '') {
             var lat1 = parseFloat(info.latitud1) ;
             var lon1 = parseFloat(info.longitud1);
             var lat2 = parseFloat(info.latitud2);
             var lon2 = parseFloat(info.longitud2);

             Distancia = Dist(lat1, lon1, lat2, lon2);   //Retorna numero en Km
             //alert(Distancia);
             function Dist(lat1, lon1, lat2, lon2){
               rad = function(x) {return x*Math.PI/180;}

               var R     = 6378.137;                          //Radio de la tierra en km
               var dLat  = rad( lat2 - lat1 );
               var dLong = rad( lon2 - lon1 );

               var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
               var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
               var d = R * c;

               return d.toFixed(3);                      //Retorna tres decimales
             }
           }
           var costo = 0.50;
           var peso = info.peso;
           var velocidad_promedio = 40;
           precio_final = costo*peso;
           tiempo_final = Distancia/velocidad_promedio;
           if (precio_final == '') {
             var precio_final= 0;

           }


               $('.precio_envio_total').html('+ US$ '+precio_final+' de envio y deposito  de derechos de importacion a todo el pais');

           }

       },
       error:function(error){
         console.log(error);
         }

       });

});
