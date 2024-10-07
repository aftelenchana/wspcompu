
$(document).ready(function(){
    var producto = parseFloat(document.getElementById('iproducto').value);
    var action = 'infoproducto';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},

       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.informacion_general').html('<div class="titulo_sorteo">'+
                 '<h2>'+info.nombre+'</h2>'+
                 '<p>'+info.descripcion+'</p>'+
               '</div>'+
               '<div class="contedor_info_sorteo">'+
                 '<div class="imagen_sorto">'+
                   '<img src="img/uploads/'+info.foto+'" alt="">'+
                   '<button class="desc_qr"  name="button" class=""> <a href="img/qr/'+info.qr+'" download >Descargar mi codigo Qr</a> </button>'+

                 '</div>'+
                 '<div class="tabla_info_sorteo">'+
                   '<h3>Informacion del Producto</h3>'+
                   '<table>'+
                     '<tr>'+
                       '<td class="negra">Id</td>'+
                       '<td class="balnca">'+info.idproducto+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="balnca">Ciudad</td>'+
                       '<td class="negra">'+info.ciudad+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="negra">Provincia</td>'+
                       '<td class="balnca">'+info.provincia+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="negra">Categorias</td>'+
                       '<td class="balnca">'+info.categorias+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="negra">Subcategorias</td>'+
                       '<td class="balnca">'+info.subcategorias+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="negra">Fecha de Producto</td>'+
                       '<td class="balnca">'+info.fecha_producto+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td class="negra">Precio</td>'+
                       '<td class="balnca">$'+info.precio+'</td>'+
                     '</tr>'+
                     '<tr>'+
                       '<table class="">'+
                         '<tr>'+
                           '<img  src="img/qr/'+info.qr+'" alt="" width="130px">'+
                            '<button class="desc_qr"  name="button" class=""> <a href="img/qr/'+info.qr+'" download >Descargar mi codigo Qr</a> </button>'+
                         '</tr>'+
                       '</table>'+
                     '</tr>'+
                   '</table>'+
                 '</div>'+
               '</div>');
         }
       },
       error:function(error){
         console.log(error);
         }

       });





});
