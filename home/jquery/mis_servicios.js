
//Ver mi prodcuto

$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_servicios').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'infoproducto';
    $.ajax({
      url:'jquery/mis_servicios.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_ver_producto').html('<form class="form_ver_product" action="" method="post" name="add_form_ver_producto" id="add_form_ver_producto" onsubmit="event.preventDefault();" >'+
             '<div class="titu_info">'+
               '<h4>informacion del producto</h4>'+
               '<div class="informacion_general">'+
                 '<table>'+
                   '<tr>'+
                     '<td class="img_producto_comerce principal"><img src="img/uploads/'+info.foto+'"  ></td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td>Agregar imagenes de mi Producto</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="nombre_producto_comerce principal">Nombre del Servicio:'+info.nombre+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="precio_comerce principal">Precio del Servicio: $'+info.precio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class=" principal">Tipo de Servicio:'+info.tipo_servicio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="id_producto_comerce principal">ID : '+info.idproducto+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="fecha_creacion_comerce">Fecha:'+info.fecha_producto+'  </td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="porcentaje_comerce principal"> Porcentaje de Venta:% '+info.porcentaje+'</td>'+
                   '</tr>'+
                   '<tr>'+
                    '<td class="descripcion_comerce">Descripcion:'+info.descripcion+' </td>'+
                   '</tr>'+

                   '<tr>'+
                     '<td class="img_qr_comerce"><img src="QR/codigosproductos/'+info.qr+'"  ></td>'+
                   '</tr>'+
                 '</table>'+
               '</div>'+
             '</div>'+
             '<button class="desc_qr"  name="button" class=""> <a href="QR/codigosproductos/'+info.qr+'" download >Descargar mi codigo Qr</a> </button>'+
              '<a class="btn_ok closeModal" onclick="closeModaleditt_ver_producto();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
            '</form>');
         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_producto').fadeIn();

  });

});

function closeModaleditt_ver_producto(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_ver_producto').fadeOut();
}






//Editar producto
$(document).ready(function(){
  //modal para agregar el producto
  $('.edtar_servicios').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'infoproducto';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_editar_producto').html('<form class="form_edit_product" action="" method="post" name="add_form_editar_servicio" id="add_form_editar_servicio" onsubmit="event.preventDefault(); sendDataedit_editar_producto();">'+
             '<h4>Editar producto</h4>'+
             '<input type="hidden" name="idproducto" value="132">'+
             '<input id="nombre_comerce" value="'+info.nombre+'" class="nombre_comerce" type="text"  name="nombre_producto"  placeholder="Nombre del producto" required>'+
             '<input id="precio_edit" class="precio_edit_comerce"  type="text"  name="precio" value="'+info.precio+'" placeholder="Precio" required  oninput="calcular_edit()" step="0.001">'+
             '<select class="tipo" name="tipo" required>'+
               '<option value="Cerrajeria">Cerrajeria</option>'+
               '<option value="Automotriz">Automotriz</option>'+
             '</select>'+
             '<br>'+
               '<select class="provincia" name="provincia" id="provincia3" class="input-48" required>'+
                 '<option value="'+info.provincia+'"></option>'+
               '</select>'+
               '<select class="ciudad3" name="ciudad" id="ciudad3" class="input-48" required>'+
                 '<option value="'+info.ciudad+'" > Selecione la Ciudad</option>'+
               '</select>'+
             '<br>'+
               '<select id="porcentaje_edit"class="porcentaje_editar" name="porcentaje"  oninput="calcular_edit()">'+
                 '<option value="'+info.porcentaje+'">'+info.porcentaje+'%</option>'+
                 '<option value="6">6%</option>'+
                 '<option value="7">8%</option>'+
                 '<option value="10">10%</option>'+
                 '<option value="12">12%</option>'+
                 '<option value="14">14%</option>'+
                 '<option value="16">16%</option>'+
               '</select>'+
               '<span>$</span> <span id="precio_real_edit"></span>'+
               '<input  type="file" name="foto"  accept="image/png, .jpeg, .jpg">'+
              '<input type="hidden" name="action" value="editt_editar_servicio" required><br>'+
              '<input type="hidden" name="idproducto" value="'+info.idproducto+'" required><br>'+
              '<textarea class="descripcion_editar2" name="descripcion" rows="5" cols="38" >'+info.descripcion+'</textarea>'+
              '<br>'+
              '<input type="hidden" name="fotoactual" value="'+info.foto+'" required><br>'+
              '<br>'+
              '<div class="alerteditt_edit_servicio">'+
              '</div>'+
              '<button type="submit" name="button" class="btn_new">Editar Producto</button>'+
              '<a class="btn_ok closeModal" onclick="closeModaleditt_editar_producto();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
            '</form>');

            $("document").ready(function(){
            $( "#provincia3" ).load( "server/lugar.php" );
            $("#provincia3").change(function(){
                var idd =   $("#provincia3").val();
                $.get("server/lugar1.php", {id:idd})
                .done(function(data){
                $("#ciudad3" ).html( data );
               })
            })
            })
          }
        },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_editar_producto').fadeIn();

  });

});
function sendDataedit_editar_producto(){
  var parametros = new  FormData($('#add_form_editar_servicio')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery/mis_servicios.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){

      if (response =='error') {
        $('.alerteditt_editar_producto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      $('.alerteditt_edit_servicio').html('<div class="alert_add_producto posi_alert"> <p class="alerta_positiva">Servicio Editado Correctamente</p> </div>');
      $('.fila_img_producto'+info.idproducto+'').html(info.foto);
      $('.fila_nombre_producto'+info.idproducto+'').html(info.nombre);
      $('.fila_precio'+info.idproducto+'').html(info.precio);
      $('.img_producto'+info.idproducto+'').html('<td class="fila_img_producto"> <img src="img/uploads/'+info.foto+'" alt=""> </td>');
      }

    }

  });

}
function closeModaleditt_editar_producto(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_editar_producto').html('');
  $('.modal_editar_producto').fadeOut();
}


//Eliminar mi prodcuto

$(document).ready(function(){
  //modal para agregar el producto
  $('.eliminar_servicios').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'infoproducto';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},

       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_eliminar_producto').html('<form class="form_delete_product" action="" method="post" name="add_form_eliminar_servicio" id="add_form_eliminar_servicio" onsubmit="event.preventDefault(); sendDataedit_eliminar_producto();" >'+
                         '<div class="titu_info">'+
                           '<h4>informacion del producto</h4>'+
                           '<div class="informacion_general">'+
                             '<table>'+
                               '<tr>'+
                                 '<td class="img_producto_comerce"><img src="img/uploads/'+info.foto+'" alt=""  ></td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="nombre_producto_comerce">Nombre: '+info.nombre+'</td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="precio_comerce">Precio: $ '+info.precio+'</td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="id_producto_comerce">ID: '+info.idproducto+' </td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="fecha_creacion_comerce">Fecha Creacion:'+info.fecha_producto+' </td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="porcentaje_comerce">Porcentaje de Venta:'+info.porcentaje+' </td>'+
                               '</tr>'+
                               '<tr>'+
                                '<td class="descripcion_comerce">Descripcion:'+info.descripcion+'</td>'+
                               '</tr>'+
                               '<tr>'+
                                 '<td class="img_qr_comerce"><img src="QR/codigosproductos/'+info.qr+'" alt=""  ></td>'+
                               '</tr>'+
                             '</table>'+
                           '</div>'+
                         '</div>'+
                         '<div class="alert_eliminar_fg ">'+
                         '</div>'+
                         '<input type="hidden" name="idproducto" value="'+info.idproducto+'">'+
                         '<input type="hidden" name="action" value="eiminar_servicios" required><br>'+
                         '<button type="submit" name="button" class="btn_new">Eliminar Este Producto</button>'+
                        '<a class="btn_ok closeModal" onclick="closeModaleditt_eliminar_producto();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                      '</form>');


         }
       },
       error:function(error){
         console.log(error);
         }
       });
    $('.modal_eliminar_producto').fadeIn();

  });

});

function sendDataedit_eliminar_producto(){
  var parametros = new  FormData($('#add_form_eliminar_servicio')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery/mis_servicios.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerteditt_editar_producto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      $('.alert_eliminar_fg').html('<div class="alert_add_producto posi_alert"> <p class="alerta_positiva">Producto Eliminado Correctamente</p> </div>');
      $('.total_comerse .producto_vista'+info.idproducto+'').html('');
      function Actualizacion2(){
        $('.modal_eliminar_producto').fadeOut();}
      setInterval(Actualizacion2, 2000);
      }
    }
  });

}

function closeModaleditt_eliminar_producto(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_ver_producto').html('');
  $('.modal_eliminar_producto').fadeOut();
}
