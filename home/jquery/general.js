
//Fecha de Nacimiento
$(document).ready(function(){
  $('.add_fecha_nacimiento').click(function(e){
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
           if (info.fecha == '') {
             $('.bodyModal_fecha_nacimiento').html('    <form class="" action="" method="post" name="add_form_fecha_nacimiento" id="add_form_fecha_nacimiento" onsubmit="event.preventDefault(); sendDataedit_fecha_nacimiento();">'+
             '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Fecha de Nacimiento</h3>'+
             '<div class="img_add_nombres img_modal">'+
             '<img  src="img/reacciones/calendario.png" alt="">'+
             '</div>'+
             '<div class="fecha_new">'+
             '</div>'+
             '<input type="date" name="fecha_nacimiento" value="" id="txteditt_fecha_nacimiento"  required>'+
             '<input type="hidden" name="action" value="add_fecha_nacimiento" required><br>'+
             '<div class="alert alerteditt_fecha_nacimiento">'+
             '</div>'+
             '<br>'+
             '<button type="submit" name="button" class="btn_new">Agregar Fecha de Nacimiento</button>'+
             '<a class="btn_ok closeModal" onclick="closeModaleditt_fecha_nacimiento();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
             '</form>');

           }else {
             $('.bodyModal_fecha_nacimiento').html('    <form class="" action="" method="post" name="add_form_fecha_nacimiento" id="add_form_fecha_nacimiento" onsubmit="event.preventDefault(); sendDataedit_fecha_nacimiento();">'+
             '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu Fecha de Nacimiento</h3>'+
             '<div class="img_add_nombres img_modal">'+
             '<img  src="img/reacciones/calendario.png" alt="">'+
             '</div>'+
             '<div class="fecha_new">'+
             '<p class="">Fecha Nacimiento:'+info.fecha+'</p>'+
             '</div>'+
             '<input type="date" name="fecha_nacimiento" value="" id="txteditt_fecha_nacimiento"  required>'+
             '<input type="hidden" name="action" value="add_fecha_nacimiento" required><br>'+
             '<div class="alert alerteditt_fecha_nacimiento">'+
             '</div>'+
             '<br>'+
             '<button type="submit" name="button" class="btn_new">Edita Fecha de Nacimniento</button>'+
             '<a class="btn_ok closeModal" onclick="closeModaleditt_fecha_nacimiento();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
             '</form>');

           }
         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_fecha_nacimiento').fadeIn();

  });

});
function sendDataedit_fecha_nacimiento(){
      $('.alerteditt_fecha_nacimiento').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_fecha_nacimiento').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_fecha_nacimiento').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
         }else {
           var info = JSON.parse(response);
           if (info.fecha_nacimiento != '') {
             $('.alerteditt_fecha_nacimiento').html('<p class="alerta_positiva">Fecha Cambiada Correctamente</p>')
             $('.fecha_new').html('<p class="">Fecha Cambiada:'+info.fecha_nacimiento+'</p>')
           }
           if (info.error == 'error_insertar_fecha') {
             $('.alerteditt_fecha_nacimiento').html('<p class="alerta_positiva">Error en servidor #454578</p>')

           }

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_fecha_nacimiento(){
  $('.alerteditt_fecha_nacimiento').html('');
  $('.modal_fecha_nacimiento').fadeOut();
}







//Contraseña
$(document).ready(function(){
  //modal para agregar el producto
  $('.edit_password').click(function(e){
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
           $('.bodyModal_pasword').html('<form class="" action="" method="post" name="add_form_password" id="add_form_password" onsubmit="event.preventDefault(); sendDataeditpasword();">'+
              '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu Contraseña  aqui</h3>'+
              '<div class="img_add_nombres img_modal">'+
                '<img  src="img/reacciones/contrasena.png" alt="">'+
              '</div>'+
              '<input class="correc_modal" type="password" name="actual_password" value="" id="txteditt_pasword" placeholder="Ingresa tu Contraseña Actual" required><br>'+
              '<input class="correc_modal" type="password" name="new_password" value="" id="txteditt_pasword" placeholder="Ingresa tu nueva Contraseña" required>'+
              '<input type="hidden" name="action" value="editt_password" required><br>'+
              '<div class="alert alerteditt_pasword">'+
              '</div>'+
              '<br>'+
              '<button type="submit" name="button" class="btn_new">Actualiza Contraseña</button>'+
              '<a class="btn_ok closeModal" onclick="closeModalpassword();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
            '</form>');

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_pasword').fadeIn();

  });

});
function sendDataeditpasword(){
  $('.alerteditt_pasword').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_password').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_pasword').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);

           if (info.resp_password == 'positiva') {
             $('.alerteditt_pasword').html('<p class="alerta_positiva">Contraseña Cambiada Correctamente</p>')

           }
           if (info.resp_password == 'error_insertar') {
             $('.alerteditt_pasword').html('<p class="alerta_negativa">Error al insertar la contraseña</p>')


           }
           if (info.resp_password == 'contrasena_incorrecta') {
             $('.alerteditt_pasword').html('<p class="alerta_negativa">Contraseña Ingresada Incorrecta</p>')


           }

           $('.esperando22').html('');




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModalpassword(){
  $('#txteditt_pasword').val('');
  $('.alerteditt_pasword').html('');
  $('.modal_pasword').fadeOut();
}





//para abrir el fomulario para ver el logo

$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_logo').click(function(e){
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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_logo').fadeIn();

  });

});

function closeModaleditt_ver_logo(){
  $('.modal_ver_logo').fadeOut();
}





//para abrir el fomulario para agregar logo

$(document).ready(function(){
  //modal para agregar el producto
  $('.add_logo').click(function(e){
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
           if (info.img_logo != '') {
             $('.bodyModal_add_logo').html('<form class="" action="scripts/agragar_logo.php" method="post" id="add_form_add_logo"  enctype="multipart/form-data" >'+
                    '<h3>  <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega el logo de tu empresa</h3>'+
                    '<div class="img_add_logo img_modal">'+
                      '<img  src="img/reacciones/new_logo.png" alt="">'+
                    '</div>'+
                    '<input type="file" name="foto" value=""  id="foto" required accept="image/png, .jpeg, .jpg" >'+
                    '<button type="submit" name="button" class="btn_new">Editar mi Logo</button>'+
                    '<a class="btn_ok closeModal" onclick="closeModaleditt_add_logo();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                  '</form>');

           }else {
             $('.bodyModal_add_logo').html('    <form class="" action="scripts/agragar_logo.php" method="post" id="add_form_add_logo"  enctype="multipart/form-data" >'+
                    '<h3>  <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega el logo de tu empresa</h3>'+
                    '<div class="img_add_logo img_modal">'+
                      '<img  src="img/reacciones/new_logo.png" alt="">'+
                    '</div>'+
                    '<input type="file" name="foto" value=""  id="foto" required accept="image/png, .jpeg, .jpg" >'+
                    '<button type="submit" name="button" class="btn_new">Agregar mi Logo</button>'+
                    '<a class="btn_ok closeModal" onclick="closeModaleditt_add_logo();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                  '</form>');

           }
         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_add_logo').fadeIn();

  });

});

function closeModaleditt_add_logo(){
  $('.modal_add_logo').fadeOut();
}




//Ver informacion del plan

$(document).ready(function(){
  //modal para agregar el producto
  $('.ver_plan').click(function(e){
    e.preventDefault();
    var usuario = $(this).attr('usuario');
    var action = 'infoplan';
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error'){
           var noti = JSON.parse(response);
           console.log(noti.sinplan);
           console.log(noti.plan);
           if (noti.plan != '') {
             console.log('Si tiene plan');
             $('.tipo_plan').html(noti.plan);
             $('.estado').html(noti.estado);
             $('.start_date').html(noti.fecha_inicio);
             console.log(noti.fecha_final);
             if (noti.fecha_final == null) {
               $('.start_finish').html('Sin Fecha Final');

             }else {

               $('.start_finish').html(noti.fecha_final);
             }

           }else {
              console.log('No tiene plan');
           }
         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_ver_plan').fadeIn();

  });

});

function closeModaleditt_ver_plan(){

  $('.modal_ver_plan').fadeOut();
}


//para abrir el fomulario para agregar plan

$(document).ready(function(){
  //modal para agregar el producto
  $('.add_plan').click(function(e){
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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_add_plan').fadeIn();

  });

});

function closeModaleditt_add_plan(){
  $('#txtedit_add_plan').val('');
  $('.alerteditt_add_plan').html('');
  $('.modal_add_plan').fadeOut();
}




///agregar nOMBRES
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_nombres').click(function(e){
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
           $('.bodyModal_nombres').html('<form class="" action="" method="post" name="add_form_nombres" id="add_form_nombres" onsubmit="event.preventDefault(); sendDataedit_nombres();" >'+
                  '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu nombre aqui</h3>'+
                  '<div class="img_add_nombres img_modal">'+
                    '<img  src="img/reacciones/identidad.png" alt="">'+
                  '</div>'+
                  '<div class="">'+
                  '<p class="nombre_usuario">Tu  Nombre es: '+info.nombres+'</p>'+
                  '</div>'+
                  '<input class="correc_modal" type="text" name="editt_nombre" value="" id="txteditt_nombre" placeholder="Ingresa tu nuevo nombre" required>'+
                  '<input class="correc_modal" type="hidden" name="action" value="editt_nombre" required><br>'+
                  '<div class="alert alerteditt_nombre">'+
                  '</div>'+
                  '<br>'+
                  '<button type="submit" name="button" class="btn_new">Agregar Nuevo Nombre</button>'+
                  '<a class="btn_ok closeModal" onclick="closeModaleditt_nombre();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');


         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_nombres').fadeIn();

  });

});
function sendDataedit_nombres(){
  $('.alerteditt_nombre').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_nombres').serialize(),

       success: function(response){
         console.log(response);
         if (response =='error') {
           $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'cuenta_activa_leben') {
             $('.alerteditt_nombre').html('<p class="alerta_positiva">Tu nombre no se puede editar por tu seguridad</p>')

           }
           if (info.noticia == 'editado_correctamente') {
             $('.nombres_datos').html(info.nombres);
             $('.nombre_usuario').html('Tu  nuevo  Nombre es: '+info.nombres+'');
             $('#txteditt_nombre').val('');
             $('.alerteditt_nombre').html('<p class="alerta_positiva">Tu nombre se edito Correctamente</p>')
           }
           if (info.noticia == 'Error al editar') {
             $('.alerteditt_nombre').html('<p class="alerta_positiva">Error en el servidor</p>')

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_nombre(){
  $('#txteditt_nombre').val('');
  $('.alerteditt_nombre').html('');
  $('.modal_nombres').fadeOut();
}




// Editar apellidos

$(document).ready(function(){
  //modal para agregar el producto
  $('.add_apellidos').click(function(e){
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
           $('.bodyModal_apellidos').html('    <form class="" action="" method="post" name="add_form_apellidos" id="add_form_apellidos" onsubmit="event.preventDefault(); sendDataedit_apellidos();" >'+
                  '<h3>  <p class="nombre_usuario"></p> <p class="apellidos_usuario" ></p> Edita tus Apellidos aqui</h3>'+
                  '<div class="img_add_nombres img_modal">'+
                    '<img  src="img/reacciones/identidad.png" alt="">'+
                  '</div>'+
                  '<div class="">'+
                  '<p class="apellido_usuario">Tu Apellido es: '+info.apellidos+' </p>'+
                  '</div>'+
                  '<input type="text" name="editt_apellido" value="" id="txteditt_apellido" placeholder="Ingresa tu nuevo Apellido" required>'+
                  '<input class="correc_modal" type="hidden" name="action" value="editt_Apellido" required><br>'+
                  '<div class="alert alerteditt_Apellido">'+
                  '</div>'+
                  '<br>'+
                  '<button type="submit" name="button" class="btn_new">Agregar Nuevo Apellido</button>'+
                  '<a class="btn_ok closeModal" onclick="closeModaleditt_Apellido();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_apellidos').fadeIn();

  });

});
function sendDataedit_apellidos(){
  $('.alerteditt_nombre').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_apellidos').serialize(),

       success: function(response){


         if (response =='error') {
           console.log(response);
           $('.alerteditt_Apellido').html('<p class="alerta_negativa">Error al Editar el Apellido</p>')
         }else {
           var info = JSON.parse(response);
           if (info.noticia == 'cuenta_activa_leben') {
                $('.alerteditt_Apellido').html('<p class="alerta_positiva">No puedes editar por tu seguridad</p>')

           }
           if (info.noticia == 'Editado_correctamente') {

             $('.apellido_usuario').html(info.editt_apellido);
             $('.apellidos').html('Tu Nuevo Apellido es: '+info.editt_apellido+'');
             $('#txteditt_apellido').val('');
             $('.alerteditt_Apellido').html('<p class="alerta_positiva">Tus Apellidos se edito Correctamente</p>')

           }
           if (info.noticia == 'Error al editar') {
             $('.alerteditt_Apellido').html('<p class="alerta_positiva">Error en el servidor</p>')
           }




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_Apellido(){
  $('#txteditt_apellido').val('');
  $('.alerteditt_Apellido').html('');
  $('.modal_apellidos').fadeOut();
}





//Editar Email
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_email').click(function(e){
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
           $('.bodyModal_email').html('    <form class="" action="" method="post" name="add_form_email" id="add_form_email" onsubmit="event.preventDefault(); sendDataedit_email();" >'+
                  '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu email aqui</h3>'+
                  '<div class="img_add_email img_modal">'+
                    '<img  src="img/reacciones/juegos.png" alt="">'+
                  '</div>'+
                  '<div class="">'+
                  '<p class="email_mew">Tu email  es:'+info.email+'</p>'+
                  '</div>'+
                  '<input class="correc_modal" type="email" name="editt_email" value="" id="txtedit_email" placeholder="Ingresa tu nuevo Email" required><br>'+
                  '<input class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu Contraseña" required>'+
                  '<input type="hidden" name="action" value="editt_email" required><br>'+
                  '<div class="alert alerteditt_email">'+
                  '</div>'+
                  '<br>'+
                  '<button type="submit" name="button" class="btn_new">Agregar Nuevo Email</button>'+
                  '<a class="btn_ok closeModal" onclick="closeModaleditt_email();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                '</form>');

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_email').fadeIn();

  });

});
function sendDataedit_email(){
  $('.alerteditt_email').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_email').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_email').html('<p class="alerta_negativa">Error al Editar el Email</p>');
         }else {
           var info = JSON.parse(response);
           console.log(response);

           if (info.email != '') {
             $('.alerteditt_email').html('<p class="alerta_positiva">Email cambiado Correctamnete.</p>');
             $('.email_es').html(info.email);
             $('.email_mew').html('Tu Nuevo email  es:'+info.email+'');

           }
           if (info.Error=='Error al insertar el Correo') {
             $('.alerteditt_email').html('<p class="alerta_negativa">Error al Insertar en el servidor #4589654.</p>');
           }
           if (info.Error=='password_incorrect') {
             $('.alerteditt_email').html('<p class="alerta_negativa">Contraseña Incorrecta</p>');
           }
           if (info.Error=='email_existente') {
            $('.alerteditt_email').html('<p class="alerta_negativa">El Email que intentas Ingresar ya se encuentra registrado, intenta con uno nuevo.</p>');
           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_email(){
  $('#txteditt_nombre').val('');
  $('.txtedit_email').html('');
  $('.modal_email').fadeOut();
}


//Agregar Nombre de la empresa

$(document).ready(function(){
  //modal para agregar el producto
  $('.add_empresa').click(function(e){
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
           if (info.nombre_empresa != '') {
             $('.bodyModal_nombre_empresa').html('<form class="" action="" method="post" name="add_form_nombre_empresa" id="add_form_nombre_empresa" onsubmit="event.preventDefault(); sendDataedit_nombre_empresa();" >'+
                '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita el nombre de tu Empresa aqui</h3>'+
                '<div class="img_add_nombre_empresa img_modal">'+
                  '<img  src="img/reacciones/rama.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="name_empresa_new">El nombre de tu empresa es '+info.nombre_empresa+'</p>'+
                '</div>'+
                '<input class="correc_modal" type="text" name="editt_nombre_empresa" value="" id="txtedit_nombre_empresa" placeholder="Ingresa el nombre de tu Empresa" required>'+
                '<input type="hidden" name="action" value="editt_nombre_empresa" required><br>'+
                '<div class="alert alerteditt_nombre_empresa">'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Edita el Nombre Empresarial</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_nombre_empresa();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');

           }else {
             $('.bodyModal_nombre_empresa').html('<form class="" action="" method="post" name="add_form_nombre_empresa" id="add_form_nombre_empresa" onsubmit="event.preventDefault(); sendDataedit_nombre_empresa();" >'+
                '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita el nombre de tu Empresa aqui</h3>'+
                '<div class="img_add_nombre_empresa img_modal">'+
                  '<img  src="img/reacciones/rama.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="name_empresa_new"></p>'+
                '</div>'+
                '<input class="correc_modal" type="text" name="editt_nombre_empresa" value="" id="txtedit_nombre_empresa" placeholder="Ingresa el nombre de tu Empresa" required>'+
                '<input type="hidden" name="action" value="editt_nombre_empresa" required><br>'+
                '<div class="alert alerteditt_nombre_empresa">'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Agregar Nombre Empresarial</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_nombre_empresa();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');

           }


         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_nombre_empresa').fadeIn();

  });

});
function sendDataedit_nombre_empresa(){
  $('.alerteditt_nombre_empresa').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_nombre_empresa').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_nombre_empresa').html('<p class="alerta_negativa">Error al Editar el Nombre</p>');
         }else {
           var info = JSON.parse(response);
           $('.nombre_empresa').html(info.nombre_empresa);
           $('.name_empresa_new').html('El nuevo nombre de tu empresa es '+info.nombre_empresa+'');
           $('#txtedit_nombre_empresa').val('');
           $('.alerteditt_nombre_empresa').html('<p class="alerta_positiva">Nombre de la empresa  Editado Correctamente</p>');
         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_nombre_empresa(){
  $('#txtedit_nombre_empresa').val('');
  $('.alerteditt_nombre_empresa').html('');
  $('.modal_nombre_empresa').fadeOut();
}


//Editar Ruc
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_ruc').click(function(e){
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
           if (info.ruc != '') {
             $('.bodyModal_add_ruc').html('<form class="" action="" method="post" name="add_form_add_ruc" id="add_form_add_ruc" onsubmit="event.preventDefault(); sendDataedit_add_ruc();" >'+
                '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Edita tu RUC aqui</h3>'+
                '<div class="img_add_add_ruc img_modal">'+
                  '<img  src="img/reacciones/ruc.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="">Tu Ruc  es:</p>'+
                  '<p class="ruc_new"></p>'+
                '</div>'+
                '<input class="correc_modal" type="text" name="editt_add_ruc" value="" id="txtedit_add_ruc" placeholder="Ingresa tu Ruc" required><br>'+
                '<input type="hidden" name="action" value="editt_add_ruc" required><br>'+
                '<div class="alert alerteditt_add_ruc">'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Editar Ruc</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_add_ruc();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');

           }else {
             $('.bodyModal_add_ruc').html('<form class="" action="" method="post" name="add_form_add_ruc" id="add_form_add_ruc" onsubmit="event.preventDefault(); sendDataedit_add_ruc();" >'+
                '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu RUC aqui</h3>'+
                '<div class="img_add_add_ruc img_modal">'+
                  '<img  src="img/reacciones/ruc.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="">Tu Ruc  es:</p>'+
                  '<p class="ruc_new"></p>'+
                '</div>'+
                '<input class="correc_modal" type="text" name="editt_add_ruc" value="" id="txtedit_add_ruc" placeholder="Ingresa tu Ruc" required><br>'+
                '<input type="hidden" name="action" value="editt_add_ruc" required><br>'+
                '<div class="alert alerteditt_add_ruc">'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Agregar Ruc</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_add_ruc();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');

           }


         }
       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_add_ruc').fadeIn();

  });

});
function sendDataedit_add_ruc(){
  $('.alerteditt_add_ruc').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_add_ruc').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_add_ruc').html('<p class="alerta_negativa">Error al Editar el Ruc</p>')
         }else {
           var info = JSON.parse(response);
           $('.ruc_new').html(info.ruc);
           $('#txtedit_add_ruc').val('');
           $('.alerteditt_add_ruc').html('<p class="alerta_positiva">Ruc  Editado Correctamente</p>')




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_add_ruc(){
  $('#txtedit_add_ruc').val('');
  $('.alerteditt_add_ruc').html('');
  $('.modal_add_ruc').fadeOut();
}


//Editar direccion
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_direccion').click(function(e){
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
           if (info.direccion != '') {
             $('.bodyModal_add_direccion').html('    <form class="" action="" method="post" name="add_form_add_direccion" id="add_form_add_direccion" onsubmit="event.preventDefault(); sendDataedit_add_direccion();" >'+
                    '<h3> <p class="nombre_usuario">'+info.nombres+'</p><p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tus Direccion aqui</h3>'+
                    '<div class="img_add_add_direccion img_modal">'+
                      '<img  src="img/reacciones/ubicacion.png" alt="">'+
                    '</div>'+
                    '<div class="">'+
                    '<p class="">Tu Direccion  es:</p>'+
                      '<p class="direccion_new"></p>'+
                    '</div>'+
                    '<input type="text" name="editt_add_direccion" value="" id="txtedit_add_direccion" placeholder="Ingresa tu Direccion" required>'+
                    '<input type="hidden" name="action" value="editt_add_direccion" required><br>'+
                    '<div class="alert alerteditt_add_direccion">'+
                      '<p class=""></p>'+
                    '</div>'+

                    '<br>'+
                    '<button type="submit" name="button" class="btn_new">Editar tu Direccion</button>'+
                    '<a class="btn_ok closeModal" onclick="closeModaleditt_add_direccion();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                  '</form>');

           }else {
             $('.bodyModal_add_direccion').html('    <form class="" action="" method="post" name="add_form_add_direccion" id="add_form_add_direccion" onsubmit="event.preventDefault(); sendDataedit_add_direccion();" >'+
                    '<h3> <p class="nombre_usuario">'+info.nombres+'</p><p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tus Direccion aqui</h3>'+
                    '<div class="img_add_add_direccion img_modal">'+
                      '<img  src="img/reacciones/ubicacion.png" alt="">'+
                    '</div>'+
                    '<div class="">'+
                    '<p class="">Tu Direccion  es:</p>'+
                      '<p class="direccion_new"></p>'+
                    '</div>'+
                    '<input type="text" name="editt_add_direccion" value="" id="txtedit_add_direccion" placeholder="Ingresa tu Direccion" required>'+
                    '<input type="hidden" name="action" value="editt_add_direccion" required><br>'+
                    '<div class="alert alerteditt_add_direccion">'+
                      '<p class=""></p>'+
                    '</div>'+

                    '<br>'+
                    '<button type="submit" name="button" class="btn_new">Agregar tu Direccion</button>'+
                    '<a class="btn_ok closeModal" onclick="closeModaleditt_add_direccion();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                  '</form>');

           }

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_add_direccion').fadeIn();

  });

});
function sendDataedit_add_direccion(){
    $('.alerteditt_add_direccion').html('');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_add_direccion').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_add_direccion').html('<p class="alerta_negativa">Error al Editar el Ruc</p>')
         }else {
           var info = JSON.parse(response);
           $('.direccion_new').html(info.direccion);
           $('#txtedit_add_ruc').val('');
           $('.alerteditt_add_direccion').html('<p class="alerta_positiva">Direccion  Editada Correctamente</p>')




         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_add_direccion(){
  $('#txtedit_add_direccion').val('');
  $('.alerteditt_add_direccion').html('');
  $('.modal_add_direccion').fadeOut();
}






//Editar Cuenta Paypal
$(document).ready(function(){
  //modal para agregar el producto
  $('.add_cuenta_paypal').click(function(e){
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
           if (info.cuenta_paypal != '') {
           $('.bodyModal_add_paypal').html('<form class="" action="" method="post" name="add_form_add_paypal" id="add_form_add_paypal" onsubmit="event.preventDefault(); sendDataedit_add_paypal();" >'+
                '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu Paypal aqui</h3>'+
                '<div class="img_add_add_paypal img_modal">'+
                  '<img  src="img/reacciones/paypal.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="">Tu Paypal es:</p>'+
                  '<p class="pay_pal"></p>'+
                '</div>'+
                '<input type="email" name="editt_add_paypal" value="" id="txtedit_add_paypal" placeholder="Ingresa tu Paypal" required>'+
                '<input type="password" name="password" value="" placeholder="Ingresa tu Contaseña" required>'+
                '<input type="hidden" name="action" value="editt_add_paypal" required><br>'+
                '<div class="esperando22">'+
                '</div>'+
                '<div class="alert alerteditt_add_paypal">'+
                  '<p class=""></p>'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Editar Cuenta Paypal</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_add_paypal();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');


         }else {
           $('.bodyModal_add_paypal').html('<form class="" action="" method="post" name="add_form_add_paypal" id="add_form_add_paypal" onsubmit="event.preventDefault(); sendDataedit_add_paypal();" >'+
                '<h3><p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Edita tu Paypal aqui</h3>'+
                '<div class="img_add_add_paypal img_modal">'+
                  '<img  src="img/reacciones/paypal.png" alt="">'+
                '</div>'+
                '<div class="">'+
                '<p class="">Tu Paypal es:</p>'+
                  '<p class="pay_pal"></p>'+
                '</div>'+
                '<input type="email" name="editt_add_paypal" value="" id="txtedit_add_paypal" placeholder="Ingresa tu Paypal" required>'+
                '<input type="password" name="password" value="" placeholder="Ingresa tu Contaseña" required>'+
                '<input type="hidden" name="action" value="editt_add_paypal" required><br>'+
                '<div class="esperando22">'+
                '</div>'+
                '<div class="alert alerteditt_add_paypal">'+
                  '<p class=""></p>'+
                '</div>'+
                '<br>'+
                '<button type="submit" name="button" class="btn_new">Agrega Paypal a mi cuenta</button>'+
                '<a class="btn_ok closeModal" onclick="closeModaleditt_add_paypal();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
              '</form>');

         }

         }


       },
       error:function(error){
         console.log(error);
         }

       });



    $('.modal_add_paypal').fadeIn();

  });

});
function sendDataedit_add_paypal(){
     $('.alerteditt_add_paypal').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_add_paypal').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_add_paypal').html('<p class="alerta_negativa">Error al Editar el Paypal</p>')
         }else {
           var info = JSON.parse(response);
           $('.pay_pal').html(info.pay_pal);
                              if (info.Error != '' && info.pay_pal == undefined) {
                                $('.alerteditt_add_paypal').html('<p class="alerta_negativa">Error al Agregar Paypal,'+info.Error+'</p>')
                              }
                              if (info.pay_pal != '' && info.Error == undefined) {
                                $('.link_banca_p').html(info.banca_p);

                              }
                              $('.esperando22').html('');

         }
       },
       error:function(error){
         console.log(error);
         }

       });

}
function closeModaleditt_add_paypal(){
  $('#txtedit_add_direccion').val('');
  $('.alerteditt_add_paypal').html('');
  $('.modal_add_paypal').fadeOut();
}



//Agregar o Editar Facebook


$(document).ready(function(){
  //modal para agregar el producto
  $('.add_facebook').click(function(e){
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
           if (info.facebook != '') {
             $('.bodyModal_fb').html('<form class="" action="" method="post" name="add_form_facebook" id="add_form_facebook" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                      '<h3>Agrega tu Facebook a nuestro sitio</h3>'+
                                      '<div class="img_add_facebook img_modal">'+
                                        '<img  src="img/reacciones/facebook.png" alt="">'+
                                      '</div>'+
                                      '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                      '<div class="">'+
                                      '<p class="">Tu  facebook es:</p>'+
                                        '<p class="link_fb newfacebook">'+info.facebook+'</p>'+
                                      '</div>'+
                                      '<input type="text" name="facebook" value="" id="txtfacebook" placeholder="Ingresa el enlace de tu Facebook" required>'+
                                      '<input type="hidden" name="action" value="addFacebook" required><br>'+
                                      '<div class="alert alert_edit_facebook">'+
                                        '<p class=""></p>'+
                                      '</div><br>'+
                                      '<button type="submit" name="button" class="btn_new">Editar Facebook</button>'+
                                      '<a class="btn_ok closeModal" onclick="closeModal();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                    '</form>');






           }else {
             $('.bodyModal_fb').html('<form class="" action="" method="post" name="add_form_facebook" id="add_form_facebook" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                      '<h3>Agrega tu Facebook a nuestro sitio</h3>'+
                                      '<div class="img_add_facebook">'+
                                        '<img  src="img/reacciones/facebook.png" alt="">'+
                                      '</div>'+
                                      '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                      '<div class="">'+
                                      '<p class="">Tu  facebook es:</p>'+
                                        '<p class="link_fb newfacebook">'+info.facebook+'</p>'+
                                      '</div>'+
                                      '<input type="text" name="facebook" value="" id="txtfacebook" placeholder="Ingresa el enlace de tu Facebook" required>'+
                                      '<input type="hidden" name="action" value="addFacebook" required><br>'+
                                      '<div class="alert alert_edit_facebook">'+
                                        '<p class=""></p>'+
                                      '</div><br>'+
                                      '<button type="submit" name="button" class="btn_new">Agregar Facebook</button>'+
                                      '<a class="btn_ok closeModal" onclick="closeModal();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                    '</form>');




           }



           //$('.nombre_usuario').html(info.nombres);
           //$('.link_fb').html(info.facebook);


         }

       },
       error:function(error){
         console.log(error);
         }

       });


    $('.modal_facebook').fadeIn();

  });

});

function sendDataProduct(){
  $('.alert_edit_facebook').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');

    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_facebook').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alert_edit_facebook').html('<p class="alerta_negativa">Error al Agregar Facebook</p>');
         }else {
           var info = JSON.parse(response);
           if (info.Error != '' && info.facebook == undefined) {
             $('.alert_edit_facebook').html('<p class="alerta_negativa">Error al Agregar Facebook,'+info.Error+'</p>');


           }
           if (info.facebook != '' && info.Error == undefined) {
             $('.newfacebook').html('<a target="_blank" href="'+info.facebook+'"> <img src="img/reacciones/facebook.png" alt="" width="30px"> </a>');
             $('.alert_edit_facebook').html('<p class="alerta_positiva">Facebook  Agregado Correctamente</p>');


           }
         }
       },
       error:function(error){
         console.log(error);
         }

       });

}

function closeModal(){
  $('.alertAddProduct').html('');
  $('#txtfacebook').val('');
  $('.modal_facebook').fadeOut();
}
                                                      //Agregar o Editar whatsapp
                                                      $(document).ready(function(){
                                                        //modal para agregar el producto
                                                        $('.add_whatsapp').click(function(e){
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

                                                                 if (info.whatsapp != '') {
                                                                   $('.bodyModal_whatsapp').html('<form class="" action="" method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();" >'+
                                                                      '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Plan a tu Whatsapp tu sitio</h3>'+
                                                                      '<div class="img_add_whatsapp img_modal">'+
                                                                        '<img  src="img/reacciones/whatsapp.png" alt="">'+
                                                                      '</div>'+

                                                                      '<div class="">'+
                                                                      '<p class="">Tu Whhatsaap es:</p>'+
                                                                        '<p class="link_wsp whatsapp"> '+info.whatsapp+' </p>'+
                                                                      '</div>'+
                                                                      '<input type="text" name="whatsapp" value="" id="txtwhatsapp" placeholder="Ingresa el enlace de tu Facebook" required>'+
                                                                      '<input type="hidden" name="action" value="addwhatsapp" required><br>'+
                                                                      '<div class="alert alertwhatsapp">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<div class="alert alertwhatsappposi">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<div class="alert alertwhatsappnega">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<br>'+
                                                                      '<button type="submit" name="button" class="btn_new">Editar Whatsapp</button>'+
                                                                      '<a class="btn_ok closeModal" onclick="closeModalwhatsapp();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                                                    '</form>');


                                                                 }else {
                                                                   $('.bodyModal_whatsapp').html('<form class="" action="" method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();" >'+
                                                                      '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Plan a tu Whatsapp tu sitio</h3>'+
                                                                      '<div class="img_add_whatsapp img_modal">'+
                                                                        '<img  src="img/reacciones/whatsapp.png" alt="">'+
                                                                      '</div>'+

                                                                      '<div class="">'+
                                                                      '<p class="">Tu Whhatsaap es:</p>'+
                                                                        '<p class="link_wsp whatsapp"> '+info.whatsapp+' </p>'+
                                                                      '</div>'+
                                                                      '<input type="text" name="whatsapp" value="" id="txtwhatsapp" placeholder="Ingresa el enlace de tu Facebook" required>'+
                                                                      '<input type="hidden" name="action" value="addwhatsapp" required><br>'+
                                                                      '<div class="alert alertwhatsapp">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<div class="alert alertwhatsappposi">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<div class="alert alertwhatsappnega">'+
                                                                        '<p class=""></p>'+
                                                                      '</div>'+
                                                                      '<br>'+
                                                                      '<button type="submit" name="button" class="btn_new">Agregar Whatsapp</button>'+
                                                                      '<a class="btn_ok closeModal" onclick="closeModalwhatsapp();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                                                    '</form>');



                                                                 }




                                                               }


                                                             },
                                                             error:function(error){
                                                               console.log(error);
                                                               }

                                                             });


                                                          $('.modal_whatsapp').fadeIn();

                                                        });

                                                      });

                                                      function sendDataWhatsapp(){
                                                          $('.alertwhatsapp').html('');
                                                          $.ajax({
                                                            url:'jquery/general.php',
                                                            type:'POST',
                                                            async: true,
                                                            data: $('#add_form_whatsapp').serialize(),

                                                             success: function(response){
                                                               if (response =='error') {
                                                                 $('.alertwhatsapp').html('<p class="alerta_negativa">Error al Agregar Whatsapp</p>')
                                                               }else {
                                                                 var infor = JSON.parse(response);

                                                                if (infor.Error != '' && infor.whatsapp == undefined) {
                                                                  $('.alertwhatsapp').html('<p class="alerta_negativa">Error al Agregar Whatsapp,'+infor.Error+'</p>')


                                                                }
                                                                if (infor.whatsapp != '' && infor.Error == undefined) {
                                                                  $('.link_wsp').html('<a target="_blank" href="https://api.whatsapp.com/send?phone='+infor.whatsapp+'&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Leben&nbsp;https://guibis.com/perfil-general.php?ide='+infor.id+'"> <img src="img/reacciones/whatsapp.png" alt="" width="30px"> </a>');
                                                                  $('.alertwhatsapp').html('<p class="alerta_positiva">Whatsapp Agregado Correctamente</p>');


                                                                }

                                                               }


                                                             },
                                                             error:function(error){
                                                               console.log(error);
                                                               }

                                                             });

                                                      }

                                                      function closeModalwhatsapp(){
                                                        $('#txtwhatsapp').val('');
                                                        $('.alertwhatsapp').html('');
                                                        $('.modal_whatsapp').fadeOut();
                                                      }


                //Agregar o Editar instagram
                $(document).ready(function(){
                  //modal para agregar el producto
                  $('.add_instagram').click(function(e){
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



                           if (info.instagram != '') {
                             $('.bodyModal_instagram').html('<form class="" action="" method="post" name="add_form_instagram" id="add_form_instagram" onsubmit="event.preventDefault(); sendDatainstagram();" >'+
                             ' <h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Instagram a tu Cuenta</h3>'+
                               ' <div class="img_add_instagram img_modal">'+
                                  '<img  src="img/reacciones/juegos.png" alt="">'+
                                '</div>'+
                                '<div class="">'+
                                '<p class="">Tu instagram es:</p>'+
                                  '<p class="link_instagram instagram">'+info.instagram+'</p>'+
                                '</div>'+
                                '<input type="text" name="instagram" value="" id="txtinstagram" placeholder="Ingresa el enlace de tu instagram" required>'+
                                '<input type="hidden" name="action" value="addinstagram" required><br>'+
                                '<div class="alert alertinstagram">'+
                                  '<p class=""></p>'+
                                '</div>'+

                                '<br>'+
                                '<button type="submit" name="button" class="btn_new">Agregar Instagram</button>'+
                                '<a class="btn_ok closeModal" onclick="closeModalinstagram();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                              '</form>');

                           }else {
                             $('.bodyModal_instagram').html('<form class="" action="" method="post" name="add_form_instagram" id="add_form_instagram" onsubmit="event.preventDefault(); sendDatainstagram();" >'+
                               ' <h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Instagram a tu Cuenta</h3>'+
                               ' <div class="img_add_instagram img_modal">'+
                                  '<img  src="img/reacciones/juegos.png" alt="">'+
                                '</div>'+
                                '<div class="">'+
                                '<p class="">Agrega Instagram a tu Cuenta:</p>'+
                                  '<p class="link_instagram"></p>'+
                                '</div>'+
                                '<input type="text" name="instagram" value="" id="txtinstagram" placeholder="Ingresa el enlace de tu instagram" required>'+
                                '<input type="hidden" name="action" value="addinstagram" required><br>'+
                                '<div class="alert alertinstagram">'+
                                  '<p class=""></p>'+
                                '</div>'+

                                '<br>'+
                                '<button type="submit" name="button" class="btn_new">Agregar Instagram</button>'+
                                '<a class="btn_ok closeModal" onclick="closeModalinstagram();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                              '</form>');

                           }






                         }


                       },
                       error:function(error){
                         console.log(error);
                         }

                       });



                    $('.modal_instagram').fadeIn();

                  });

                });
                function sendDatainstagram(){
                    $('.alertinstagram').html('');
                    $.ajax({
                      url:'jquery/general.php',
                      type:'POST',
                      async: true,
                      data: $('#add_form_instagram').serialize(),

                       success: function(response){
                         if (response =='error') {
                           $('.alertinstagram').html('<p class="alerta_negativa">Error al Agregar instagram</p>')
                         }else {
                           var info = JSON.parse(response);
                           if (info.Error != '' && info.instagram == undefined) {
                              $('.alertinstagram').html('<p class="alerta_negativa">Error al Agregar Instagram,'+info.Error+'</p>')


                           }
                           if (info.instagram != '' && info.Error == undefined) {
                             $('.instagram').html('<a target="_blank" href="'+info.instagram+'"><img src="img/reacciones/instagram.png" alt="" width="30px"> </a>');
                             $('.link_instagram').html(info.instagram);
                             $('.alertinstagram').html('<p class="alerta_positiva">Instagram Agregado Correctamente</p>');


                           }




                         }
                       },
                       error:function(error){
                         console.log(error);
                         }

                       });

                }
                function closeModalinstagram(){
                  $('#txtwhatsapp').val('');
                  $('.alertinstagram').html('');
                  $('.modal_instagram').fadeOut();
                }





                                                                                                 //Agregar o Editar Telefono
                                                                                                 $(document).ready(function(){
                                                                                                   //modal para agregar el producto
                                                                                                   $('.add_telefono').click(function(e){
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

                                                                                                            if (info.celular != '') {
                                                                                                              $('.bodyModal_telefono').html('     <form class="" action="" method="post" name="add_form_telefono" id="add_form_telefono" onsubmit="event.preventDefault(); sendDatatelefono();" >'+
                                                                                                                      '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Telefono a tu sitio</h3>'+
                                                                                                                      '<div class="img_add_telefono img_modal">'+
                                                                                                                        '<img  src="img/reacciones/telefonocasa.png" alt="">'+
                                                                                                                      '</div>'+

                                                                                                                      '<div class="">'+
                                                                                                                      '<p class="">Tu Telefono es:</p>'+
                                                                                                                        '<p class="telefono"></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<input type="text" name="telefono" value="" id="txttelefono" placeholder="Ingresa tu numero de Teleono Local" required>'+
                                                                                                                      '<input type="hidden" name="action" value="addtelefono" required><br>'+
                                                                                                                      '<div class="alert alerttelefono">'+
                                                                                                                        '<p class=""></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<div class="alert alerttelefono">'+
                                                                                                                        '<p class=""></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<br>'+
                                                                                                                      '<button type="submit" name="button" class="btn_new">Editar Telefono</button>'+
                                                                                                                      '<a class="btn_ok closeModal" onclick="closeModaltelefono();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                                                                                                    '</form>');


                                                                                                            }else {
                                                                                                              $('.bodyModal_telefono').html('     <form class="" action="" method="post" name="add_form_telefono" id="add_form_telefono" onsubmit="event.preventDefault(); sendDatatelefono();" >'+
                                                                                                                      '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" >'+info.apellidos+'</p> Agrega tu Telefono a tu sitio</h3>'+
                                                                                                                      '<div class="img_add_telefono img_modal">'+
                                                                                                                        '<img  src="img/reacciones/telefonocasa.png" alt="">'+
                                                                                                                      '</div>'+

                                                                                                                      '<div class="">'+
                                                                                                                      '<p class="">Tu Telefono es:</p>'+
                                                                                                                        '<p class="telefono"></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<input type="text" name="telefono" value="" id="txttelefono" placeholder="Ingresa tu numero de Teleono Local" required>'+
                                                                                                                      '<input type="hidden" name="action" value="addtelefono" required><br>'+
                                                                                                                      '<div class="alert alerttelefono">'+
                                                                                                                        '<p class=""></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<div class="alert alerttelefono">'+
                                                                                                                        '<p class=""></p>'+
                                                                                                                      '</div>'+
                                                                                                                      '<br>'+
                                                                                                                      '<button type="submit" name="button" class="btn_new">Agregar Telefono</button>'+
                                                                                                                      '<a class="btn_ok closeModal" onclick="closeModaltelefono();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                                                                                                                    '</form>');



                                                                                                            }

                                                                                                            $('.nombre_usuario').html(info.nombres);
                                                                                                            $('.apellidos_usuario').html(info.apellidos);



                                                                                                          }


                                                                                                        },
                                                                                                        error:function(error){
                                                                                                          console.log(error);
                                                                                                          }

                                                                                                        });


                                                                                                     $('.modal_telefono').fadeIn();

                                                                                                   });

                                                                                                 });

                                                                                                 function sendDatatelefono(){
                                                                                                     $('.alerttelefono').html('');
                                                                                                     $.ajax({
                                                                                                       url:'jquery/general.php',
                                                                                                       type:'POST',
                                                                                                       async: true,
                                                                                                       data: $('#add_form_telefono').serialize(),

                                                                                                        success: function(response){
                                                                                                          if (response =='error') {
                                                                                                            $('.alerttelefono').html('<p class="alerta_negativa">Error al Agregar el Telefono</p>')
                                                                                                          }else {
                                                                                                            var infor = JSON.parse(response);
                                                                                                           if (infor.Error != '' && infor.telefono == undefined) {
                                                                                                             $('.alerttelefono').html('<p class="alerta_negativa">Error al Agregar el Telefono,'+infor.Error+'</p>')
                                                                                                           }
                                                                                                           if (infor.telefono != '' && infor.Error == undefined) {
                                                                                                             $('.telefono').html(infor.telefono);
                                                                                                             $('.alerttelefono').html('<p class="alerta_positiva">Telefono Agregado Correctamente</p>');


                                                                                                           }

                                                                                                          }


                                                                                                        },
                                                                                                        error:function(error){
                                                                                                          console.log(error);
                                                                                                          }

                                                                                                        });

                                                                                                 }

                                                                                                 function closeModaltelefono(){
                                                                                                   $('#txttelefono').val('');
                                                                                                   $('.alerttelefono').html('');
                                                                                                   $('.modal_telefono').fadeOut();
                                                                                                 }

        // Agregar o Editar banca  Cuenta bancaria Pichincha
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_cuenta_p').click(function(e){
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
                   if (info.cuenta_bancaria != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_p" id="add_form_banca_p" onsubmit="event.preventDefault(); sendDatabanca_p();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Pichincha</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/logopichincha.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta Bancaria  es:</p>'+
                              '<p class="link_banca_p">'+info.cuenta_bancaria+'</p>'+
                            '</div>'+
                            '<input style="display: block;width: 50%;margin: 0 auto;padding: 3px;text-align: center;" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta bancaria" required><br>'+
                            '<input style="display: block;width: 50%;margin: 0 auto;padding: 3px;text-align: center;" type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="addbanca_p" required><br>'+
                            '<div class="esperando22">'+
                            '</div>'+
                            '<div class="alert alertbanca_p">'+
                              '<p class=""></p>'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar Cuenta Bancaria</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_p" id="add_form_banca_p" onsubmit="event.preventDefault(); sendDatabanca_p();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Pichincha</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/logopichincha.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta Bancaria  es: </p>'+
                              '<p class="link_banca_p">Ninguna</p>'+
                            '</div>'+
                            '<input style="display: block;width: 50%;margin: 0 auto;padding: 3px;text-align: center;" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta bancaria" required><br>'+
                            '<input style="display: block;width: 50%;margin: 0 auto;padding: 3px;text-align: center;" type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="addbanca_p" required><br>'+
                            '<div class="alert alertbanca_p">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar Cuenta Bancaria</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                   $('.apellidos_usuario').html(info.apellidos);

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendDatabanca_p(){
         $('.alertbanca_p').html('<img src="img/reacciones/reloj.png" alt="" width="50px;"> En Proceso')
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_p').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_p').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.link_banca_p').html(info.banca_p);
                  $('.alertbanca_p').html('<p class="alerta_positiva">Banca Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_p').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')


                   }
                   if (info.noticia == 'password_incorrect') {
                       $('.alertbanca_p').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }


                   $('.esperando22').html('');


                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }




        // Agregar o Editar banca  Cuenta bancaria Guayaquil
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_guayaquil').click(function(e){
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
                   if (info.banco_guayaquil != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_guayaquil" id="add_form_banca_guayaquil" onsubmit="event.preventDefault(); sendDatabanca_guayaquil();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Guayaquil</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta del Banco Guayaquil  es:</p>'+
                              '<p class="banco_guayaquil_result">'+info.banco_guayaquil+'</p>'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Guayaquil" required><br>'+
                            '<input class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_guayaquil" required><br>'+
                            '<div class="alert alertbanca_guayaquil">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar Banco Guayaquil</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_guayaquil" id="add_form_banca_guayaquil" onsubmit="event.preventDefault(); sendDatabanca_guayaquil();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Guayaquil</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Guayaquil" required><br>'+
                            '<input class="correc_modal"  type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input  type="hidden" name="action" value="add_banco_guayaquil" required><br>'+
                            '<div class="alert alertbanca_guayaquil">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar Banco Guayaquil</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendDatabanca_guayaquil(){
          $('.alertbanca_guayaquil').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');

            $('.alertbanca_p').html('');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_guayaquil').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_guayaquil').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.banco_guayaquil_result').html(info.banca_p);
                  $('.alertbanca_guayaquil').html('<p class="alerta_positiva">Banco Guayaquil Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_guayaquil').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')
                   }
                   if (info.noticia == 'password_incorrect') {
                     $('.alertbanca_guayaquil').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }



                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }





        // Agregar o Editar banca  Cuenta bancaria produbanco
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_produbanco').click(function(e){
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
                   if (info.banco_produbanco != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_produbanco" id="add_form_banca_produbanco" onsubmit="event.preventDefault(); sendDatabanca_produbanco();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Produbanco</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta del Banco Produbanco  es:</p>'+
                              '<p class="banco_produbanco_result">'+info.banco_produbanco+'</p>'+
                            '</div>'+
                            '<input  class="correc_modal" type="number" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Produbanco" required><br>'+
                            '<input  class="correc_modal" type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_produbanco" required><br>'+
                            '<div class="alert alertbanca_produbanco">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar Banco Produbanco</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_produbanco" id="add_form_banca_produbanco" onsubmit="event.preventDefault(); sendDatabanca_produbanco();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Produbanco</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<input class="correc_modal" type="number" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Produbanco" required><br>'+
                            '<input class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_produbanco" required><br>'+
                            '<div class="alert alertbanca_produbanco">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar Banco Produbanco</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendDatabanca_produbanco(){
          $('.alertbanca_produbanco').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_produbanco').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_produbanco').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.banco_produbanco_result').html(info.banca_p);
                  $('.alertbanca_produbanco').html('<p class="alerta_positiva">Banco Produbanco Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_produbanco').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')
                   }
                   if (info.noticia == 'password_incorrect') {
                     $('.alertbanca_produbanco').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }



                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }



        // Agregar o Editar banca  Cuenta bancaria pacifico
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_pacifico').click(function(e){
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
                   if (info.banco_pacifico != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_pacifico" id="add_form_banca_pacifico" onsubmit="event.preventDefault(); sendDatabanca_pacifico();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Pacifico</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta del Banco Pacifico  es:</p>'+
                              '<p class="banco_pacifico_result">'+info.banco_pacifico+'</p>'+
                            '</div>'+
                            '<input  class="correc_modal"  type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Pacifico" required> <br>'+
                            '<input  class="correc_modal"  type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_pacifico" required><br>'+
                            '<div class="alert alertbanca_pacifico">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar Banco Pacifico</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_pacifico" id="add_form_banca_pacifico" onsubmit="event.preventDefault(); sendDatabanca_pacifico();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Pacifico</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<input  class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Pacifico" required><br>'+
                            '<input  class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input   type="hidden" name="action" value="add_banco_pacifico" required><br>'+
                            '<div class="alert alertbanca_pacifico">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar Banco Pacifico</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendDatabanca_pacifico(){
          $('.alertbanca_pacifico').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_pacifico').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_pacifico').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.banco_pacifico_result').html(info.banca_p);
                  $('.alertbanca_pacifico').html('<p class="alerta_positiva">Banco Pacifico Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_pacifico').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')
                   }
                   if (info.noticia == 'password_incorrect') {
                     $('.alertbanca_pacifico').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }



                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }



        // Agregar o Editar banca  Cuenta bancaria CCA
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_cca').click(function(e){
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
                   if (info.camara_comercio_ambato != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_camara_comercio_ambato" id="add_form_camara_comercio_ambato" onsubmit="event.preventDefault(); sendData_cca();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Camara de Comercio de Ambato</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="new_banca">Tu Cuenta Camara de Comercio de Ambato es  es:</p>'+
                              '<p class="camara_comercio_result">'+info.camara_comercio_ambato+'</p>'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de CCA" required><br>'+
                            '<input class="correc_modal" type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input  type="hidden" name="action" value="add_cca" required><br>'+
                            '<div class="alert alertbanca_cca">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar CCA</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_camara_comercio_ambato" id="add_form_camara_comercio_ambato" onsubmit="event.preventDefault(); sendData_cca();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Camara de Comercio de Ambato</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de CCA" required><br>'+
                            '<input class="correc_modal" type="password" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_cca" required><br>'+
                            '<div class="alert alertbanca_cca">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar CCA</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendData_cca(){
          $('.alertbanca_cca').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_camara_comercio_ambato').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_guayaquil').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.camara_comercio_result').html(info.banca_p);
                  $('.alertbanca_cca').html('<p class="alerta_positiva">Banco CCA Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_cca').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')
                   }
                   if (info.noticia == 'password_incorrect') {
                     $('.alertbanca_cca').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }



                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }




        // Agregar o Editar banca  Cuenta bancaria MUSHUC runa
        $(document).ready(function(){
          //modal para agregar el producto
          $('.add_mushuc_runa').click(function(e){
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
                   if (info.mushuc_runa != '') {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_Mushuc" id="add_form_banca_Mushuc" onsubmit="event.preventDefault(); sendDatabanca_mushuc();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Mushuc Runa</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<div class="">'+
                            '<p class="">Tu Cuenta del Banco Mushuc Runa es:</p>'+
                              '<p class="mushuc_runa_result">'+info.mushuc_runa+'</p>'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Mushuc Runa" required><br>'+
                            '<input class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_mushuc" required><br>'+
                            '<div class="alert alertbanca_Mushuc">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Editar Banco Mushuc Runa</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');


                   }else {
                     $('.bodyModal_banca_p').html('<form class="" action="" method="post" name="add_form_banca_Mushuc" id="add_form_banca_Mushuc" onsubmit="event.preventDefault(); sendDatabanca_mushuc();" >'+
                            '<h3> <p class="nombre_usuario">'+info.nombres+'</p> <p class="apellidos_usuario" > '+info.apellidos+'</p> Agrega tu Cuenta Bancaria Mushuc Runa</h3>'+
                            '<div class="img_add_banca_p img_modal">'+
                              '<img  src="img/reacciones/b_guayaquil.jpg" alt="">'+
                            '</div>'+
                            '<input class="correc_modal" type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta de Mushuc Runa" required><br>'+
                            '<input class="correc_modal" type="text" name="password" value="" placeholder="Ingresa tu contraseña">'+
                            '<input type="hidden" name="action" value="add_banco_mushuc" required><br>'+
                            '<div class="alert alertbanca_Mushuc">'+
                            '</div>'+
                            '<br>'+
                            '<button type="submit" name="button" class="btn_new">Agregar Banco Mushuc Runa</button>'+
                            '<a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>'+
                          '</form>');

                   }

                 }


               },
               error:function(error){
                 console.log(error);
                 }

               });

            $('.modal_banca_p').fadeIn();

          });

        });
        function sendDatabanca_mushuc(){
          $('.alertbanca_Mushuc').html('<img src="img/reacciones/reloj.png" alt="" width="50px;">');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_Mushuc').serialize(),

               success: function(response){
                 console.log(response);
                 if (response =='error') {
                   $('.alertbanca_guayaquil').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>');
                 }else {
                   var info = JSON.parse(response);
                   if (info.banca_p != '') {
                     $('.mushuc_runa_result').html(info.banca_p);
                  $('.alertbanca_Mushuc').html('<p class="alerta_positiva">Banco Mushuc Runa Agregado Correctamente</p>');
                   }

                   if (info.noticia =='error_interno') {
                     $('.alertbanca_Mushuc').html('<p class="alerta_negativa">Error interno cimuniquese con el admin.</p>')
                   }
                   if (info.noticia == 'password_incorrect') {
                     $('.alertbanca_Mushuc').html('<p class="alerta_negativa">Contraseña Incorrecta.</p>')


                   }



                 }
               },
               error:function(error){
                 console.log(error);
                 }

               });

        }
        function closeModalbanca_p(){
          $('#txtbanca_p').val('');
          $('.alertbanca_p').html('');
          $('.modal_banca_p').fadeOut();
        }
