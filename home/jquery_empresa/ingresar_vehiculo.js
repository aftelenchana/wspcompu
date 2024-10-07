
function sendData_cobrar_parqueo(){
  $('.notificacion_agregar_cobro_parquep').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#cobrar_parqueo')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/ingresar_vehiculo.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_agregar_cobro_parquep').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {

        $('.notificacion_agregar_cobro_parquep').html('<div class="alert alert-success" role="alert">Cuenta Cobrada Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_agregar_cobro_parquep').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

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
    url: 'jquery_empresa/ingresar_vehiculo.php',
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
      $('.notificacion_ingreso_vehiuclo').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}




var URL_SERVER = '../code_garantia/consultar_parqueadero.php';

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
