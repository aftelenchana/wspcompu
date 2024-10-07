

$(document).ready(function(u){
setInterval(u,1000);
    $.ajax({
      url:'jquery/datos.php',
      type:'POST',
      async: true,

       success: function(response){
    console.log(response);
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.estado_cuenta').html('<table>'+
                     '<tr>'+
                       '<td>Estado:</td>'+
                       '<td>'+info.mi_leben+'</td>'+
                     '</tr>'+
                   '</table>');

           if (info.img_perfil != '') {
             $('.foto_ver').html('<img src="img/uploads/'+info.img_perfil+'" alt="">');

           }else {
                $('.foto_ver').html('<p>No existe imagen de perfil</p>');

           }


           if (info.img_logo != '') {
             $('.img_empresa_ver').html('<img src="img/uploads/'+info.img_logo+'" alt="'+info.img_logo+'">');

           }else {
                $('.img_empresa_ver').html('<p>No existe logo de empresa</p>');

           }





           $('.id_user').html(info.id);
           $('.nombres_datos').html(info.nombres);
           $('.apellidos').html(info.apellidos);
           $('.empresa').html(info.nombre_empresa);
           $('.ruc').html(info.ruc);
           $('.email').html(info.email);
           $('.celular').html(info.celular);
           $('.fecha').html(info.fecha);
           if (info.facebook == '') {
             $('.facebook').html('Ninguno');
           }else {
             $('.facebook').html('<a target="_blank" href="'+info.facebook+'"><img src="img/reacciones/facebook.png" alt="" width="30px"> </a>');
           }
           if (info.instagram == '') {
             $('.instagram').html('Ninguno');
           }else {
             $('.instagram').html('<a target="_blank" href="'+info.instagram+'"><img src="img/reacciones/instagram.png" alt="" width="30px"> </a>');
           }

           if (info.whatsapp == '') {
             $('.link_wsp').html('Ninguno');
           }else {
             $('.link_wsp').html('<a target="_blank" href="https://api.whatsapp.com/send?phone='+info.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;https://leben-ec.com/perfil-general.php?ide='+info.id+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>');
           }


           $('.direccion').html(info.direccion);
           $('.cuenta_bancaria').html(info.cuenta_bancaria);
           $('.banco_guayaquil_result').html(info.banco_guayaquil);
           $('.banco_produbanco_result').html(info.banco_produbanco);
           $('.banco_pacifico_result').html(info.banco_pacifico);
           $('.camara_comercio_result').html(info.camara_comercio_ambato);
           $('.mushuc_runa_result').html(info.mushuc_runa);
           $('.cuenta_paypal').html(info.cuenta_paypal);
           $('.fecha_nacimiento').html(info.fecha);



           $('.enlace_generador').html('<a href="img/qr/'+info.img_qr+'" download >Descargar mi Codigo QR </a>');


            $('.img_qr').html('<img src="img/qr/'+info.img_qr+'" alt="'+info.img_qr+'">');





            //Codificacion parfa ver o editar facebook

            if (info.plan != '') {
              $('.ver_plan').html('Ver mi Plan');

            }else {
              $('.none_plan').html('Nimguno');

            }
            if (info.posicion == '') {
              $('.result_direccion').html('Inactivo');
            }else {
                $('.result_direccion').html('Activo');

            }






            if (info.img_logo == '') {
            $('.ver_mi_logo').html('<h3 class="sin_logo">Usted no a ingresado ningun logo</h3>');

            }else {
              $('.ver_mi_logo').html('<img src="img/logos/'+info.img_logo+'" alt="">');

            }


            //Codificacion parfa ver o editar facebook

            if (info.facebook != '') {
              $('.add_facebook').html('Editar Facebook');

            }else {
              $('.add_facebook').html('Agregar Facebook');

            }
            //Codificacion parfa ver o editar Instagram
            if (info.instagram != '') {
              $('.add_instagram').html('Editar Instagram');

            }else {
              $('.add_instagram').html('Agregar Instagram');

            }
            //Codificacion parfa ver o editar whatsapp
            if (info.whatsapp != '') {
              $('.add_whatsapp').html('Editar Whatsapp');

            }else {
              $('.whatsapp').html('Ninguno');
              $('.add_whatsapp').html('Agregar Whatsapp');

            }
            //Codificacion para ver o editar el nombre de la empresa
            if (info.whatsapp != '') {
              $('.add_empresa').html('Editar  Empresa');

            }else {
              $('.add_empresa').html('Agregar  Empresa');

            }

            //Codificacion para ver o editar ruc
            if (info.ruc != '') {
              $('.add_ruc').html('Editar  Ruc');

            }else {
              $('.add_ruc').html('Agregar  Ruc');

            }

            //Codificacion para ver o editar Direccion
            if (info.ruc != '') {
              $('.add_direccion').html('Editar  Direccion');

            }else {
              $('.add_direccion').html('Agregar  Direccion');

            }
            //Codificacion para ver o editar Direccion
            if (info.cuenta_bancaria != '') {
              $('.add_cuenta_p').html('Editar Cuenta Bancaria');

            }else {
              $('.add_cuenta_p').html('Agregar  Cuenta Bancaria');

            }

            //Codificacion para ver o editar Paypal
            if (info.cuenta_paypal != '') {
              $('.add_cuenta_paypal').html('Editar Cuenta Paypal');

            }else {
              $('.add_cuenta_paypal').html('Agregar  Cuenta Paypal');

            }

         }

       },
       error:function(error){
         console.log(error);
         }

       });

});
