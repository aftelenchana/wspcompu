var URL_SERVER = '../../home/code_garantia/resultado_busqueda.php';
function guardar_codigo_escaneado(result_qr){

  var data = {
    'codigo': result_qr
  };
  $.ajax({
      type: 'POST',
      url: URL_SERVER,
      data: data,
      dataType: 'html',
      success: function(datos){
      $("#resultado").html(datos);
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
