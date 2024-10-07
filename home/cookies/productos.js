
var btnDictado = document.getElementById('btn_clientesdictado_producto');

// Verifica qué API de reconocimiento de voz está disponible
var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
if (typeof SpeechRecognition !== 'undefined') {
    var reconocimientoVoz = new SpeechRecognition();
    reconocimientoVoz.lang = 'es-ES';
} else {
    // Manejar el caso cuando el reconocimiento de voz no está disponible
    btnDictado.disabled = true;
    btnDictado.textContent = 'Incompatible con el Navegador';
}

btnDictado.addEventListener('click', function() {
    if (typeof SpeechRecognition !== 'undefined') {
        reconocimientoVoz.start();
    } else {
        // Manejar el caso cuando el reconocimiento de voz no está disponible
        alert('El dictado por voz no está soportado en este navegador');
    }
});

if (typeof reconocimientoVoz !== 'undefined') {
    reconocimientoVoz.onresult = function(event) {
        var resultado = event.results[0][0].transcript;
        document.getElementById('descripcion').value = resultado;
    };
}



// Función para establecer una cookie con SameSite=none y Secure=true
function setCookie(nombre, valor) {
 // Obtener la URL del sitio actual
 const url = window.location.href;
 // Verificar si el sitio se encuentra en una conexión HTTPS segura
 const secureFlag = url.startsWith('https://') ? ';secure' : '';
 // Configurar la cookie con SameSite=none y el atributo Secure, si corresponde
 document.cookie = `${nombre}=${encodeURIComponent(valor)};path=/;SameSite=None${secureFlag}`;
}

// Función para obtener el valor de una cookie
function getCookie(nombre) {
 const cookies = document.cookie.split(';');
 for (let i = 0; i < cookies.length; i++) {
   const cookie = cookies[i].trim();
   if (cookie.startsWith(`${nombre}=`)) {
     return decodeURIComponent(cookie.substring(nombre.length + 1));
   }
 }
 return null;
}

// Función para guardar los datos del formulario en cookies automáticamente
function guardarDatosAutomaticamente() {
  const formulario = document.getElementById('add_producto');
  const inputs = formulario.getElementsByTagName('input');
  const textareas = formulario.getElementsByTagName('textarea');

  for (let i = 0; i < inputs.length; i++) {
    const campoName = inputs[i].name;
    const valorCampo = inputs[i].value;

    // Saltar la configuración de la cookie si el nombre del campo es "action"
    if (campoName === 'action') {
      continue;
    }

    //console.log(`Guardando en cookie: ${campoName} = ${valorCampo}`);
    setCookie(campoName, valorCampo);
  }

  for (let i = 0; i < textareas.length; i++) {
    const campoName = textareas[i].name;
    const valorCampo = textareas[i].value;

    // Saltar la configuración de la cookie si el nombre del campo es "action"
    if (campoName === 'action') {
      continue;
    }

    //console.log(`Guardando en cookie: ${campoName} = ${valorCampo}`);
    setCookie(campoName, valorCampo);
  }
}

// Resto del código para establecer y obtener cookies (setCookie y getCookie) ...

// Asociar evento "input" a todos los campos del formulario para guardar automáticamente
window.addEventListener('load', function() {
 const formulario = document.getElementById('add_producto');
 const inputs = formulario.getElementsByTagName('input');
 const textareas = formulario.getElementsByTagName('textarea');

 for (let i = 0; i < inputs.length; i++) {
   inputs[i].addEventListener('input', guardarDatosAutomaticamente);
   const campoName = inputs[i].name;
   const valorGuardado = getCookie(campoName);
   if (valorGuardado) {
     //console.log(`Recuperando de cookie: ${campoName} = ${valorGuardado}`);
     inputs[i].value = valorGuardado;
   }
 }

 for (let i = 0; i < textareas.length; i++) {
   textareas[i].addEventListener('input', guardarDatosAutomaticamente);
   const campoName = textareas[i].name;
   const valorGuardado = getCookie(campoName);
   if (valorGuardado) {
    // console.log(`Recuperando de cookie: ${campoName} = ${valorGuardado}`);
     textareas[i].value = valorGuardado;
   }
 }
});


function limpiarFormulario() {
  const formulario = document.getElementById('add_producto');
  const inputs = formulario.getElementsByTagName('input');
  const textareas = formulario.getElementsByTagName('textarea');

  // Limpiar los campos del formulario
  for (let i = 0; i < inputs.length; i++) {
    inputs[i].value = "";
    const campoName = inputs[i].name;
    setCookie(campoName, ""); // Establecer el valor de la cookie como una cadena vacía
  }

  for (let i = 0; i < textareas.length; i++) {
    textareas[i].value = "";
    const campoName = textareas[i].name;
    setCookie(campoName, ""); // Establecer el valor de la cookie como una cadena vacía
  }
}
