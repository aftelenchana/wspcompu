function handleFileSelect(evt) {
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          var span = document.createElement('span');
          span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('miniaturas_productos').insertBefore(span, null);
        };
      })(f);
      reader.readAsDataURL(f);
    }
  }
    document.getElementById('lista').addEventListener('change', handleFileSelect, false);

  // jQuery para actualizar el nombre del archivo en el label
  $(document).ready(function(){
      $('.custom-file-input').on('change', function() {
          // Obtener el nombre del archivo
          var fileName = $(this).val().split('\\').pop();
          // Actualizar el texto del label asociado
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
  });

  $(document).ready(function() {
      $('.paramtero_select2').select2();

      $('.reset-button').on('click', function() {
        const buttonId = $(this).attr('id');
        const selectId = buttonId.replace('reset_button_', 'definitivo_');
        $('#' + selectId).val('0').trigger('change'); // Establece el valor a "Ninguna" y actualiza Select2
    });
    $('.reset-button_presuntivo').on('click', function() {
      const buttonId = $(this).attr('id');
      const selectId = buttonId.replace('presuntivo_reset_button_', 'presuntivo_');
      $('#resuntivo_' + selectId).val('0').trigger('change'); // Establece el valor a "Ninguna" y actualiza Select2
  });

      $('.reset_button_farmaco').on('click', function() {
        const buttonIndex = $(this).attr('data-index');
        $('#medicamento_' + buttonIndex).val('');
        $('#cantidad_' + buttonIndex).val('');
        $('#dosis_' + buttonIndex).val('');
        $('#frecuencia_' + buttonIndex).val('Una vez al día');
        $('#duracion_' + buttonIndex).val('');
        $('#instrucciones_' + buttonIndex).val('');
        console.log(buttonIndex);

    });
  });



function calcularIMC() {
    const peso = parseFloat(document.getElementById('peso').value);
    const talla = parseFloat(document.getElementById('talla').value) / 100; // Convertir cm a m
    const imcInput = document.getElementById('imc');
    const imcAlert = document.getElementById('imc-alert');

    if (!isNaN(peso) && !isNaN(talla) && peso > 0 && talla > 0) {
        const imc = parseFloat((peso / (talla * talla)).toFixed(2)); // Redondear a dos decimales

        imcInput.value = imc.toFixed(2); // Mostrar IMC con dos decimales

        imcAlert.innerHTML = ''; // Limpiar alerta previa
        console.log(imc);

        if (imc < 18.50) {
            imcAlert.innerHTML = '<div class="alert alert-warning">Bajo peso</div>';
        } else if (imc >= 18.50 && imc <= 24.90) {
            imcAlert.innerHTML = '<div class="alert alert-success">Peso normal</div>';
        } else if (imc >= 25.00 && imc < 29.90) {
            imcAlert.innerHTML = '<div class="alert alert-warning">Sobrepeso</div>'; // Cambiar a alert-warning si prefieres
        } else if (imc >= 30.00) {
            imcAlert.innerHTML = '<div class="alert alert-danger">Obesidad</div>'; // Usar alert-danger
        }
    } else {
        imcInput.value = '';
        imcAlert.innerHTML = ''; // Limpiar alerta si los valores no son válidos
    }
}
function calcularTemperatura() {
    const temperatura = parseFloat(document.getElementById('temperatura').value);
    const tempAlert = document.getElementById('temp-alert');

    if (!isNaN(temperatura)) {
        let mensaje = '';
        let claseAlerta = '';

        if (temperatura < 36.1) {
            mensaje = 'Temperatura baja. Esto puede indicar hipotermia. Consulte a un médico si presenta síntomas como fatiga extrema o confusión.';
            claseAlerta = 'alert alert-warning';
        } else if (temperatura >= 36.1 && temperatura <= 37.2) {
            mensaje = 'Temperatura normal.';
            claseAlerta = 'alert alert-success';
        } else if (temperatura > 37.2) {
            mensaje = 'Temperatura alta. Esto puede ser un signo de fiebre o infección. Consulte a un médico si presenta otros síntomas como deshidratación o convulsiones.';
            claseAlerta = 'alert alert-danger';
        }

        tempAlert.innerHTML = `<div class="${claseAlerta}">${mensaje}</div>`;
    } else {
        tempAlert.innerHTML = ''; // Limpiar alerta si el valor no es válido
    }
}


function calcularPresionArterial() {
    const presion = document.getElementById('presion_arterial').value;
    const presionAlert = document.getElementById('presion-alert');

    // Validar que el valor ingresado tenga el formato correcto
    const regex = /^(\d{2,3})\/(\d{2,3})$/;
    const match = presion.match(regex);

    if (match) {
        const sistolica = parseFloat(match[1]);
        const diastolica = parseFloat(match[2]);

        let mensaje = '';
        let claseAlerta = '';

        if (sistolica < 90 || diastolica < 60) {
            mensaje = 'Presión arterial baja. Esto puede causar mareos o fatiga. Consulte a un médico si tiene síntomas.';
            claseAlerta = 'alert alert-warning';
        } else if (sistolica >= 90 && sistolica < 120 && diastolica >= 60 && diastolica < 80) {
            mensaje = 'Presión arterial normal.';
            claseAlerta = 'alert alert-success';
        } else if (sistolica >= 120 && sistolica < 130 && diastolica >= 80 && diastolica < 90) {
            mensaje = 'Presión arterial alta (prehipertensión). Puede ser un signo de riesgo de hipertensión. Consulte a un médico para una evaluación.';
            claseAlerta = 'alert alert-warning';
        } else if (sistolica >= 130 && sistolica < 140 && diastolica >= 80 && diastolica < 90) {
            mensaje = 'Hipertensión Etapa 1. Puede necesitar cambios en el estilo de vida y/o medicación. Consulte a un médico.';
            claseAlerta = 'alert alert-warning';
        } else if (sistolica >= 140 || diastolica >= 90) {
            mensaje = 'Hipertensión Etapa 2. Necesita atención médica urgente para reducir el riesgo de problemas graves de salud.';
            claseAlerta = 'alert alert-danger';
        }

        presionAlert.innerHTML = `<div class="${claseAlerta}">${mensaje}</div>`;
    } else {
        presionAlert.innerHTML = ''; // Limpiar alerta si el formato no es válido
    }
}

function calcularPulso() {
    const pulso = parseFloat(document.getElementById('pulso').value);
    const pulsoAlert = document.getElementById('pulso-alert');

    if (!isNaN(pulso)) {
        let mensaje = '';
        let claseAlerta = '';

        if (pulso < 60) {
            mensaje = 'Pulso bajo. Puede causar mareos o debilidad. Consulte a un médico si presenta síntomas.';
            claseAlerta = 'alert alert-warning';
        } else if (pulso >= 60 && pulso <= 100) {
            mensaje = 'Pulso normal.';
            claseAlerta = 'alert alert-success';
        } else if (pulso > 100) {
            mensaje = 'Pulso alto. Puede causar palpitaciones y dificultad para respirar. Consulte a un médico si presenta otros síntomas.';
            claseAlerta = 'alert alert-danger';
        }

        pulsoAlert.innerHTML = `<div class="${claseAlerta}">${mensaje}</div>`;
    } else {
        pulsoAlert.innerHTML = ''; // Limpiar alerta si el valor no es válido
    }
}

function calcularFrecuenciaRespiratoria() {
    const frecuencia = parseFloat(document.getElementById('frecuencia_respiratoria').value);
    const frecuenciaAlert = document.getElementById('frecuencia-alert');

    if (!isNaN(frecuencia)) {
        let mensaje = '';
        let claseAlerta = '';

        if (frecuencia < 12) {
            mensaje = 'Frecuencia respiratoria baja. Puede ser un signo de problemas respiratorios o neuromusculares. Consulte a un médico si presenta síntomas.';
            claseAlerta = 'alert alert-warning';
        } else if (frecuencia >= 12 && frecuencia <= 20) {
            mensaje = 'Frecuencia respiratoria normal.';
            claseAlerta = 'alert alert-success';
        } else if (frecuencia > 20) {
            mensaje = 'Frecuencia respiratoria alta. Puede ser un signo de fiebre, ansiedad o enfermedad pulmonar. Consulte a un médico si presenta otros síntomas.';
            claseAlerta = 'alert alert-danger';
        }

        frecuenciaAlert.innerHTML = `<div class="${claseAlerta}">${mensaje}</div>`;
    } else {
        frecuenciaAlert.innerHTML = ''; // Limpiar alerta si el valor no es válido
    }
}

function calcularSaturacionOxigeno() {
    const saturacion = parseFloat(document.getElementById('saturacion_oxigeno').value);
    const saturacionAlert = document.getElementById('saturacion-alert');

    if (!isNaN(saturacion)) {
        let mensaje = '';
        let claseAlerta = '';

        if (saturacion < 91) {
            mensaje = 'Saturación de oxígeno muy baja. Puede causar cianosis y dificultad respiratoria severa. Requiere atención médica urgente.';
            claseAlerta = 'alert alert-danger';
        } else if (saturacion >= 91 && saturacion < 95) {
            mensaje = 'Saturación de oxígeno baja. Puede causar dificultad para respirar y fatiga. Consulte a un médico si presenta síntomas.';
            claseAlerta = 'alert alert-warning';
        } else if (saturacion >= 95 && saturacion <= 100) {
            mensaje = 'Saturación de oxígeno normal.';
            claseAlerta = 'alert alert-success';
        }

        saturacionAlert.innerHTML = `<div class="${claseAlerta}">${mensaje}</div>`;
    } else {
        saturacionAlert.innerHTML = ''; // Limpiar alerta si el valor no es válido
    }
}




var btnDictado = document.getElementById('btn_dictado_problema_actual');

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
        document.getElementById('problema_actual').value = resultado;
    };
}




function sendData_antropometria(){
  $('.alerta_antropometria').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#antropometria')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/init_consulta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_antropometria').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_antropometria') {
        $('.alerta_antropometria').html('<div class="alert alert-success background-success">'+
            '<strong>Antropometría Ingresada Correctamente!</strong>'+
        '</div>');
      }

      if (info.noticia == 'error') {
        $('.alerta_antropometria').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> '+info.contenido_error+''+
        '</div>');
      }

      }
    }

  });
}




function sendData_antecedentes_ales(){
  $('.alerta_antecedentes').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#antecedentes_alex')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/init_consulta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_antecedentes').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_antecedentes') {
        $('.alerta_antecedentes').html('<div class="alert alert-success background-success">'+
            '<strong>Revision y Examen Ingresadados Correctamente, '+info.resultado_antecedentes+' !</strong>'+
        '</div>');
      }

      if (info.noticia == 'error') {
        $('.alerta_antecedentes').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> '+info.contenido_error+''+
        '</div>');
      }

      }
    }

  });
}



function sendData_anammesis_alex(){
  $('.alerta_anamesis').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#anammesis_alex')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/init_consulta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_anamesis').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_anamesis') {
        $('.alerta_anamesis').html('<div class="alert alert-success background-success">'+
            '<strong>Datos Ingresados Correctamente!</strong>'+
        '</div>');
      }

      if (info.noticia == 'error') {
        $('.alerta_anamesis').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> '+info.contenido_error+''+
        '</div>');
      }

      }
    }

  });
}



document.addEventListener('DOMContentLoaded', function () {
    window.showAutocomplete = function (input) {
        var palabra_ingresada = input.value;
        var action = 'buscar_productos_farmacias';
        var index = input.getAttribute('data-index');
        var listId = `autocomplete-list_${index}`;
        var list = document.getElementById(listId);

        list.innerHTML = '';
        if (!palabra_ingresada) {
            return false;
        }

        $.ajax({
            url: 'medico/farmacias.php',
            type: 'POST',
            async: true,
            data: { action: action, palabra_ingresada: palabra_ingresada },
            success: function (response) {
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    var medicamentos = info.data;

                    medicamentos.forEach(function (medicamento) {
                        var item = document.createElement('div');
                        item.innerHTML = medicamento.nombre + ' ' + medicamento.marca+ ' '+ medicamento.descripcion+ ' '+ medicamento.descripcion_tienda+ ' '+ medicamento.via_administracion;
                        item.classList.add('autocomplete-item');
                        item.addEventListener('click', function () {
                            input.value = medicamento.nombre + '?' + medicamento.marca+ '?'+ medicamento.descripcion+ '?'+ medicamento.descripcion_tienda+ '?'+ medicamento.via_administracion;
                            list.innerHTML = '';
                        });
                        list.appendChild(item);
                    });
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    };
});



function sendData_receta(){
  $('.alerta_receta').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#receta')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/init_consulta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_receta').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_receta') {
        $('.alerta_receta').html('<div class="alert alert-success background-success">'+
            '<strong>Datos Ingresados Correctamente!  <a class="alert alert-danger" download href="/home/medico/recetas/receta_' + info.codigo_unico + '.pdf">Descargar Receta</a>   </strong>'+
        '</div>');
      }

      if (info.noticia == 'error') {
        $('.alerta_receta').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> '+info.contenido_error+''+
        '</div>');
      }

      }
    }

  });
}



function sendData_documento(){
  $('.alerta_documento').html('<div class="loader animation-start"><span class="circle delay-1 size-2" ></span><span class="circle delay-2 size-4"></span><span class="circle delay-3 size-6"></span><span class="circle delay-4 size-7"></span>'+
  '<span class="circle delay-5 size-7"></span><span class="circle delay-6 size-6"></span><span class="circle delay-7 size-4"></span><span class="circle delay-8 size-2"></span></div>');
  var parametros = new  FormData($('#documento')[0]);
  $.ajax({
    data: parametros,
    url: 'medico/init_consulta.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      if (response =='error') {
        $('.alerta_documento').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_documento') {
        $('.alerta_documento').html('<div class="alert alert-success background-success">'+
            '<strong>Datos Ingresados Correctamente!  <a class="alert alert-danger" download href="/home/medico/certificados/certificado_' + info.codigo_unico + '.pdf">Descargar Certificado</a>   </strong>'+
        '</div>');
      }

      if (info.noticia == 'error') {
        $('.alerta_documento').html('<div class="alert alert-danger background-danger">'+
            '<strong>Error en el servidor!</strong> '+info.contenido_error+''+
        '</div>');
      }

      }
    }

  });
}
