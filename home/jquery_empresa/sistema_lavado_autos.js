function sendData_eliminar_tipo_vehiuclo(){
  $('.notificacion_eliminar_tipoo9_vehiculo').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#eliminar_tipo_vehiculo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_eliminar_tipoo9_vehiculo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.respuesta == 'elimado_correctamnete') {
        $('.notificacion_eliminar_tipoo9_vehiculo').html('<div class="alert alert-success" role="alert">Eliminado Correctamente!</div>');
        document.getElementById('fila_tipo'+info.tipo_vehiculo_form+'').style.display = "none";

      }
      if (info.respuesta == 'error_insertar') {
      $('.notificacion_eliminar_tipoo9_vehiculo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}




(function(){
  $(function(){
    $('.eliminar_tipo_vehiculo').on('click',function(){
      $('#modal_eliminar_tipo_vehiculo').modal();
      var tipo_vehiculo = $(this).attr('tipo_vehiculo');
      var action = 'bucar_inofrmacion_tipo_vehiculo';
      $("#tipo_vehiculo_form").val(tipo_vehiculo);
      $.ajax({
        url:'jquery_empresa/sistema_lavado_autos.php',
        type:'POST',
        async: true,
        data: {action:action,tipo_vehiculo:tipo_vehiculo},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
              $('#result_tpo_vehiculo').html('<div class="alert alert-warning" role="alert">Estas seguro que deseas eliminar este ripo de Vehículo '+info.id+'!</div>');

           }
         },
         error:function(error){
           console.log(error);
           }
         });
    });


  });

}());



function sendData_eliminar_tarifa_tiempo(){
  $('.notificacion_eliminar_tarifa_tiempo').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#eliminar_tarifa_tiempo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_configurar_espacios').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.respuesta == 'elimado_correctamnete') {
        $('.notificacion_eliminar_tarifa_tiempo').html('<div class="alert alert-success" role="alert">Eliminado Correctamente!</div>');
        document.getElementById('fila_tarifa'+info.tarifa+'').style.display = "none";

      }
      if (info.respuesta == 'error_insertar') {
      $('.notificacion_eliminar_tarifa_tiempo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}








(function(){
  $(function(){
    $('.eliminar_tarifa').on('click',function(){
      $('#modal_elimimar_tarifa').modal();
      var tarifa = $(this).attr('tarifa');
      var action = 'bucar_inofrmacion_tarigfda';
      $("#tarifa_form").val(tarifa);
      $.ajax({
        url:'jquery_empresa/sistema_lavado_autos.php',
        type:'POST',
        async: true,
        data: {action:action,tarifa:tarifa},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
              $('#result_tarifa').html('<div class="alert alert-warning" role="alert">Estas seguro que deseas eliminar la tarifa '+info.id+'!</div>');

           }
         },
         error:function(error){
           console.log(error);
           }
         });
    });


  });

}());


function sendData_configurar_spacio_parqueo(){
  $('.notificacion_configurar_espacios').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#configuirar_espacio_parqueo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_configurar_espacios').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.respuesta == 'insert_correct') {
        $('.notificacion_configurar_espacios').html('<div class="alert alert-success" role="alert">Espacios agregados correctamente!</div>');

      }
      if (info.respuesta == 'error_insertar') {
      $('.notificacion_configurar_espacios').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}


function sendData_agregar_tipo_vehiculo(){
  $('.notifiacion_agregar_tipo_vehiculo').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_tipo_vehiculo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notifiacion_agregar_tipo_vehiculo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.respuesta == 'insert_correct') {
        $('.notifiacion_agregar_tipo_vehiculo').html('<div class="alert alert-success" role="alert">Espacios agregados correctamente!</div>');

      }
      if (info.respuesta == 'error_insertar') {
      $('.notifiacion_agregar_tipo_vehiculo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}




function sendData_agregar_tarifa_tiempo(){
  $('.agregar_tarifa_tiempo').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_tarifa_tiempo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.agregar_tarifa_tiempo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.respuesta == 'insert_correct') {
        $('.agregar_tarifa_tiempo').html('<div class="alert alert-success" role="alert">Tarifa en tiempo Agregado Correctamente!</div>');

      }
      if (info.respuesta == 'error_insertar') {
      $('.agregar_tarifa_tiempo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}




function sendData_ingresar_vehiculo_lavanderia(){
  $('.notificacion_ingreso_vehiuclo_lavanderia').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#ingresar_vehiculo_lavanderia')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/sistema_lavado_autos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        var id_creado = info.id_creado;
        var action = 'generar_parqueo';
        $.ajax({
        url: 'facturacion/facturacionphp/controladores/ctr_nota_parqueo_lavanderia.php',
          type:'POST',
          async: true,
          data: {action:action,id_creado:id_creado},
          success: function(response){
            console.log(response);
              var info = JSON.parse(response);


              if (info.noticia =='insert_correct') {
                $('.notificacion_ingreso_vehiuclo_lavanderia').html('<div class="alert alert-success" role="alert">Vehiculo Ingresado Correctamente <a target="_blank" href="/home/facturacion/facturacionphp/comprobantes/parqueo/pdf/'+info.pdf+'.pdf">Descarga e Imprime</a> !</div>')

              }
              if (info.noticia =='pdf_generado') {
                $('.notificacion_ingreso_vehiuclo_lavanderia').html('<div class="alert alert-warning" role="alert">mira el pdf <a target="_blank" href="facturacion/facturacionphp/comprobantes/proformas/pdf/'+info.pdf+'">Generado Aqui</a> !</div>')

              }
              if (info.noticia == 'error_insertar') {
              $('.notificacion_ingreso_vehiuclo_lavanderia').html('<div class="alert alert-danger" role="alert">Error en el controlador!</div>');

              }


          },

           });


      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_ingreso_vehiuclo_lavanderia').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}






var URL_SERVER = '../code_garantia/consultar_parqueadero_lavanderia.php';

function guardar_codigo_escaneado(result_qr){

  var data = {
    'codigo': result_qr
  };
  $.ajax({
      url: URL_SERVER,
      data: data,
      type: "POST",
      datatype:"json",
      success: function(data){
        console.log(data);
          var info = JSON.parse(data);
          if (info.noticia == 'no_existe_datos') {
              $('.notificacion_respuesta_despacho_qr').html('<div class="alert alert-danger" role="alert">No existe datos para este registro !</div>');
          }
          if (info.noticia == 'existe_datos') {
              $('.notificacion_respuesta_despacho_qr').html('<div class="alert alert-success" role="alert">El Registro con la placa '+info.placa+' empezo desde la hora '+info.fecha_inicio+', lleva '+info.horas_calculadas+' horas y tiene que pagar  $'+info.precio_servicio+' !</div>');
             $('.formulario_cobrar_parqueo').html('<form  class="" method="post" name="cobrar_parqueo" id="cobrar_parqueo" onsubmit="event.preventDefault(); sendData_cobrar_parqueo();">'+
                                    '<input type="hidden" name="action" value="cobrar_parqueo">'+
                                    '<input type="hidden" name="idparqueo" value="'+info.id_parqueo+'">'+
                                    '<div class="modal-footer">'+
                                         '<button type="submit" class="btn btn-primary">Cobrar Parqueo</button>'+
                                         '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                                   '</div>'+
                                    '<div class="notificacion_agregar_cobro_parquep">'+
                                    '</div>'+
                                  '</form>');
          }


    }
  });
}
var initial_code_result = true;
var video = document.createElement("video");
var canvasElement = document.getElementById("canvas");
var canvas = canvasElement.getContext("2d");
var loadingMessage = document.getElementById("preMensaje");
var outputContainer = document.getElementById("datosSalida");
var outputMessage = document.getElementById("mensajeSalida");
var outputData = document.getElementById("qrDetectado");
var sonido = document.querySelector('#sonido_qr');
function drawLine(begin, end, color) {
  canvas.beginPath();
  canvas.moveTo(begin.x, begin.y);
  canvas.lineTo(end.x, end.y);
  canvas.lineWidth = 4;
  canvas.strokeStyle = color;
  canvas.stroke();
}
navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
  video.srcObject = stream;
  video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
  video.play();
  requestAnimationFrame(tick);
});
function tick() {
  loadingMessage.innerText = "Cargando Video...";
  if (video.readyState === video.HAVE_ENOUGH_DATA) {
    loadingMessage.hidden = true;
    canvasElement.hidden = false;
    outputContainer.hidden = false;
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
    var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
    var code = jsQR(imageData.data, imageData.width, imageData.height, {
      inversionAttempts: "dontInvert",
    });
    if (code && initial_code_result) {
      drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
      drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
      drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
      drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
      if(code.data!=''){
        outputMessage.hidden = true;
        outputData.parentElement.hidden = false;
        outputData.innerText = code.data;
        sonido.setAttribute("autoplay", true);
        sonido.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        sonido.play();
        sonido.play();
        guardar_codigo_escaneado(code.data);
        initial_code_result = false;
        setTimeout(function(){
          initial_code_result = true;
        },6000);
      }else{
      }
    } else {
      if(initial_code_result){
        outputMessage.hidden = false;
        outputData.parentElement.hidden = true;
      }
    }
  }
  requestAnimationFrame(tick);
}
