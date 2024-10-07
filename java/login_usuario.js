

function sendData_login_usuarios() {
  $('.alerta_ingreso_sistema').html('<div class="proceso">' +
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>' +
    '</div>');
  var parametros = new FormData($('#login_usuarios')[0]);
  $.ajax({
    data: parametros,
    url: 'java/login_usuario.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforeSend: function() {
      // Acciones a realizar antes del envío, como mostrar un spinner.
    },
    success: function(response) {
      console.log(response);
      try {
        var respuesta = JSON.parse(response);

        // Verificamos si la respuesta es un mensaje específico
        if (respuesta.respuesta) {
          switch (respuesta.respuesta) {
            case 'no_existe_resultados':
              console.log('No hay usuarios registrados.');
              $('#resultado_usuarios_cuenta_empresa').html('<div class="alert alert-warning background-warning">'+
              '<strong>No tienes una cuenta en nuestro sistema </strong>Regístrate gratuitamente'+
              '</div>');
              break;
            case 'password_exitoso':
            $('.alerta_ingreso_sistema').html('<div class="alert alert-success background-success">'+
            '<strong>Ingreso Correcto </strong>Redirigiendo al sistema'+
            '</div>');
            window.location.reload(true);
              console.log('Contraseña correcta, acceso exitoso.');
              // Aquí puedes redirigir al usuario o actualizar la UI como sea necesario
              break;
            case 'contraea_incorrecta':

            $('.alerta_ingreso_sistema').html('<div class="alert alert-danger background-danger">'+
            '<strong>Contraseña </strong>incorrecta, recupera tu contraseña si lo olvidaste'+
            '</div>');
              console.log('La contraseña es incorrecta.');
              // Aquí puedes mostrar un mensaje al usuario o permitirle intentarlo de nuevo
              break;

              case 'intentos_maximos':

              $('.alerta_ingreso_sistema').html('<div class="alert alert-danger background-danger">'+
              '<strong>Intentos Máximos permitidos</strong> comunícate con soporte. '+
              '</div>');
                console.log('Intentos Máximos.');
                // Aquí puedes mostrar un mensaje al usuario o permitirle intentarlo de nuevo
                break;

            default:

            $('.alerta_ingreso_sistema').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error </strong>'+respuesta.respuest+' '+
            '</div>');
          }
        } else {
          // Aquí manejas la lista de usuarios como lo hacías antes
          var html = '';
          for (var i = 0; i < respuesta.length; i++) {
            var data_lista = respuesta[i];
            // Aquí validamos el rol antes de construir el HTML
            if (data_lista.rol === 'Cuenta Empresa') {
              html += '<div class="col-4 tarjeta_presentacion_usuario"  nombres="'+data_lista.nombres+'" codigo="'+data_lista.id+'" rol="'+data_lista.rol+'" url_img_upload="'+data_lista.url_img_upload+'" img_facturacion="'+data_lista.img_facturacion+'">' +
                        '<div class="card user-card">' +
                          '<img src="'+data_lista.url_img_upload+'/home/img/uploads/'+data_lista.img_facturacion+'" class="card-img-top" alt="User Image" />' +
                          '<div class="card-body">' +
                            '<p class="card-text">' + data_lista.nombres + '</p>' +
                            '<p class="card-text">' + data_lista.rol + '</p>' +
                          '</div>' +
                        '</div>' +
                      '</div>';
            }

            if (data_lista.rol === 'Usuario Venta') {
              html += '<div class="col-4 tarjeta_presentacion_usuario_venta" nombres="'+data_lista.nombres+'"  codigo="'+data_lista.id+'" rol="'+data_lista.rol+'" url_img_upload="'+data_lista.url_img_upload+'" foto="'+data_lista.foto+'">' +
                        '<div class="card user-card">' +
                          '<img src="'+data_lista.url_img_upload+'/home/img/uploads/'+data_lista.foto+'" class="card-img-top" alt="User Image" />' +
                          '<div class="card-body">' +
                            '<p class="card-text">' + data_lista.nombres + '</p>' +
                            '<p class="card-text">' + data_lista.rol + '</p>' +
                          '</div>' +
                        '</div>' +
                      '</div>';
            }

            if (data_lista.rol === 'Paciente') {
              html += '<div class="col-4 tarjeta_presentacion_paciente" nombres="'+data_lista.nombres+'"  codigo="'+data_lista.id+'" rol="'+data_lista.rol+'" url_img_upload="'+data_lista.url_img_upload+'" foto="'+data_lista.foto+'">' +
                        '<div class="card user-card">' +
                          '<img src="'+data_lista.url_img_upload+'/home/img/uploads/'+data_lista.foto+'" class="card-img-top" alt="User Image" />' +
                          '<div class="card-body">' +
                            '<p class="card-text">' + data_lista.nombres + '</p>' +
                            '<p class="card-text">' + data_lista.rol + '</p>' +
                          '</div>' +
                        '</div>' +
                      '</div>';
            }


            if (data_lista.rol === 'Recursos Humanos') {
              html += '<div class="col-4 tarjeta_presentacion_recursos_humanos" nombres="'+data_lista.nombres+'"  codigo="'+data_lista.id+'" rol_interno="'+data_lista.nombre+'" rol="'+data_lista.rol+'" url_img_upload="'+data_lista.url_img_upload+'" foto="'+data_lista.foto+'">' +
                        '<div class="card user-card">' +
                          '<img src="'+data_lista.url_img_upload+'/home/img/uploads/'+data_lista.foto+'" class="card-img-top" alt="User Image" />' +
                          '<div class="card-body">' +
                            '<p class="card-text">' + data_lista.nombres + '</p>' +
                            '<p class="card-text">' + data_lista.nombre + '</p>' +
                          '</div>' +
                        '</div>' +
                      '</div>';
            }

          }
          $('#resultado_usuarios_cuenta_empresa').html(html);
          document.getElementById('contendedor_elementos_desaparecer').style.display = "none";
        }
      } catch (e) {
        console.error('Error al analizar la respuesta del servidor:', e);
        $('.alerta_login_usuario').html('<div class="alert alert-danger" role="alert">Error al procesar la respuesta del servidor.</div>');
      }
    },
    error: function(xhr, status, error) {
      // Manejo de errores
      $('.alerta_login_usuario').html('<div class="alert alert-danger" role="alert">Ha ocurrido un error: ' + error + '</div>');
    }
  });
}


$(document).on("click", ".tarjeta_presentacion_usuario", function() {
    var codigo = $(this).attr('codigo');
    var nombres = $(this).attr('nombres');
    var rol = $(this).attr('rol');
    var url_img_upload = $(this).attr('url_img_upload');
    var img_facturacion = $(this).attr('img_facturacion');
    document.getElementById('resultado_usuarios_cuenta_empresa').style.display = "none";
    document.getElementById('contendedor_elementos_desaparecer').style.display = "block";
    $('.resultado_nombres_users').html('Ingresar a cuenta de '+nombres+'');
    $('#contendedor_elementos_desaparecer').html('<div class="row g-3 ">' +
                          '<div class="col-4 " style="margin: 0 auto;">' +
                                  '<div class="card user-card">' +
                                    '<img src="'+url_img_upload+'/home/img/uploads/'+img_facturacion+'" class="card-img-top" alt="User Image" />' +
                                    '<div class="card-body">' +
                                      '<p class="card-text">' +rol + '</p>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>'+
                          '</div>'+
                              ' <br><div class="form-group form-primary">'+
                                  '  <input type="password" name="password_user" class="form-control" required placeholder="Ingresa tu Contraeña" />'+
                                  '  <span class="form-bar"></span>'+
                              '  </div>'+
                              '  <div class="row m-t-25 text-left">'+
                                    '<div class="col-12">'+
                                        '<div class="forgot-phone text-right f-right">'+
                                          '  <a href="recuperar_password" class="text-right f-w-600">Olvide mi Contraseña?</a>'+
                                      '  </div>'+
                                  '  </div>'+
                                '</div>'+
                                '<div class="row m-t-30">'+
                                  '  <div class="col-md-12">'+
                                        '<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Ingresar</button>'+
                                              '<input type="hidden" name="rol" value="'+rol+'">'+
                                            '  <input type="hidden" name="action" value="ingresar_login">'+
                                            '  <input type="hidden" name="id_user" value="'+codigo+'">'+
                                    '</div>'+
                                '</div><div class="alerta_ingreso_sistema" style="text-align: center;"></div>');

});



$(document).on("click", ".tarjeta_presentacion_usuario_venta", function() {
    var user_in = document.getElementById('user_in').value;
    var codigo = $(this).attr('codigo');
    var nombres = $(this).attr('nombres');

    var rol = $(this).attr('rol');
    var url_img_upload = $(this).attr('url_img_upload');
    var foto = $(this).attr('foto');
    document.getElementById('resultado_usuarios_cuenta_empresa').style.display = "none";
    document.getElementById('contendedor_elementos_desaparecer').style.display = "block";
    $('.resultado_nombres_users').html('Ingresar a cuenta de '+nombres+'');
    $('#contendedor_elementos_desaparecer').html('<div class="row g-3 ">' +
                          '<div class="col-4 " style="margin: 0 auto;">' +
                                  '<div class="card user-card">' +
                                    '<img src="'+url_img_upload+'/home/img/uploads/'+foto+'" class="card-img-top" alt="User Image" />' +
                                    '<div class="card-body">' +
                                      '<p class="card-text">' +rol + '</p>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>'+
                          '</div>'+
                              ' <br><div class="form-group form-primary">'+
                                  '  <input type="password" name="password_user" class="form-control" required placeholder="Ingresa tu Contraeña" />'+
                                  '  <span class="form-bar"></span>'+
                              '  </div>'+
                              '  <div class="row m-t-25 text-left">'+
                                    '<div class="col-12">'+
                                        '<div class="forgot-phone text-right f-right">'+
                                          '  <a href="recuperar_password?user_in='+user_in+'" class="text-right f-w-600">Olvide mi Contraseña?</a>'+
                                      '  </div>'+
                                  '  </div>'+
                                '</div>'+
                                '<div class="row m-t-30">'+
                                  '  <div class="col-md-12">'+
                                        '<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Ingresar</button>'+
                                              '<input type="hidden" name="user_in" value="'+user_in+'">'+
                                              '<input type="hidden" name="rol" value="'+rol+'">'+
                                            '  <input type="hidden" name="action" value="ingresar_login">'+
                                            '  <input type="hidden" name="id_user" value="'+codigo+'">'+
                                    '</div>'+
                                '</div><div class="alerta_ingreso_sistema" style="text-align: center;"></div>');

});


$(document).on("click", ".tarjeta_presentacion_recursos_humanos", function() {
    var rol_interno = $(this).attr('rol_interno');
    var codigo = $(this).attr('codigo');
    var nombres = $(this).attr('nombres');
    var rol = $(this).attr('rol');
    var url_img_upload = $(this).attr('url_img_upload');
    var foto = $(this).attr('foto');
    document.getElementById('resultado_usuarios_cuenta_empresa').style.display = "none";
    document.getElementById('contendedor_elementos_desaparecer').style.display = "block";
    $('.resultado_nombres_users').html('Ingresar a cuenta de '+nombres+'');
    $('#contendedor_elementos_desaparecer').html('<div class="row g-3 ">' +
                          '<div class="col-4 " style="margin: 0 auto;">' +
                                  '<div class="card user-card">' +
                                    '<img src="'+url_img_upload+'/home/img/uploads/'+foto+'" class="card-img-top" alt="User Image" />' +
                                    '<div class="card-body">' +
                                      '<p class="card-text">' +rol_interno + '</p>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>'+
                          '</div>'+
                              ' <br><div class="form-group form-primary">'+
                                  '  <input type="password" name="password_user" class="form-control" required placeholder="Ingresa tu Contraeña" />'+
                                  '  <span class="form-bar"></span>'+
                              '  </div>'+
                              '  <div class="row m-t-25 text-left">'+
                                    '<div class="col-12">'+
                                        '<div class="forgot-phone text-right f-right">'+
                                          '  <a href="recuperar_password" class="text-right f-w-600">Olvide mi Contraseña?</a>'+
                                      '  </div>'+
                                  '  </div>'+
                                '</div>'+
                                '<div class="row m-t-30">'+
                                  '  <div class="col-md-12">'+
                                        '<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Ingresar</button>'+
                                              '<input type="hidden" name="rol" value="'+rol+'">'+
                                              '<input type="hidden" name="rol_interno" value="'+rol_interno+'">'+
                                            '  <input type="hidden" name="action" value="ingresar_login">'+
                                            '  <input type="hidden" name="id_user" value="'+codigo+'">'+
                                    '</div>'+
                                '</div><div class="alerta_ingreso_sistema" style="text-align: center;"></div>');

});


$(document).on("click", ".tarjeta_presentacion_paciente", function() {
    var codigo = $(this).attr('codigo');
    var nombres = $(this).attr('nombres');
    var rol = $(this).attr('rol');
    var url_img_upload = $(this).attr('url_img_upload');
    var foto = $(this).attr('foto');
    document.getElementById('resultado_usuarios_cuenta_empresa').style.display = "none";
    document.getElementById('contendedor_elementos_desaparecer').style.display = "block";
    $('.resultado_nombres_users').html('Ingresar a cuenta de '+nombres+'');
    $('#contendedor_elementos_desaparecer').html('<div class="row g-3 ">' +
                          '<div class="col-4 " style="margin: 0 auto;">' +
                                  '<div class="card user-card">' +
                                    '<img src="'+url_img_upload+'/home/img/uploads/'+foto+'" class="card-img-top" alt="User Image" />' +
                                    '<div class="card-body">' +
                                      '<p class="card-text">' +rol + '</p>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>'+
                          '</div>'+
                              ' <br><div class="form-group form-primary">'+
                                  '  <input type="password" name="password_user" class="form-control" required placeholder="Ingresa tu Contraeña" />'+
                                  '  <span class="form-bar"></span>'+
                              '  </div>'+
                              '  <div class="row m-t-25 text-left">'+
                                    '<div class="col-12">'+
                                        '<div class="forgot-phone text-right f-right">'+
                                          '  <a href="recuperar_password" class="text-right f-w-600">Olvide mi Contraseña?</a>'+
                                      '  </div>'+
                                  '  </div>'+
                                '</div>'+
                                '<div class="row m-t-30">'+
                                  '  <div class="col-md-12">'+
                                        '<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Ingresar</button>'+
                                              '<input type="hidden" name="rol" value="'+rol+'">'+
                                            '  <input type="hidden" name="action" value="ingresar_login">'+
                                            '  <input type="hidden" name="id_user" value="'+codigo+'">'+
                                    '</div>'+
                                '</div><div class="alerta_ingreso_sistema" style="text-align: center;"></div>');

});
