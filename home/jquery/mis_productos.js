//Ver los precios
//function precio_real(){
  //let porcentaje = document.getElementById('porcentaje__lllll');
  //let porcentaje2 = porcentaje.value;
  //var porcentaje_m = parseInt(porcentaje2);
  //var precio_m = parseInt(document.getElementById('precioddd').value);

    //precio_real_si = (porcentaje_m*precio_m)/100 + precio_m;
//
    //console.log(precio_real_si);

   //document.getElementById('precio_realee').innerText = `Precio Real ${precio_real_si}`;
//}
//Vel los precios segundo metodo
function calcular_servicio(){
  try{
    var a = parseFloat(document.getElementById('precio_servicio').value) || 0;
        b = parseFloat(document.getElementById('porcentaje_servicio').value) || 0;
        precio_real = (a*b)/100 + a;
       document.getElementById('precio_real_servicio').innerText = `${precio_real}`;

  } catch (e){}
}


//Vel recaudado de boletos
function calcular_recaudacion_boletos(){
  try{
    var a = parseFloat(document.getElementById('precio_boleto').value) || 0;
        b = parseFloat(document.getElementById('cantidad_boletos').value) || 0;
        c = parseFloat(document.getElementById('porcentaje_boletos').value) || 0;
        precio_real = (a*b) - a*b*c/100;
       document.getElementById('cantidad_recaudar').innerText = `${precio_real}`;

  } catch (e){}
}

//Vel recaudado de boletos
function calcular_recaudacion_eventos(){
  try{
    var a = parseFloat(document.getElementById('precio_entradas').value) || 0;
        b = parseFloat(document.getElementById('cantidad_entradas').value) || 0;
        c = parseFloat(document.getElementById('porcentaje_entradas').value) || 0;
        precio_real = (a*b) - a*b*c/100;

       document.getElementById('cantidad_eventos').innerText = `${precio_real}`;

  } catch (e){}
}




function calcular_producto(){
  try{
    var a = parseFloat(document.getElementById('precio_new_producto').value) || 0;
        b = parseFloat(document.getElementById('porcentaje_producto').value) || 0;
        precio_real = (a*b)/100 + a;
       document.getElementById('precio_real_new_product').innerText = `${precio_real}`;

  } catch (e){}
}

//Vel los precios segundo metodo

function calcular(){
  try{
    var a = parseFloat(document.getElementById('precioddd').value) || 0;
        b = parseFloat(document.getElementById('porcentaje__lllll').value) || 0;
        precio_real = (a*b)/100 + a;
       document.getElementById('precio_realee').innerText = `${precio_real}`;

  } catch (e){}
}

//Vel los precios segundo metodo

function calcular_edit(){
  try{
    var a = parseFloat(document.getElementById('precio_edit').value) || 0;
        b = parseFloat(document.getElementById('porcentaje_edit').value) || 0;
        precio_real = (a*b)/100 + a;
       document.getElementById('precio_real_edit').innerText = `${precio_real}`;

  } catch (e){}
}








//Agregar nuevo producto
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_producto').click(function(e){
    e.preventDefault();
    var usuario = $(this).attr('usuario');
    var action = 'infoUsuario';
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
             $('.bodyModal_add_servicios').html('<form class="form_add_producto" action="" method="post" name="add_form_add_servicios" id="add_form_add_servicios" onsubmit="event.preventDefault(); sendDataedit_add_servicios();">'+
                 '<h3 class="idf_user">'+info.nombres+' Agrega un nuevo producto</h3>'+
                 '<input class="name_product" type="text"  name="nombre_producto"  placeholder="Nombre del producto" required>'+
                 '<input class="precio_product" type="number"  name="precio"  placeholder="Precio" required oninput="calcular_producto()" id="precio_new_producto" step="0.001">'+
                  '<input class="marca_producto" type="text"  name="marca_producto"  placeholder="Ingrese la Marca " >'+
                   '<select class="provincia" name="provincia" id="provincia" class="input-48" required>'+
                     '<option value="0"> Selecione la Provincia</option>'+
                   '</select>'+
                   '<select class="ciudad" name="ciudad" id="ciudad" class="input-48" required>'+
                     '<option value="0" > Selecione la Ciudad</option>'+
                   '</select><br>'+
                 '<select class="categorias" name="categorias" id="categorias" required >'+
                 '</select>'+
                 '<select class="subcategorias" name="subcategorias" id="subcategorias" required>'+
                 '<option value="0" > Selecione la Subcategoria</option>'+
                 '</select>'+
                 '<br>'+
                 '<label for="foto">Selecciona una foto de tu producto</label>'+
                  '<input  type="file" name="foto"  accept="image/png, .jpeg, .jpg" required>'+
                  '<input type="hidden" name="action" value="editt_add_servicios" required><br>'+
                  '<textarea class="descripcion_product" required name="descripcion" rows="5" cols="40"  placeholder="Descripcion"></textarea>'+
                  '<br>'+
                  '<div class="alert_general_new_product">'+
                  '</div>'+
                  '<br>'+
                  '<button type="submit" name="button" class="btn_new">Agregar Nuevo Producto</button>'+
                  '<a class="btn_ok closeModal" onclick="closeModaleditt_add_servicios();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');
                if (info.nombre_empresa == '') {
                    $('.idf_user').html(''+info.nombres+' Agrega un nuevo Producto');

                }else {
                  $('.idf_user').html(''+info.nombre_empresa+' Agrega un nuevo Producto');
                }


                $("document").ready(function(){
                $( "#categorias" ).load( "server/datos.php" );
                $("#categorias").change(function(){
                    var id =   $("#categorias").val();
                    $.get("server/datos1.php", {id:id})
                    .done(function(data){
                    $("#subcategorias" ).html(data);
                   })
                })
                })
                $("document").ready(function(){
                $( "#provincia" ).load( "server/lugar.php" );
                $("#provincia").change(function(){
                    var idd =   $("#provincia").val();
                    $.get("server/lugar1.php", {id:idd})
                    .done(function(data){
                    $("#ciudad" ).html( data );
                   })
                })
                })




         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_add_servicios').fadeIn();


  });

});





//Ver mi prodcuto

$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_producto').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'infover';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_ver_producto').html('<form class="form_ver_product" action="" method="post" name="add_form_ver_producto" id="add_form_ver_producto" onsubmit="event.preventDefault();" >'+
             '<div class="titu_info">'+
               '<h4>INFORMACIÓN DEL PRODUCTO</h4>'+
               '<div class="informacion_general">'+
                 '<table style="margin: 0 auto;">'+
                   '<tr>'+
                     '<td class="img_producto_comerce principal"><img src="img/uploads/'+info.foto+'"  ></td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="nombre_producto_comerce principal">Nombre:'+info.nombre+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="nombre_producto_comerce principal">Cantidad:'+info.cantidad+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="precio_comerce principal">Precio: $'+info.precio+'</td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="id_producto_comerce principal">ID :#<a class="btn_ok closeModal"  href="producto?idp='+info.idproducto+'">'+info.idproducto+'</a>  </td>'+
                   '</tr>'+
                   '<tr>'+
                     '<td class="fecha_creacion_comerce">Fecha:'+info.fecha_producto+'  </td>'+
                   '</tr>'+
                   '<tr>'+
                    '<td class="descripcion_comerce">Descripcion:'+info.descripcion+' </td>'+
                   '</tr>'+
                 '</table>'+
               '</div>'+
             '</div>'+
              '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
          '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModaleditt_ver_producto();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
          '</div>'+
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
  $('.edtar_producto').click(function(e){
    e.preventDefault();
    var producto = $(this).attr('producto');
    var action = 'info_editar';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_editar_producto').html('<form class="form_edit_product" action="" method="post" name="add_form_editar_producto" id="add_form_editar_producto" onsubmit="event.preventDefault(); sendDataedit_editar_producto();" >'+
                       '<h4>Editar producto</h4>'+
                       '<input type="hidden" name="idproducto" value="'+info.idproducto+'">'+
                       '<input id="nombre_comerce" class="nombre_comerce" type="text" value="'+info.nombre+'"  name="nombre_producto"  placeholder="Nombre del producto" required>'+
                       '<input id="precio_edit" class="precio_edit_comerce"  type="text"  name="precio" value="'+info.precio+'" placeholder="Precio" required  oninput="calcular_edit()" step="0.001">'+
                         '<select class="provincia" name="provincia" id="provincia3" class="input-48" required>'+
                           '<option value="'+info.id_provincia+'">'+info.provincia+'</option>'+
                         '</select>'+
                         '<select class="ciudad3" name="ciudad" id="ciudad3" class="input-48" required>'+
                           '<option value="'+info.id_ciudad+'" >'+info.ciudad+'</option>'+
                         '</select>'+
                       '<select class="categorias" name="categorias" id="categorias3" >'+
                       '<option value="'+info.id_categorias+'" >'+info.categorias+'</option>'+
                       '</select>'+
                       '<select class="subcategorias3" name="subcategorias" id="subcategorias3">'+
                       '<option value="0" > Selecione la Subcategoria</option>'+
                       '</select><br>'+
                         '<span>$</span> <span id="precio_real_edit"></span>'+
                         '<input  type="file" name="foto"  accept="image/png, .jpeg, .jpg" required>'+
                        '<input type="hidden" name="action" value="editt_editar_producto" required><br>'+
                        '<textarea class="descripcion_editar2" value="" name="descripcion" rows="5" cols="38" >'+info.descripcion+'</textarea>'+
                        '<br>'+
                        '<button type="submit" name="button" class="btn_new">Editar Producto</button>'+
                        '<a class="btn_ok closeModal" onclick="closeModaleditt_editar_producto();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                        '<div class="alerta_editar_producto">'+
                        '</div>'+
                      '</form>');
                      $("document").ready(function(){
                      $( "#categorias3" ).load( "server/datos.php" );
                      $("#categorias3").change(function(){
                          var id =   $("#categorias3").val();
                          $.get("server/datos1.php", {id:id})
                          .done(function(data){
                          $("#subcategorias3" ).html(data);
                         })
                      })
                      })
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
   $('.alerta_editar_producto').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
  var parametros = new  FormData($('#add_form_editar_producto')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery/mis_productos.php',
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
      if (info.noticia == 'editado_correctamente') {
        $('.alerta_editar_producto').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/garrapata.png" width="50px" alt="">'+
          '<p>Producto Editado Correctamente</p>'+
        '</div>');
      }
      if (info.noticia == 'error_insertar') {
        $('.alerta_editar_producto').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/cerca.png" width="50px" alt="">'+
          '<p>Error en el servidor</p>'+
        '</div>');

      }

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
//Eliminar mi prodcuto

$(document).ready(function(){
  //modal para agregar el producto
  $('.eliminar_producto').click(function(e){
    e.preventDefault();

    var producto = $(this).attr('producto');
    var action = 'eliminar_actual_producto';
    $('.prut'+producto+'').html(' <div class="notificacion_negativa">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.respuesta == 'elimado_correctamnete') {
             document.getElementById('fila_producto'+info.idproducto+'').style.display = "none";
           }
           if (info.respuesta == 'error_insertar') {
             $('.eliminar_producto').html('<div class="noti_fac_negativa"><p>Error al eliminar </p><img src="img/reacciones/cerrar.png" width="60px" alt=""></div>');

           }



         }
       },
       error:function(error){
         console.log(error);
         }
       });

  });

});
