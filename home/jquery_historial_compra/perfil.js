
//Vista para comprar
$(document).ready(function(){
  //modal para agregar el producto
    var perfil = parseFloat(document.getElementById('perfil').value);
    var action = 'infoproducto';
    $.ajax({
      url:'jquery_historial_compra/perfil.php',
      type:'POST',
      async: true,
      data: {action:action,perfil:perfil},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.nombre_empresa == '') {
             $('.title').html('Perfil de '+info.nombres+' '+info.apellidos+'')
           }else {
             $('.title').html('Perfil de '+info.nombre_empresa+'')
           }
           if (info.nombre_opcional == '') {
             console.log('nokmbre opcio Vacio');
             $('.contenedore_info_personal').html('<div class="img_info_personal">'+
             '<div class="img_p_i">'+
             '<img src="img/uploads/'+info.img_logo+'" alt="">'+
             '</div>'+
             '</div>');
           }
              if (info.nombre_opcional != '') {
                console.log('no esta vacio');
                $('.contenedore_info_personal').html('<div class="img_info_personal">'+
                '<div class="letras_info_personal">'+
                '<p>'+info.nombre_opcional+'</p>'+
                '</div>'+
                '</div>');
           }
           $('.datos_empresa_td').html('<ul>'+
                          '<li class="nombre_identi_tt" type="disc"></li>'+
                          '<li type="disc"> '+info.favoritos+' Seguidores</li>'+
                          '<li type="disc" class="img_redes">'+
                            '<div class="facebook_existente redes_existen">'+
                            '</div>'+
                            '<div class="whatsapp_existente redes_existen">'+
                            '</div>'+
                            '<div class="instagram_existente redes_existen">'+
                            '</div>'+
                            '<div class="tiktok_existente redes_existen">'+
                            '</div>'+
                           '</li>'+
                           '<li type="disc"> '+info.productos+' Productos Subidos</li>'+
                           '<li type="disc"> '+info.vendidos+' Produtos Vendidos</li>'+
                           '<li type="disc" class="estado_cuenta">'+
                             '<div class="rr_positiva">'+
                             '</div>'+
                             '<div class="rr_negativa">'+
                             '</div>'+
                            '</li>'+
                            '<li type="disc">https://guibis.com/perfil?id='+info.id+'</li>'+
                        '</ul>');
                        if (info.nombre_empresa == '') {
                          $('.nombre_identi_tt').html(' '+info.nombres+' '+info.apellidos+' ')

                        }else {
                          $('.nombre_identi_tt').html(info.nombre_empresa)
                        }
                        if (info.mi_leben == 'Activa') {
                          $('.rr_positiva').html('Cuenta Verificada <img src="img/reacciones/candado-abierto.png" alt="">')


                        }else {
                          $('.rr_negativa').html('Cuenta no Verificada <img src="img/reacciones/candado-abierto.png" alt=""> ')
                        }

              if (info.whatsapp != '') {
                $('.whatsapp_existente').html('<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;CompraAgil&nbsp;https://compragil.com/vista-general-producto.php?idp='+info.idproducto+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>')

              }
              if (info.instagram != '') {
                $('.instagram_existente').html('<a target="_blank"  href="'+info.instagram+'"> <img src="img/reacciones/instagram.png" alt=""> </a>')

              }
              if (info.facebook != '') {
                $('.facebook_existente').html('<a target="_blank"  href="'+info.facebook+'"> <img src="img/reacciones/facebook.png" alt=""> </a>')

              }
              if (info.tiktok != '') {
                $('.tiktok_existente').html('<a target="_blank" href="https://www.'+info.tiktok+'"><img src="/home/img/reacciones/tiktok.png" alt=""></a>')

              }





         }
       },
       error:function(error){
         console.log(error);
         }

       });

});
