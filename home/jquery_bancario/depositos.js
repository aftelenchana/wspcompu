
//deposito Comporbante
$(document).ready(function(){
  //modal para agregar el producto
  $('.deposito_comprobante').click(function(e){
    e.preventDefault();
    $('.bodyModal_deposito_comprobante').html(' <div class="">'+
       '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    var usuario = 1;
    var action = 'infoUsuario';
    $.ajax({
      url:'jquery/general.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);
           $('.bodyModal_deposito_comprobante').html('<form class="form_add_producto" action="" method="post" name="add_comprobante" id="add_comprobante" onsubmit="event.preventDefault(); sendData_add_comprobante();">'+
           '<h3>DEPÓSITO BANCARIO</h3>'+
                   '<h3> Hola <span class="identificacion_usuario" > '+info.nombres+' '+info.apellidos+'</span> realiza un deposito a tu cuenta  mediante nuestra cuenta</h3>'+
                   '<div class="tipo_banco">'+
                     '<select class="" name="tipo_banco">'+
                       '<option value="Banco Pichincha">Banco Pichincha 2206665812</option>'+
                       '<option value="Produbanco">Produbanco (Grupo Promerica) 12080241145</option>'+
                       '<option value="Banco Guayaquil">Banco Guayaquil 0047825380</option>'+
                       '<option value="Banco Pacifico">Banco del Pacifico  1049945475</option>'+
                       '<option value="Camara de Comercio Ambato">Camara de Comercio Ambato CCCA 403095054137</option>'+
                       '<option value="Cooperativa Mushuc Runa">Cooperativa Mushuc Runa 404406513458</option>'+
                     '</select>'+
                   '</div>'+
                    '<div class="photo">'+
                              '<input  type="file" name="foto"  accept="image/png, .jpeg, .jpg" required>'+
                    '</div>'+
                      '<label >Ingrese la cantida de deposito</label>'+
                     '<input class="entrada" type="number" name="cantidad" value="" placeholder="Cantidad de Deposito" step="0.001">'+
                     '<label >Ingrese el numero unico del Comprobante</label>'+
                    '<input class="entrada" type="number" name="numero_unico" value="" placeholder="Numero de Comprobante">'+
                    '<input type="hidden" name="action" value="deposito_comprobante" required>'+
                     '<label >Ingrese su Contraseña</label>'+
                    '<input class="entrada" type="password" name="password" value="" placeholder="Ingrese su Contraseña"><br>'+
                    '<div class="alerta_deposito_comprobante">'+
                    '</div>'+
                    '<button type="submit" name="button" class="btn_new" onsubmit="sendDataedit_add_servicios();">Agregar Deposito</button>'+
                    '<div style="width: 100px;margin: 0 auto;display: inline-block;padding: 5px;margin: 5px;background: #FF0000;border-radius: 5px;" class="conte_acciones">'+
                    '<div style="display: flex;align-items: center;cursor: pointer;" onclick="closeModal_dep_comprobante();" class=""><img style="width: 20px;display: inline-block;" src="/home/img/reacciones/cerrar.png" style="width: 30px;" alt=""> <p style="display: inline-block;">Cerrar</p> </div>'+
                    '</div>'+
                  '</form>');

         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_deposito_comprobante').fadeIn();


  });

});


function sendData_add_comprobante(){
  $('.alerta_deposito_comprobante').html(' <div class="">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_comprobante')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_bancario/depositos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'pago_agregado') {
        $('.alerta_deposito_comprobante').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/garrapata.png" width="50px" alt="">'+
          '<p>Depósito en Proceso, nuestro equipo está trabajando para ti.</p>'+
        '</div>');
      }
      if (info.noticia == 'contrasena_incorrecta') {
        $('.alerta_deposito_comprobante').html('<div class="alert alert-success" role="alert">Contraseña Incorrecta!</div>');
      }
      if (info.noticia == 'comprobante_igual') {
        $('.alerta_deposito_comprobante').html('<div class="alert alert-success" role="alert">Este comporbante ya existe en nuestra Base de datos!</div>');
      }
      if (info.noticia == 'entidad_bancaria_vacia') {
        $('.alerta_deposito_comprobante').html('<div class="alert alert-success" role="alert">Entidad Bancaria Vacia!</div>');
      }
      if (info.noticia == 'cuenta_bancaria_inactiva') {
        $('.alerta_deposito_comprobante').html('<div class="alert alert-success" role="alert">Cuenta Bancaria Inactiva!</div>');
      }




      }

    }

  });

}


function closeModal_dep_comprobante(){
  $('.foto').val('');
  $('.modal_deposito_comprobante').fadeOut();
}



//RETIRO CUENTA BANCARIA

$(document).ready(function(){
  $('.retiro_bancario').click(function(e){
    e.preventDefault();
    var usuario = 1;
    var action = 'infoUsuario';
    $.ajax({
      url:'jquery_bancario/estado_financiero.php',
      type:'POST',
      async: true,
      data: {action:action,usuario:usuario},
       success: function(response){
         if (response != 'error') {
           var info = JSON.parse(response);


         }
       },
       error:function(error){
         console.log(error);
         }

       });

    $('.modal_retiro_banca').fadeIn();


  });

});


function sendData_retiro_comprobante(){
 $('.alert_retiro_bancario').html(' <div class="notificacion_negativa">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#retiro_comprobante')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_bancario/depositos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'retiro_agregado') {
        $('.alert_retiro_bancario').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/garrapata.png" width="50px" alt="">'+
          '<p>Retiro en Proceso, nuestro equipo está trabajando para ti.</p>'+
        '</div>');
        $('.identificacion_usuario').html('$'+info.cantidad+'');

      }
      if (info.noticia == 'contrasena_incorrecta') {
        $('.alert_retiro_bancario').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/cerca.png" width="50px" alt="">'+
          '<p>Contraseña Incorrecta</p>'+
        '</div>');


      }
      if (info.noticia == 'saldo_insuficiente') {
        $('.alert_retiro_bancario').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/cerca.png" width="50px" alt="">'+
          '<p>Saldo Insuficiente en tu cuenta</p>'+
        '</div>');
      }
      if (info.noticia == 'cuenta_bancaria_inactiva') {
        $('.alert_retiro_bancario').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/cerca.png" width="50px" alt="">'+
          '<p>Movimientos Bancarios Inactivos</p>'+
        '</div>');
      }
      if (info.noticia == 'menos_24_horas_sin_compra') {
        $('.alert_retiro_bancario').html('<div class="genearl_alert">'+
          '<img src="img/reacciones/cerca.png" width="50px" alt="">'+
          '<p>El sistema a detectado que deseas hacer una transferencia interbancaria, realiza una compra o espera 24 horas desde tu ultimo depósito.</p>'+
        '</div>');
      }




      }

    }

  });

}


function closeModal_retiro_banca(){
  $('.foto').val('');
  $('.entrada').val('');
  $('.alert_retiro_bancario').html('');
  $('.modal_retiro_banca').fadeOut();
}
