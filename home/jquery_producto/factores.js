
$(document).ready(function(){
    var producto = parseFloat(document.getElementById('iproducto').value);
    var action = 'infoproducto';
    $.ajax({
      url:'jquery/mis_productos.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},

       success: function(response){
         console.log('si entra al cuadri general');
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

$(document).ready(function(){
    var producto = parseFloat(document.getElementById('iproducto').value);
    var action = 'infoproducto';
    $.ajax({
      url:'jquery_producto/factores.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           if (info.categorias == '2' || info.categorias == '9' ) {
             $('.factores').html('  <div class="tito_factores">'+
                 '<h3>Información Extra</h3>'+
                 '<p class="enfasis" >(*Al agregar esta informacion el sistema te hara visible en comparaciones con otros productos similares)</p>'+
               '</div>'+
               '<div class="tabla">'+
                 '<form class="" action="" method="post" name="add_form_add_factor" id="add_form_add_factor" onsubmit="event.preventDefault(); sendDatafactores();">'+
                   '<table>'+
                     '<tr>'+
                       '<td class="">'+
                        'Tipo'+
                       '</td>'+
                       '<td class="tipo_libro_interno" ></td>'+
                       '<td> <select class="seleccionar_tangible"  id="tangibilidad" name="tangibilidad">'+
                       '<option value="Fisico">Fisico</option>'+
                         '<option value="Digital">Digital</option>'+
                       '</select> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Archivo Extra</td>'+
                       '<td class="conte_pdf_extra" >'+
                       '<div class="archivo_extra_si">'+
                       '</td>'+
                       '<td> <input type="file" name="pdf_extra" value=""  accept="application/pdf"> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Paginas</td>'+
                       '<td class="conten_paginas"></td>'+
                       '<td> <input type="number" name="paginas_libro_into" value="'+info.paginas_libro+'"> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Autor</td>'+
                       '<td class="conte_autor_libro"></td>'+
                       '<td> <input type="text" name="aotir_libro_into" value="'+info.autor_libro+'"> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Edicion Libro</td>'+
                       '<td class="conten_edision_libro"></td>'+
                       '<td> <select class="edicion_libro_into"  id="edicion_libro_into" name="edicion_libro_into">'+
                       '<option value="Primera Edicion">Primera Edicion</option>'+
                         '<option value="Segunda Edicion">Segunda Edicion</option>'+
                          '<option value="Tercera Edicion">Tercera Edicion</option>'+
                           '<option value="Cuarta Edicion">Cuarta Edicion</option>'+
                            '<option value="Quinta Edicion">Quinta Edicion</option>'+
                       '</select> </td>'+
                     '</tr>'+
                     '<div class="caso_digital">'+
                       '<tr>'+
                         '<td>Enlace Mega</td>'+
                         '<td class="conten_enlace_mega"></td>'+
                         '<td> <input type="text" name="enlace_mega_int_d" value="'+info.enlace_mega+'"> </td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Codigo Encriptado</td>'+
                         '<td class="conte_encrip_meg" >'+
                         '</td>'+
                         '<td> <input type="text" name="codigo_encriptado_int" value="'+info.encriptacion_mega_libro+'"> </td>'+
                       '</tr>'+
                     '</div>'+
                   '</table>'+
                   '<div class="notidicacion_factor"></div>'+
                     '<input type="hidden" name="action" value="add_factores_libros">'+
                      '<input type="hidden" name="idproducto" value="'+info.idproducto+'">'+
                     '<input type="hidden" name="existencia_erchivo" value="'+info.pdf_extra+'">'+
                   '<input class="enviar_actualizar_factor_libro" type="submit" name="" value="Actualizar">'+
               '</div>'+
             '</div>');
                   if (info.tipo_libro== '') {
                     $('.tipo_libro_interno').html('<div class="tipo_tangible">Ninguno</div>');
                   }else {
                     $('.tipo_libro_interno').html('<div class="tipo_digital">'+info.tipo_libro+'</div>');
                   }
                   if (info.enlace_mega== '') {
                     $('.conten_enlace_mega').html('<div class="mega_no">Ninguno</div>');

                   }else {
                     $('.conten_enlace_mega').html('<div class="mega_si"><a target="_blank" href="'+info.enlace_mega+'"> <img src="img/reacciones/mega.png" alt=""> </a></div>');
                   }
                   if (info.encriptacion_mega_libro== '') {
                     $('.conte_encrip_meg').html('<div class="sin_codigo_encrip">Ninguno</div>');
                   }else {
                      $('.conte_encrip_meg').html('<div class="con_codigo_encriptacion">'+info.encriptacion_mega_libro+'</div>');
                   }
                   if (info.paginas_libro== '') {
                     $('.conten_paginas').html('<div class="sin_contenido">Ninguno</div>');
                   }else {
                      $('.conten_paginas').html('<div class="con_contenido">'+info.paginas_libro+'</div>');

                   }if (info.autor_libro== '') {
                     $('.conte_autor_libro').html('<div class="sin_contenido">Ninguno</div>');
                   }else {
                      $('.conte_autor_libro').html('<div class="con_contenido">'+info.autor_libro+'</div>');

                   }if (info.editorial_libro== '') {
                     $('.conten_edision_libro').html('<div class="sin_contenido">Ninguno</div>');
                   }else {
                      $('.conten_edision_libro').html('<div class="con_contenido">'+info.editorial_libro+'</div>');

                   }
                   if (info.pdf_extra== '') {
                     $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
                   }else {
                     $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'">   <img src="img/reacciones/pdf.png" alt=""> </a></div>');
                   }

           }
           if (info.categorias == '3') {
             console.log('esto es ropa y accesorios');
             if (info.subcategorias == '11') {
               console.log('esto son zapatos');
               $('.factores').html('<div class="tito_factores">'+
                   '<h3>Información Extra para Categoria Ropa y Accesorios;Sucategoria Zapatos</h3>'+
                   '<p class="enfasis" >(*Al agregar esta informacion el sistema te hara visible en comparaciones con otros productos similares)</p>'+
                 '</div>'+
                 '<div class="tabla">'+
                   '<form class="" action="" method="post" name="add_form_add_factor_zapatos" id="add_form_add_factor_zapatos" onsubmit="event.preventDefault(); sendDatafactores_zapatos();">'+
                     '<table>'+
                     '<tr>'+
                       '<td>Tipo Calzado</td>'+
                       '<td class="tipo_calzado_int"></td>'+
                       '<td> <select class=""  name="tipo_calzado_hh">'+
                       '<option value="Deportivo">Deportivo</option>'+
                       '<option value="Escolar">Escolar</option>'+
                       '<option value="Cazual">Cazual</option>'+
                       '<option value="Montañero">Montañero</option>'+
                       '<option value="Playero">Playero</option>'+
                       '</select> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Color</td>'+
                       '<td class="color_calzado_int"></td>'+
                       '<td> <select class=""  id="tangibilidad" name="color_calzado_hh">'+
                       '<option value="Azul">Azul</option>'+
                       '<option value="Negro">Negro</option>'+
                       '<option value="Amarillo">Amarillo</option>'+
                       '<option value="Blanco">Blanco</option>'+
                       '<option value="Verde">Verde</option>'+
                       '</select> </td>'+
                     '</tr>'+
                       '<tr>'+
                         '<td class="">'+
                          'Talla'+
                         '</td>'+
                         '<td class="talla_calzado_int" ></td>'+
                         '<td> <select class=""  name="talla_calzado">'+
                         '<option value="42">42</option>'+
                         '<option value="41">41</option>'+
                         '<option value="40">40</option>'+
                         '<option value="39">39</option>'+
                         '<option value="38">38</option>'+
                         '<option value="37">37</option>'+
                         '<option value="36">36</option>'+
                         '<option value="35">35</option>'+
                         '<option value="34">34</option>'+
                         '<option value="33">33</option>'+
                         '<option value="32">32</option>'+
                         '<option value="31">31</option>'+
                         '<option value="30">30</option>'+
                         '<option value="29">29</option>'+
                         '<option value="28">28</option>'+
                         '<option value="27">27</option>'+
                         '<option value="26">26</option>'+
                         '<option value="25">25</option>'+
                         '<option value="24">24</option>'+
                         '<option value="23">23</option>'+
                         '<option value="24">24</option>'+
                         '<option value="22">22</option>'+
                         '<option value="21">21</option>'+
                         '</select> </td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Planta</td>'+
                         '<td class="planta_calzado_int"></td>'+
                         '<td> <select class="" name="planta_calzado_int">'+
                         '<option value="Caucho">Caucho</option>'+
                         '<option value="Goma">Goma</option>'+
                         '<option value="Espansor">Espansor</option>'+
                         '<option value="Suela">Suela</option>'+
                         '</select> </td>'+
                       '</tr>'+
                         '<td>Corte</td>'+
                         '<td class="material_corte_int"></td>'+
                         '<td> <select class=""  name="material_corte">'+
                         '<option value="Cuero">Cuero</option>'+
                         '<option value="Cuerina">Cuerina</option>'+
                         '<option value="Tela">Tela</option>'+
                         '<option value="Sintetito">Sintetito</option>'+
                          '<option value="Expandible">Expandible</option>'+
                         '</select> </td>'+
                       '</tr>'+
                         '<tr>'+
                           '<td>Archivo Extra(Pdf) Manual de uso,Permisos etc</td>'+
                           '<td class="conte_pdf_extra" >'+
                           '<div class="archivo_extra_si">'+
                           '</td>'+
                           '<td> <input type="file" name="pdf_extra" value=""  accept="application/pdf"> </td>'+
                         '</tr>'+
                     '</table>'+
                     '<div class="notidicacion_factor"></div>'+
                       '<input type="hidden" name="action" value="add_factores_zapatos">'+
                        '<input type="hidden" name="idproducto" value="'+info.idproducto+'">'+
                       '<input type="hidden" name="existencia_erchivo" value="'+info.pdf_extra+'">'+
                     '<input class="enviar_actualizar_factor_libro" type="submit" name="" value="Actualizar">'+
                 '</div>'+
               '</div>');

                     if (info.tipo_calzado== '') {
                       $('.tipo_calzado_int').html('<div class="tipo_tangible">Ninguno</div>');
                     }else {
                       $('.tipo_calzado_int').html('<div class="tipo_digital">'+info.tipo_calzado+'</div>');
                     }
                     if (info.color_calzado== '') {
                       $('.color_calzado_int').html('<div class="mega_no">Ninguno</div>');
                     }else {
                       $('.color_calzado_int').html('<div class="mega_si">'+info.color_calzado+'</div>');
                     }
                     if (info.talla_calzado== '') {
                       $('.talla_calzado_int').html('<div class="">Ninguno</div>');
                     }else {
                        $('.talla_calzado_int').html('<div class="">'+info.talla_calzado+'</div>');
                     }
                     if (info.planta_calzado== '') {
                       $('.planta_calzado_int').html('<div class="sin_contenido">Ninguno</div>');
                     }else {
                        $('.planta_calzado_int').html('<div class="con_contenido">'+info.planta_calzado+'</div>');

                     }if (info.material_corte== '') {
                       $('.material_corte_int').html('<div class="sin_contenido">Ninguno</div>');
                     }else {
                        $('.material_corte_int').html('<div class="con_contenido">'+info.material_corte+'</div>');
                     }
                     if (info.pdf_extra== '') {
                       $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
                     }else {
                       $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'">   <img src="img/reacciones/pdf.png" alt=""> </a></div>');
                     }

             }
             if (info.subcategorias == '10') {
               console.log('esto ES ROPA');
               $('.factores').html('<div class="tito_factores">'+
                   '<h3>Información Extra para Categoria Ropa y Accesorios;Sucategoria Zapatos</h3>'+
                   '<p class="enfasis" >(*Al agregar esta informacion el sistema te hara visible en comparaciones con otros productos similares)</p>'+
                 '</div>'+
                 '<div class="tabla">'+
                   '<form class="" action="" method="post" name="add_form_add_factor_ropa_sc0" id="add_form_add_factor_ropa_sc0" onsubmit="event.preventDefault(); sendDatafactores_ropa_sc_10();">'+
                     '<table>'+
                     '<tr>'+
                       '<td>Tipo Ropa</td>'+
                       '<td class="tipo_ropa_int"></td>'+
                       '<td> <select class=""  name="tipo_ropa_hh">'+
                       '<option value="Deportivo">Deportivo</option>'+
                       '<option value="Escolar">Escolar</option>'+
                       '<option value="Formal">Formal</option>'+
                       '<option value="Playero">Playero</option>'+
                       '<option value="Playero">Interior</option>'+
                       '</select> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Color</td>'+
                       '<td class="color_ropa_int"></td>'+
                       '<td> <select class=""   name="color_ropa_hh">'+
                       '<option value="Azul">Azul</option>'+
                       '<option value="Negro">Negro</option>'+
                       '<option value="Amarillo">Amarillo</option>'+
                       '<option value="Blanco">Blanco</option>'+
                       '<option value="Verde">Verde</option>'+
                       '<option value="Verde">Otro</option>'+
                       '</select> </td>'+
                     '</tr>'+
                     '<tr>'+
                       '<td>Envios</td>'+
                       '<td class="envios_int"></td>'+
                       '<td> <select class="" name="envios_hh">'+
                       '<option value="Local">Local</option>'+
                       '<option value="Nacional">Nacional</option>'+
                       '</select> </td>'+
                     '</tr>'+
                       '<tr>'+
                         '<td class="">'+
                          'Talla'+
                         '</td>'+
                         '<td class="talla_ropa_int" ></td>'+
                         '<td> <select class=""  name="talla_ropa">'+
                         '<option value="Small(S)">Small(S)</option>'+
                         '<option value="Medium(M)">Medium(M)</option>'+
                         '<option value="Large(L)">Large(L)</option>'+
                         '<option value="Extra Large(XL)">Extra Large(XL)</option>'+
                         '<option value="Extra Grande (EG)">Extra Grande (EG)</option>'+
                         '</select> </td>'+
                       '</tr>'+
                       '<tr>'+
                         '<td>Tela</td>'+
                         '<td class="tela_ropa_int"></td>'+
                         '<td> <select class="" name="tela_int">'+
                         '<option value="Algodón">Algodón</option>'+
                         '<option value="Poliéster">Poliéster</option>'+
                         '<option value="Lino">Lino</option>'+
                         '<option value="Lana">Lana</option>'+
                         '<option value="Mohair">Mohair</option>'+
                         '<option value="Seda">Seda</option>'+
                         '<option value="Piel y cuero">Piel y cuero</option>'+
                         '</select> </td>'+
                         '</tr>'+
                         '<tr>'+
                           '<td>Genero</td>'+
                           '<td class="genero_ropa_int"></td>'+
                           '<td> <select class="" name="genero_ropa_int">'+
                           '<option value="Hombre">Hombre</option>'+
                           '<option value="Mujer">Mujer</option>'+
                           '<option value="Unisex">Unisex</option>'+
                           '</select> </td>'+
                           '</tr>'+
                         '<tr>'+
                           '<td>Archivo Extra(Pdf) Manual de uso,Permisos etc</td>'+
                           '<td class="conte_pdf_extra" >'+
                           '<div class="archivo_extra_si">'+
                           '</td>'+
                           '<td> <input type="file" name="pdf_extra" value=""  accept="application/pdf"> </td>'+
                         '</tr>'+
                     '</table>'+
                     '<div class="notidicacion_factor"></div>'+
                       '<input type="hidden" name="action" value="add_factores_ropa">'+
                        '<input type="hidden" name="idproducto" value="'+info.idproducto+'">'+
                       '<input type="hidden" name="existencia_erchivo" value="'+info.pdf_extra+'">'+
                     '<input class="enviar_actualizar_factor_libro" type="submit" name="" value="Actualizar">'+
                 '</div>'+
               '</div>');

                     if (info.tipo_ropa== '') {
                       $('.tipo_ropa_int').html('<div class="tipo_tangible">Ninguno</div>');
                     }else {
                       $('.tipo_ropa_int').html('<div class="tipo_digital">'+info.tipo_ropa+'</div>');
                     }
                     if (info.color_ropa== '') {
                       $('.color_ropa_int').html('<div class="mega_no">Ninguno</div>');
                     }else {
                       $('.color_ropa_int').html('<div class="mega_si">'+info.color_ropa+'</div>');
                     }
                     if (info.envios== '') {
                       $('.envios_int').html('<div class="">Ninguno</div>');
                     }else {
                        $('.envios_int').html('<div class="">'+info.envios+'</div>');
                     }
                     if (info.talla_ropa== '') {
                       $('.talla_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
                     }else {
                        $('.talla_ropa_int').html('<div class="con_contenido">'+info.talla_ropa+'</div>');

                     }if (info.tela_ropa== '') {
                       $('.tela_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
                     }else {
                        $('.tela_ropa_int').html('<div class="con_contenido">'+info.tela_ropa+'</div>');
                     }

                     }if (info.genero_ropa== '') {
                       $('.genero_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
                     }else {
                        $('.genero_ropa_int').html('<div class="con_contenido">'+info.genero_ropa+'</div>');
                     }

                     if (info.pdf_extra== '') {
                       $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
                     }else {
                       $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'">   <img src="img/reacciones/pdf.png" alt=""> </a></div>');
                     }



           }
           $('.informacion_general').html('');
         }
       },
       error:function(error){
         console.log(error);
         }

       });
});



function sendDatafactores(){
   $('.notidicacion_factor').html('<div class="proceso">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_form_add_factor')[0]);
  $.ajax({
    data: parametros,
    url:'jquery_producto/factores.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.alerteditt_registrarte').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
        var info = JSON.parse(response);
        if (info.noticia == 'inser_exito') {
          if (info.tangibilidad== '') {
            $('.tipo_libro_interno').html('<div class="tipo_tangible">Ninguno</div>');
          }else {
            $('.tipo_libro_interno').html('<div class="tipo_digital">'+info.tangibilidad+'</div>');
          }
          if (info.enlace_mega_int_d== '') {
            $('.conten_enlace_mega').html('<div class="mega_no">Ninguno</div>');

          }else {
            $('.conten_enlace_mega').html('<div class="mega_si"><a target="_blank" href="'+info.enlace_mega_int_d+'"> <img src="img/reacciones/mega.png" alt=""> </a></div>');
          }
          if (info.codigo_encriptado_int== '') {
            $('.conte_encrip_meg').html('<div class="sin_codigo_encrip">Ninguno</div>');
          }else {
             $('.conte_encrip_meg').html('<div class="con_codigo_encriptacion">'+info.codigo_encriptado_int+'</div>');

          }
          if (info.paginas_libro== '') {
            $('.conten_paginas').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.conten_paginas').html('<div class="con_contenido">'+info.paginas_libro+'</div>');

          }if (info.autor_libro== '') {
            $('.conte_autor_libro').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.conte_autor_libro').html('<div class="con_contenido">'+info.autor_libro+'</div>');

          }if (info.editorial_libro== '') {
            $('.conten_edision_libro').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.conten_edision_libro').html('<div class="con_contenido">'+info.editorial_libro+'</div>');

          }
          if (info.pdf_extra== '') {
            $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
          }else {
            $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'"><img src="img/reacciones/pdf.png" alt=""> </a></div>');
          }
           $('.notidicacion_factor').html('   <div class="add_factor_correcto">'+
                '<img src="img/reacciones/garrapata.png" alt="">'+
                '<p>Guardado Correctamente</p>'+
              '</div>');

        }
        if (info.noticia == 'campo_vacio_digital') {
          $('.notidicacion_factor').html('  <div class="add_factor_no_correcto">'+
             '<img src="img/reacciones/cerca.png" alt="">'+
             '<p>Intentas agregar Tipo digital, llena todos los campos </p>'+
           '</div>');

        }
        if (info.noticia == 'enlace_no_valido') {
          $('.notidicacion_factor').html('  <div class="add_factor_no_correcto">'+
             '<img src="img/reacciones/cerca.png" alt="">'+
             '<p>Ingresa un Enlace de Mega Valido</p>'+
           '</div>');

        }
        if (info.noticia == 'enlace_corto') {
          $('.notidicacion_factor').html('  <div class="add_factor_no_correcto">'+
             '<img src="img/reacciones/cerca.png" alt="">'+
             '<p>Ingresa un Enlace de Mega Valido</p>'+
           '</div>');

        }




      }

    }

  });

}



function sendDatafactores_zapatos(){
   $('.notidicacion_factor').html('<div class="proceso">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_form_add_factor_zapatos')[0]);
  $.ajax({
    data: parametros,
    url:'jquery_producto/factores.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.alerteditt_registrarte').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
        var info = JSON.parse(response);
        if (info.noticia == 'inser_exito') {


                if (info.tipo_calzado== '') {
                  $('.tipo_calzado_int').html('<div class="tipo_tangible">Ninguno</div>');
                }else {
                  $('.tipo_calzado_int').html('<div class="tipo_digital">'+info.tipo_calzado+'</div>');
                }
                if (info.color_calzado== '') {
                  $('.color_calzado_int').html('<div class="mega_no">Ninguno</div>');
                }else {
                  $('.color_calzado_int').html('<div class="mega_si">'+info.color_calzado+'</div>');
                }
                if (info.talla_calzado== '') {
                  $('.talla_calzado_int').html('<div class="">Ninguno</div>');
                }else {
                   $('.talla_calzado_int').html('<div class="">'+info.talla_calzado+'</div>');
                }
                if (info.planta_calzado== '') {
                  $('.planta_calzado_int').html('<div class="sin_contenido">Ninguno</div>');
                }else {
                   $('.planta_calzado_int').html('<div class="con_contenido">'+info.planta_calzado+'</div>');

                }if (info.material_corte== '') {
                  $('.material_corte_int').html('<div class="sin_contenido">Ninguno</div>');
                }else {
                   $('.material_corte_int').html('<div class="con_contenido">'+info.material_corte+'</div>');
                }
                if (info.pdf_extra== '') {
                  $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
                }else {
                  $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'">   <img src="img/reacciones/pdf.png" alt=""> </a></div>');
                }

           $('.notidicacion_factor').html('   <div class="add_factor_correcto">'+
                '<img src="img/reacciones/garrapata.png" alt="">'+
                '<p>Guardado Correctamente</p>'+
              '</div>');

        }


        if (info.noticia == 'error_insertar') {
          $('.notidicacion_factor').html('  <div class="add_factor_no_correcto">'+
             '<img src="img/reacciones/cerca.png" alt="">'+
             '<p>Intente nuevamente</p>'+
           '</div>');

        }




      }

    }

  });

}


function sendDatafactores_ropa_sc_10(){
   $('.notidicacion_factor').html('<div class="proceso">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_form_add_factor_ropa_sc0')[0]);
  $.ajax({
    data: parametros,
    url:'jquery_producto/factores.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.alerteditt_registrarte').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
        var info = JSON.parse(response);
        if (info.noticia == 'inser_exito') {


          if (info.tipo_ropa== '') {
            $('.tipo_ropa_int').html('<div class="tipo_tangible">Ninguno</div>');
          }else {
            $('.tipo_ropa_int').html('<div class="tipo_digital">'+info.tipo_ropa+'</div>');
          }
          if (info.color_ropa== '') {
            $('.color_ropa_int').html('<div class="mega_no">Ninguno</div>');
          }else {
            $('.color_ropa_int').html('<div class="mega_si">'+info.color_ropa+'</div>');
          }
          if (info.envios== '') {
            $('.envios_int').html('<div class="">Ninguno</div>');
          }else {
             $('.envios_int').html('<div class="">'+info.envios+'</div>');
          }
          if (info.talla_ropa== '') {
            $('.talla_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.talla_ropa_int').html('<div class="con_contenido">'+info.talla_ropa+'</div>');

          }if (info.tela_ropa== '') {
            $('.tela_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.tela_ropa_int').html('<div class="con_contenido">'+info.tela_ropa+'</div>');
          }

          }if (info.genero_ropa== '') {
            $('.genero_ropa_int').html('<div class="sin_contenido">Ninguno</div>');
          }else {
             $('.genero_ropa_int').html('<div class="con_contenido">'+info.genero_ropa+'</div>');
          }

          if (info.pdf_extra== '') {
            $('.conte_pdf_extra').html(' <div class="archiv_extra_no">Ninguno</div>');
          }else {
            $('.conte_pdf_extra').html('<a download href="archivos/extras/'+info.pdf_extra+'">   <img src="img/reacciones/pdf.png" alt=""> </a></div>');
          }

           $('.notidicacion_factor').html('   <div class="add_factor_correcto">'+
                '<img src="img/reacciones/garrapata.png" alt="">'+
                '<p>Guardado Correctamente</p>'+
              '</div>');

        }


        if (info.noticia == 'error_insertar') {
          $('.notidicacion_factor').html('  <div class="add_factor_no_correcto">'+
             '<img src="img/reacciones/cerca.png" alt="">'+
             '<p>Intente nuevamente</p>'+
           '</div>');

        }





    }

  });

}
