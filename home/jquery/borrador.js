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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
    $('.alerteditt_nombre').html('');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_nombres').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
         }else {
           var info = JSON.parse(response);
           $('.nombres_datos').html(info.nombres);
           $('.nombre_usuario').html(info.nombres);
           $('#txteditt_nombre').val('');
           $('.alerteditt_nombre').html('<p class="alerta_positiva">Nombre  e4ditado Correctamente</p>')


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




//apellidos

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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
    $('.alerteditt_Apellido').html('');
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

           $('.apellido_usuario').html(info.editt_apellido);
           $('.apellidos').html(info.editt_apellido);
           $('#txteditt_apellido').val('');
           $('.alerteditt_Apellido').html('<p class="alerta_positiva">Apellidos  e4ditado Correctamente</p>')




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
        console.log(response);

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



    $('.modal_email').fadeIn();

  });

});
function sendDataedit_email(){
    $('.alerteditt_email').html('');
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
              console.log(info.Error);
                console.log(info.email);

                if ( info.Error != '' && info.mail == undefined ) {
                  console.log(info.Error);
                  $('.alerteditt_email').html('<p class="alerta_negativa"> '+info.Error+'</p>');


                }
           if ( info.email != '' && info.Error == undefined ) {
             $('.alerteditt_email').html('<p class="alerta_positiva">Email editado Correctamente</p>');
             $('.email_es').html(info.email);


           }
          // $('.email_es').html(info.email);
          // $('#txtedit_email').val('');
           //$('.alerteditt_email').html('<p class="alerta_positiva">Nombre  e4ditado Correctamente</p>')

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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
    $('.alerteditt_nombre_empresa').html('');
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
           $('#txtedit_nombre_empresa').val('');
           $('.alerteditt_nombre_empresa').html('<p class="alerta_positiva">Nombre de la empresa  e4ditado Correctamente</p>');
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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
    $('.alerteditt_nombre_empresa').html('');
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
           $('.alerteditt_add_ruc').html('<p class="alerta_positiva">Ruc  e4ditado Correctamente</p>')




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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
           $('.alerteditt_add_direccion').html('<p class="alerta_positiva">direccion  e4ditado Correctamente</p>')




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
           $('.nombre_usuario').html(info.nombres);
           $('.apellidos_usuario').html(info.apellidos);

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
    $('.alerteditt_add_paypal').html('');
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
           $('#txtedit_add_paypal').val('');
           $('.alerteditt_add_paypal').html('<p class="alerta_positiva">Paypal  e4ditado Correctamente</p>')


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
                                      '<div class="alert alertAddProduct">'+
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
                                      '<div class="alert alertAddProduct">'+
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
    $('.alertAddProduct').html('');
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: $('#add_form_facebook').serialize(),

       success: function(response){
         if (response =='error') {
           $('.alertAddProduct').html('<p class="alerta_negativa">Error al Agregar Facebook</p>')
         }else {

           var info = JSON.parse(response);
           $('.newfacebook').html(info.facebook);
           $('#txtfacebook').val('');
           $('.alertAddProduct').html('<p class="alerta_positiva">Facebook Agregado Correctamente</p>')




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
                                                                 $('.nombre_usuario').html(info.nombres);
                                                                 $('.apellidos_usuario').html(info.apellidos);

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
                                                               console.log(response);

                                                               if (response =='error') {
                                                                 $('.alertwhatsapp').html('<p class="alerta_negativa">Error al Agregar Whatsapp</p>')
                                                               }else {
                                                                 var infor = JSON.parse(response);

                                                                if (infor.Error != '' && infor.whatsapp == undefined) {
                                                                  console.log('El Error existe pero el was no')
                                                                  $('.alertwhatsapp').html('<p class="alerta_negativa">Error al Agregar Whatsapp,'+infor.Error+'</p>')


                                                                }
                                                                if (infor.whatsapp != '' && infor.Error == undefined) {
                                                                  console.log('El was existe pero el error no');
                                                                  $('.link_wsp').html(infor.whatsapp);
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
                           $('.nombre_usuario').html(info.nombres);
                           $('.apellidos_usuario').html(info.apellidos);

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
                           $('.link_instagram').html(info.instagram);
                           $('#txtinstagram').val('');
                           $('.alertinstagram').html('<p class="alerta_positiva">Instagram Agregado Correctamente</p>')




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




                                                                         //Editar Nombres
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
                                                                                    $('.nombre_usuario').html(info.nombres);
                                                                                    $('.apellidos_usuario').html(info.apellidos);

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
                                                                             $('.alerteditt_nombre').html('');
                                                                             $.ajax({
                                                                               url:'jquery/general.php',
                                                                               type:'POST',
                                                                               async: true,
                                                                               data: $('#add_form_nombres').serialize(),

                                                                                success: function(response){
                                                                                  if (response =='error') {
                                                                                    $('.alerteditt_nombre').html('<p class="alerta_negativa">Error al Editar el Nombre</p>')
                                                                                  }else {
                                                                                    var info = JSON.parse(response);
                                                                                    $('.nombres_datos').html(info.nombres);
                                                                                    $('.nombre_usuario').html(info.nombres);
                                                                                    $('#txteditt_nombre').val('');
                                                                                    $('.alerteditt_nombre').html('<p class="alerta_positiva">Nombre  e4ditado Correctamente</p>')




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




        //Cuenta bancaria
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
                   $('.nombre_usuario').html(info.nombres);
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
            $('.alertbanca_p').html('');
            $.ajax({
              url:'jquery/general.php',
              type:'POST',
              async: true,
              data: $('#add_form_banca_p').serialize(),

               success: function(response){
                 if (response =='error') {
                   $('.alertbanca_p').html('<p class="alerta_negativa">Error al Agregar Cuenta Bancaria</p>')
                 }else {
                   var info = JSON.parse(response);
                   $('.link_banca_p').html(info.banca_p);
                   $('#txtbanca_p').val('');
                   $('.alertbanca_p').html('<p class="alerta_positiva">Cuenta  Agregado Correctamente</p>')




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




        <?php
        ob_start();
        require "../coneccion.php" ;


        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="../img/icono.ico">
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="emergencia/emergencia.css">
        <link rel="stylesheet" href="emergencia/cuenta5.css">
        <link rel="stylesheet" href="prueba_estilos/cuenta.css">
        <link rel="stylesheet" href="prueba_estilos/whatsapp2.css">
        <link rel="stylesheet" href="prueba_estilos/banca.css">
        <link rel="stylesheet" href="prueba_estilos/instagram.css">
        <link rel="stylesheet" href="prueba_estilos/edit_nombres.css">
        <link rel="stylesheet" href="prueba_estilos/modals.css">
          <link rel="stylesheet" href="emergencia/promociones.css">
          <link rel="stylesheet" href="emergencia/notificacion.css">
        <link rel="stylesheet" href="emergencia/cuenta_empresa1.css">

        <title>CUENTA</title>
        </head>
        <body>
        <?php include "scripts/menu.php" ?>
        <?php
        //MOSTRAR DATOS


        $sql = mysqli_query($conection,"SELECT *FROM  usuarios WHERE id=$iduser");
        $result_sql=mysqli_num_rows($sql);
        if ($result_sql == 0) {
          header('Location:/');
        }else {
               while ($data = mysqli_fetch_array($sql)){
                 $nombres    =  $data['nombres'];
                 $apellidos  =  $data['apellidos'];
                 $email      =  $data['email'];
                 $password   =  $data['password'];
                 $celular    =  $data['celular'];
                 $fecha      =  $data['fecha'];
                 $id         =  $data['id'];
                 $facebook   =  $data['facebook'];
                 $instagram  =  $data['instagram'];
                 $whatsapp  =  $data['whatsapp'];
                 $cuenta_bancaria  =  $data['cuenta_bancaria'];
                 $cuenta_paypal  =  $data['cuenta_paypal'];
                 $empresa   =  $data['empresa'];
                 $direccion   =  $data['direccion'];
                 $ruc   =  $data['ruc'];
                 $nombre_empresa   =  $data['nombre_empresa'];
                 $img_logo   =  $data['img_logo'];
                 $foto = 'img/logos/'.$data['img_logo'];
               }
            }
         ?>






         <div class="modal_facebook">
           <div class="bodyModal_fb">
           </div>
         </div>

         <div class="modal_whatsapp">
           <div class="bodyModal_whatsapp">
             <form class="" action="" method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();" >
                <h3>Agrega tu Plan a tu Cuenta</h3>
                <div class="img_add_whatsapp">
                  <img  src="img/reacciones/juegos.png" alt="">
                </div>
                <p>Hola <p class="nombre_usuario"></p>
                <p class="apellidos_usuario" ></p>
                <div class="">
                <p class="">Tu Whhatsaap es:</p>
                  <p class="link_wsp"></p>
                </div>
                <input type="text" name="whatsapp" value="" id="txtwhatsapp" placeholder="Ingresa el enlace de tu Facebook" required>
                <input type="hidden" name="action" value="addwhatsapp" required><br>
                <div class="alert alertwhatsapp">
                  <p class=""></p>
                </div>
                <div class="alert alertwhatsappposi">
                  <p class=""></p>
                </div>
                <div class="alert alertwhatsappnega">
                  <p class=""></p>
                </div>

                <br>
                <button type="submit" name="button" class="btn_new">Agregar Whatsapp</button>
                <a class="btn_ok closeModal" onclick="closeModalwhatsapp();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
              </form>
           </div>
         </div>
        <div class="modal_instagram">
          <div class="bodyModal_instagram">
            <form class="" action="" method="post" name="add_form_instagram" id="add_form_instagram" onsubmit="event.preventDefault(); sendDatainstagram();" >
               <h3>Agrega tu Instagram a tu Cuenta</h3>
               <div class="img_add_instagram">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu instagram es:</p>
                 <p class="link_instagram"></p>
               </div>
               <input type="text" name="instagram" value="" id="txtinstagram" placeholder="Ingresa el enlace de tu instagram" required>
               <input type="hidden" name="action" value="addinstagram" required><br>
               <div class="alert alertinstagram">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Instagram</button>
               <a class="btn_ok closeModal" onclick="closeModalinstagram();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>

        <div class="modal_banca_p">
          <div class="bodyModal_banca_p">
            <form class="" action="" method="post" name="add_form_banca_p" id="add_form_banca_p" onsubmit="event.preventDefault(); sendDatabanca_p();" >
               <h3>Agrega tu Cuenta Bancaria</h3>
               <div class="img_add_banca_p">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu Cuenta Bancaria  es:</p>
                 <p class="link_banca_p"></p>
               </div>
               <input type="text" name="banca_p" value="" id="txtbanca_p" placeholder="Ingresa tu cuenta bancaria" required>
               <input type="hidden" name="action" value="addbanca_p" required><br>
               <div class="alert alertbanca_p">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Cuenta Bancaria</button>
               <a class="btn_ok closeModal" onclick="closeModalbanca_p();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>



        <div class="modal_nombres">
          <div class="bodyModal_nombres">
            <form class="" action="" method="post" name="add_form_nombres" id="add_form_nombres" onsubmit="event.preventDefault(); sendDataedit_nombres();" >
               <h3>Edita tu nombre aqui</h3>
               <div class="img_add_nombres">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu Nombre   es:</p>
                 <p class="nombre_usuario"></p>
               </div>
               <input type="text" name="editt_nombre" value="" id="txteditt_nombre" placeholder="Ingresa tu nuevo nombre" required>
               <input type="hidden" name="action" value="editt_nombre" required><br>
               <div class="alert alerteditt_nombre">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo Nombre</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_nombre();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_apellidos modal_principal">
          <div class="bodyModal_apellidos modal_secundario">
            <form class="" action="" method="post" name="add_form_apellidos" id="add_form_apellidos" onsubmit="event.preventDefault(); sendDataedit_apellidos();" >
               <h3>Edita tus Apellidos aqui</h3>
               <div class="img_add_nombres img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu Apellido   es:</p>
                 <p class="apellido_usuario"></p>
               </div>
               <input type="text" name="editt_apellido" value="" id="txteditt_apellido" placeholder="Ingresa tu nuevo Apellido" required>
               <input type="hidden" name="action" value="editt_Apellido" required><br>
               <div class="alert alerteditt_Apellido">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo Apellido</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_Apellido();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>

        <div class="modal_email modal_principal">
          <div class="bodyModal_email modal_secundario">
            <form class="" action="" method="post" name="add_form_email" id="add_form_email" onsubmit="event.preventDefault(); sendDataedit_email();" >
               <h3>Edita tus email aqui</h3>
               <div class="img_add_email img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu email  es:</p>
                 <p class="email_es"></p>
               </div>
               <input type="email" name="editt_email" value="" id="txtedit_email" placeholder="Ingresa tu nuevo Email" required>
               <input type="hidden" name="action" value="editt_email" required><br>
               <div class="alert alerteditt_email">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo Email</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_email();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_nombre_empresa modal_principal">
          <div class="bodyModal_nombre_empresa modal_secundario">
            <form class="" action="" method="post" name="add_form_nombre_empresa" id="add_form_nombre_empresa" onsubmit="event.preventDefault(); sendDataedit_nombre_empresa();" >
               <h3>Edita tus nombre_empresa aqui</h3>
               <div class="img_add_nombre_empresa img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu nombre_empresa  es:</p>
                 <p class="nombre_empresa"></p>
               </div>
               <input type="text" name="editt_nombre_empresa" value="" id="txtedit_nombre_empresa" placeholder="Ingresa tu nuevo nombre_empresa" required>
               <input type="hidden" name="action" value="editt_nombre_empresa" required><br>
               <div class="alert alerteditt_nombre_empresa">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo nombre_empresa</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_nombre_empresa();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_add_ruc modal_principal">
          <div class="bodyModal_add_ruc modal_secundario">
            <form class="" action="" method="post" name="add_form_add_ruc" id="add_form_add_ruc" onsubmit="event.preventDefault(); sendDataedit_add_ruc();" >
               <h3>Edita tus add_ruc aqui</h3>
               <div class="img_add_add_ruc img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu add_ruc  es:</p>
                 <p class="ruc_new"></p>
               </div>
               <input type="text" name="editt_add_ruc" value="" id="txtedit_add_ruc" placeholder="Ingresa tu nuevo add_ruc" required>
               <input type="hidden" name="action" value="editt_add_ruc" required><br>
               <div class="alert alerteditt_add_ruc">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo add_ruc</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_add_ruc();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_add_direccion modal_principal">
          <div class="bodyModal_add_direccion modal_secundario">
            <form class="" action="" method="post" name="add_form_add_direccion" id="add_form_add_direccion" onsubmit="event.preventDefault(); sendDataedit_add_direccion();" >
               <h3>Edita tus add_direccion aqui</h3>
               <div class="img_add_add_direccion img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu add_direccion  es:</p>
                 <p class="direccion_new"></p>
               </div>
               <input type="text" name="editt_add_direccion" value="" id="txtedit_add_direccion" placeholder="Ingresa tu nuevo add_direccion" required>
               <input type="hidden" name="action" value="editt_add_direccion" required><br>
               <div class="alert alerteditt_add_direccion">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo add_direccion</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_add_direccion();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_add_paypal modal_principal">
          <div class="bodyModal_add_paypal modal_secundario">
            <form class="" action="" method="post" name="add_form_add_paypal" id="add_form_add_paypal" onsubmit="event.preventDefault(); sendDataedit_add_paypal();" >
               <h3>Edita tus add_paypal aqui</h3>
               <div class="img_add_add_paypal img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <div class="">
               <p class="">Tu add_paypal  es:</p>
                 <p class="pay_pal"></p>
               </div>
               <input type="text" name="editt_add_paypal" value="" id="txtedit_add_paypal" placeholder="Ingresa tu nuevo add_paypal" required>
               <input type="hidden" name="action" value="editt_add_paypal" required><br>
               <div class="alert alerteditt_add_paypal">
                 <p class=""></p>
               </div>

               <br>
               <button type="submit" name="button" class="btn_new">Agregar Nuevo add_paypal</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_add_paypal();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>


        <div class="modal_add_plan modal_principal">
          <div class="bodyModal_add_plan modal_secundario">
            <form class="" action="scripts/agregar_plan.php" method="post" id="add_form_add_plan"  enctype="multipart/form-data" >
               <h3>Agrega un plan para mejorar tus ventas</h3>
               <div class="img_add_add_plan img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <select class="" name="plan" required>
                 <option value="1">Plan A</option>
                 <option value="2">Plan B</option>
                 <option value="3">Plan C</option>
               </select>
               <input type="number" name="numero_unico" value="" placeholder="Ingresa el numero unico del Deposito" required>
               <input type="file" name="foto" value=""  id="foto" required accept="image/png, .jpeg, .jpg" >

               <button type="submit" name="button" class="btn_new">Agregar este Plan</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_add_plan();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>

        <div class="modal_ver_plan  modal_principal">
          <div class="bodyModal_ver_plan modal_secundario">
            <div class="">
              <table>
                <tr>
                  <td>Plan</td>
                  <td class="tipo_plan"></td>
                </tr>
                <tr>
                  <td>Estado</td>
                  <td class="estado"></td>
                </tr>
                <tr>
                  <td>Fecha Inicio</td>
                  <td class="start_date"></td>
                </tr>
                <tr>
                  <td>Fecha Final</td>
                  <td class="start_finish"></td>
                </tr>
              </table>

            </div>
               <a class="btn_ok closeModal" onclick="closeModaleditt_ver_plan();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>

          </div>
        </div>










        <div class="modal_ver_logo  modal_principal">
          <div class="bodyModal_ver_logo modal_secundario">
            <div class="ver_mi_logo">


            </div>

               <a class="btn_ok closeModal" onclick="closeModaleditt_ver_logo();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>

          </div>
        </div>













        <div class="modal_add_logo modal_principal">
          <div class="bodyModal_add_logo modal_secundario">
            <form class="" action="scripts/agragar_logo.php" method="post" id="add_form_add_logo"  enctype="multipart/form-data" >
               <h3>Agrega el logo de tun empresa</h3>
               <div class="img_add_logo img_modal">
                 <img  src="img/reacciones/juegos.png" alt="">
               </div>
               <p>Hola <p class="nombre_usuario"></p>
               <p class="apellidos_usuario" ></p>
               <input type="file" name="foto" value=""  id="foto" required accept="image/png, .jpeg, .jpg" >

               <button type="submit" name="button" class="btn_new">Agregar mi Logo</button>
               <a class="btn_ok closeModal" onclick="closeModaleditt_add_logo();" href="#"> <img id="cerrar" src="img/reacciones/cerrar.png" alt=""> Cerrar</a>
             </form>

          </div>
        </div>













         <div class="titulo">
           <h2>Agrega tu informacion personal y empresarial para que tus clientes se pongan en contacto contigo</h2>

         </div>

         <div class="info_personal">
           <table>
             <tr>
               <td>Id Usuario</td>
               <td class="id_user"></td>
               <td> No se Cambia</td>
             </tr>
             <tr>
               <td>Tipo de Plan</td>
               <td class="none_plan"><a class="ver_plan" usuario="<?php echo $iduser; ?>" href="#"></a></td>
               <td> <a class="add_plan" usuario="<?php echo $iduser; ?>" href="#"> Agregar Plan</a> </td>
             </tr>
             <tr>
               <td>Nombres</td>
               <td class="nombres_datos"></td>
               <td> <a class="add_nombres" usuario="<?php echo $iduser; ?>" href="#"> Editar mis  Nombres </a></td>
             </tr>
             <tr>
               <td>Apellidos</td>
               <td class="apellidos"></td>
               <td>  <a class="add_apellidos" usuario="<?php echo $iduser; ?>" href="#">Editar mis  Apellidos </a></td>
             </tr>
             <tr>
               <td>Email</td>
               <td class="email_es email"></td>
               <td><a class="add_email" usuario="<?php echo $iduser; ?>" href="#">Editar mi email </a></td>
             </tr>
             <tr>
               <td>Celular</td>
               <td class="celular"></td>
               <td><a class="add_celular" usuario="<?php echo $iduser; ?>" href="#">Editar mi  Celular </a></td>
             </tr>
             <tr>
               <td>Fecha Nacimiento</td>
               <td class="fecha_nacimiento"></td>
             </tr>
             <tr>
               <td>Fecha de Creacion de la Cuenta</td>
               <td class="fecha_creacion"></td>
             </tr>

           </table>

         </div>

         <div class="info_empresarial">
           <table>


           <tr>
             <td>Nombre Empresa</td>
             <td class="empresa">Ninguno</td>
             <td> <a class="add_empresa" usuario="<?php echo $iduser; ?>" href="#"></a></td>
           </tr>
           <tr>
             <td>Ruc</td>
             <td class="ruc ruc_new"></td>
             <td><a class="add_ruc" usuario="<?php echo $iduser; ?>" href="#"></a></td>
           </tr>
           <tr>
             <td>Direccion</td>
             <td class="direccion direccion_new"></td>
             <td><a class="add_direccion" usuario="<?php echo $iduser; ?>" href="#"></a></td>
           </tr>
           <tr>
             <td>Cuenta Bancaria</td>
             <td class="cuenta_bancaria"></td>
             <td> <a class="add_cuenta_p" usuario="<?php echo $iduser; ?>" href="#">Agregar Cuenta Pichincha </a></td>
           </tr>
           <tr>
             <td>Cuenta Paypal</td>
             <td class="cuenta_paypal pay_pal"></td>
             <td><a class="add_cuenta_paypal" usuario="<?php echo $iduser; ?>" href="#">Agregar Cuenta Paypal</a></td>
           </tr>
           <tr>
             <td>Logo de tu empresa</td>
             <td class=""><a class="ver_logo" usuario="<?php echo $iduser; ?>" href="#">Ver Logo</a></td>
             <td><a class="add_logo" usuario="<?php echo $iduser; ?>" href="#">Agregar Logo</a>  </td>
           </tr>
           <tr>
             <td>Facebook</td>
             <td class="facebook newfacebook"></td>
             <td><a class="add_facebook" usuario="<?php echo $iduser; ?>" href="#">Agregar facebook </a></td>
           </tr>
           <tr>
             <td>Instagram</td>
             <td class="instagram"></td>
             <td> <a class="add_instagram" usuario="<?php echo $iduser; ?>" href="#">Agregar Instagram </a></td>
           </tr>
           <tr>
             <td>Whatsapp</td>
             <td class="whatsapp"></td>
             <td>  <a class="add_whatsapp" usuario="<?php echo $iduser; ?>" href="#">Agregar Whatsapp </a></td>
           </tr>
              </table>

         </div>




         <script type="text/javascript" src="jquery/jquery.min.js"></script>
         <script type="text/javascript" src="jquery/mostrar.js"></script>
         <script type="text/javascript" src="jquery/general.js"></script>



        <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
        <script src="main.js"></script>
        <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
        ob_end_flush();
        ?>








                                   if (info.instagram != '') {
                                     $('.bodyModal_instagram').html('<form class="" action="" method="post" name="add_form_instagram" id="add_form_instagram" onsubmit="event.preventDefault(); sendDatainstagram();" >'+
                                       ' <h3>Agrega tu Instagram a tu Cuenta</h3>'+
                                       ' <div class="img_add_instagram">'+
                                          '<img  src="img/reacciones/juegos.png" alt="">'+
                                        '</div>'+
                                        '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                        '<p class="apellidos_usuario" >'+info.apellidos+'</p>'+
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
                                       ' <h3>Agrega tu Instagram a tu Cuenta</h3>'+
                                       ' <div class="img_add_instagram">'+
                                          '<img  src="img/reacciones/juegos.png" alt="">'+
                                        '</div>'+
                                        '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                        '<p class="apellidos_usuario" >'+info.apellidos+'</p>'+
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




                                   $('.bodyModal_whatsapp').html('<form class="" action="" method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();" >'+
                                      '<h3>Agrega tu Plan a tu Cuenta</h3>'+
                                      '<div class="img_add_whatsapp">'+
                                        '<img  src="img/reacciones/juegos.png" alt="">'+
                                      '</div>'+
                                      '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                      '<p class="apellidos_usuario" >'+info.apellidos+'</p>'+
                                      '<div class="">'+
                                      '<p class="">Tu Whhatsaap es:</p>'+
                                        '<p class="link_wsp"></p>'+
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




                                    $('.bodyModal_whatsapp').html('<form class="" action="" method="post" name="add_form_whatsapp" id="add_form_whatsapp" onsubmit="event.preventDefault(); sendDataWhatsapp();" >'+
                                       '<h3>Agrega tu Plan a tu Cuenta</h3>'+
                                       '<div class="img_add_whatsapp">'+
                                         '<img  src="img/reacciones/juegos.png" alt="">'+
                                       '</div>'+
                                       '<p>Hola <p class="nombre_usuario">'+info.nombres+'</p>'+
                                       '<p class="apellidos_usuario" >'+info.apellidos+'</p>'+
                                       '<div class="">'+
                                       '<p class="">Tu Whhatsaap es:</p>'+
                                         '<p class="link_wsp"></p>'+
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



                                     if ($_POST['action'] == 'addbanca_p') {
                                       $iduser= $_SESSION['id'];
                                       $banca_p = $_POST['banca_p'];
                                       $password = md5($_POST['password']);
                                       $query_passsword=mysqli_query($conection,"SELECT *FROM  usuarios WHERE  id= $iduser ");
                                       $result_password = mysqli_fetch_array($query_passsword);
                                       $password_bd =  $result_password['password'];
                                       if ($password == $password_bd) {
                                         $query_insert=mysqli_query($conection,"UPDATE usuarios SET cuenta_bancaria='$banca_p' WHERE id='$iduser' ");

                                          if ($query_insert) {
                                            $arrayName = array('banca_p' =>$banca_p);
                                           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


                                          }else {
                                            $arrayName = array('Error' =>'Error al insertar el Correo');
                                            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                                          }
                                     }else {
                                       $arrayName = array('Error' =>'La contraseña Ingresada es incorrecta');
                                       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                     }
                                   }





                                   if ($_POST['action'] == 'addwhatsapp') {
                                     $iduser= $_SESSION['id'];
                                     $whatsapp = $_POST['whatsapp'];
                                     $whatsapp2 = trim($whatsapp);
                                    $number = str_split($whatsapp2);
                                    $ejemplo = count($number);
                                    if ($ejemplo > 10) {
                                      $arrayName = array('Error' =>'el numero es mayor a 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 10){
                                      if ($number['0']==0) {
                                        $_number_total= ['5','9','3',$number['1'],$number['2'],$number['3'],$number['4'],$number['5'],$number['6'],$number['7'],$number['8'],$number['9']];
                                        $numero_guardar = implode('',$_number_total);
                                        $query_insert=mysqli_query($conection,"UPDATE usuarios SET whatsapp='$numero_guardar' WHERE id='$iduser' ");
                                        if ($query_insert) {
                                           $arrayName = array('whatsapp' =>$numero_guardar);
                                          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                                        }else {
                                          $arrayName = array('Error' =>'Error al  insertar en la base de datos');
                                          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                        }
                                      }else {
                                        $arrayName = array('Error' =>'el primer digito tiene que ser cero');
                                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                      }


                                    }


                                    if ($ejemplo == 9) {
                                      $arrayName = array('Error' =>'El numero contiene 9 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                                    }
                                    if ($ejemplo == 8) {
                                      $arrayName = array('Error' =>'El numero contiene 8 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 7) {
                                      $arrayName = array('Error' =>'El numero contiene 7 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 6) {
                                      $arrayName = array('Error' =>'El numero contiene 6 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 5) {
                                      $arrayName = array('Error' =>'El numero contiene 5 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 4) {
                                      $arrayName = array('Error' =>'El numero contiene 4 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 3) {
                                      $arrayName = array('Error' =>'El numero contiene 3 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 2) {
                                      $arrayName = array('Error' =>'El numero contiene 2 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 1) {
                                      $arrayName = array('Error' =>'El numero contiene 1 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }
                                    if ($ejemplo == 0) {
                                      $arrayName = array('Error' =>'El numero contiene 0 digitos, ingresa uno de 10 digitos');
                                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                                    }

                                   }

() => {

}

if ($_POST['action'] == 'addFacebook') {
  $iduser= $_SESSION['id'];
  $facebook = $_POST['facebook'];
  $facebook_sin_espacios = trim($facebook);
  $facebook_number = str_split($facebook_sin_espacios);
  $facebook_array = count($facebook_number);
  if ($facebook_array > 23) {
    $A0 = $facebook_number[0];
    $A1 = $facebook_number[1];
    $A2 = $facebook_number[2];
    $A3 = $facebook_number[3];
    $A4 = $facebook_number[4];
    $A5 = $facebook_number[5];
    $A6 = $facebook_number[6];
    $A7 = $facebook_number[7];
    $A8 = $facebook_number[8];
    $A9 = $facebook_number[9];
    $A10 = $facebook_number[10];
    $A11 = $facebook_number[11];
    $A12 = $facebook_number[12];
    $A13 = $facebook_number[13];
    $A14 = $facebook_number[14];
    $A15 = $facebook_number[15];
    $A16 = $facebook_number[16];
    $A17 = $facebook_number[17];
    $A18 = $facebook_number[18];
    $A19 = $facebook_number[19];
    $A20 = $facebook_number[20];
    $A21 = $facebook_number[21];
    $A22 = $facebook_number[22];
    $A23 = $facebook_number[23];
    $A24 = $facebook_number[24];
    if ($A0== 'h' && $A1 == 't' && $A2 == 't' && $A3 == 'p' && $A4 == 's' && $A12 == 'f' && $A13 == 'a' && $A14 == 'c' && $A15 == 'e' &&  $A16 == 'b' && $A17 == 'o' && $A18 == 'o' && $A19 == 'k' && $A21 == 'c' && $A22 == 'o' && $A23 == 'm') {
      $query_insert=mysqli_query($conection,"UPDATE usuarios SET facebook='$facebook' WHERE id='$iduser' ");
      if ($query_insert) {
         $arrayName = array('facebook' =>$facebook);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      }else {
        $arrayName = array('Error' =>'Error al Insertar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
    }else {
      $arrayName = array('Error' =>'Ingrese una direccion Valida');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

  }else {
    $arrayName = array('Error' =>'Su enlace es muy pequeño');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

  mysqli_close($conection);


}
