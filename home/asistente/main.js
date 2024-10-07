function start() {
    if (annyang) {
        annyang.setLanguage("es-EC")
        annyang.start({ autoRestart: true, continuous: false });
        console.log("Listening...")

        var texto = "Te estoy escuchando \n";
        var i = 0;
        var agregarTexto = setInterval(function() {
        document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
        i++;
        if (i > texto.length) {
          clearInterval(agregarTexto);
        }
        }, 50);

        annyang.addCommands(comandos);
        annyang.debug()
        document.getElementById("btn").style.display = "none";
}
}

let bandera = false;
annyang.addCallback('soundstart', function () {
    if (!bandera){
        document.getElementById("all2").style.display="block"
        setTimeout(() => {
            voz('Bienvenido')
            bandera = true;
        }, 1000);
    }


    console.log("sound detected")
});

annyang.addCallback('result', function () {
    console.log('sound stopped');
});


const comandos = {
    // SALUDO
    "okey Fernando": () => {
        voz("Bienvenido de nuevo");
    },

    "hey Fernando": () => {
        voz("Bienvenido de nuevo");
    },

    "Buenos días Fernando": () => {
        voz("Benos dias, espero tengas un bonito dia, estoy para servirte en que te puedo ayudar.");
    },

    "Buenas tardes Fernando": () => {
        voz("Buenas tardes, en que te puedo ayudar ");
    },

    "Buenas noches Fernando": () => {
        voz("Buenas noches, hoy a sido un gran dia ! ");
    },

    // DESPEDIDA

    "Hasta mañana Fernando": () => {
        voz("Hasta mañana");
        annyang.abort()
    },

    "Hasta luego Fernando": () => {
        voz("Hasta luego");
        annyang.abort()
    },

    "Adios Fernando": () => {
        voz("Hasta luego");
        annyang.abort()
    },

    "apágate": () => {
        voz('ok, hasta luego')
        annyang.abort();
    },

        "Fernando apágate": () => {
            voz('ok, hasta luego')
            annyang.abort();
        },

    "apágate por *tiempo minutos": tiempo => {
        voz('ok, vuelvo en' + tiempo + 'minutos');
        annyang.abort();
        setTimeout(() => {
            annyang.start();
            voz('Hola, he vuelto, ¿me extrañaste?')
        }, tiempo * 60000);
    },

    // PREGUNTAS

    "qué hora es": () => {
        var date = new Date;
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        voz('son las ' + strTime)
    },
    "Fernando qué hora es": () => {
        var date = new Date;
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        voz('son las ' + strTime)
    },

    "quién te creo": () => {
        voz("Mi creador es  Alex Fernando Telenchana");
        $('.elaces').html('');
        $('#respuesta_escrita_asistente').html('');
        var texto = "\n Mi creador es  Alex Fernando Telenchana";
        var i = 0;
        var agregarTexto = setInterval(function() {
        document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
        i++;
        if (i > texto.length) {
          clearInterval(agregarTexto);
        }
        }, 50);
    },

    "Fernanda empezar": () => {
    $('.elaces').html('');
      $('#respuesta_escrita_asistente').html('');
      var busqueda = 'Fernanda los pasos para la facturación';
      var action = 'busqueda';
      $.ajax({
        url:'/home/jquery_asistente/asistente.php',
        type:'POST',
        async: true,
        data: {action:action,busqueda:busqueda},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
             if (info.primer_paso == 'firma_electronica') {
               if (info.exixte_firma != '') {
                 var texto = ''+info.nombres+' Ya tienes una firma en guibis.com! Si deseas cambiar sigue el enlace o sube tu firma en  la siguiente ventana';
                 voz(''+info.nombres+' Ya tienes una firma en guibis.com! Si deseas cambiar sigue el enlace o sube tu firma en  la siguiente ventana');
                   $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Editar firma Electrónica</a>');
                 var i = 0;
                 var agregarTexto = setInterval(function() {
                 document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                 i++;
                 if (i > texto.length) {
                   clearInterval(agregarTexto);
                 }
                 }, 50);
                 setTimeout(function() {
                  $('#exampleModalLong').modal();
                }, 5000);
               }else {
                 var agregarTexto = ''+info.nombres+' No tienes una firma en nuestro sitio por favor sigue el enlace o sube en la ventana emergente';
                 $('.elaces').html('<a class="btn btn-info"  href="https://guibis.com">Agregar firma Electrónica</a>');
                 var agregarTexto = setInterval(function() {
                 document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                 i++;
                 if (i > texto.length) {
                   clearInterval(agregarTexto);
                 }
                 }, 50);
                voz(''+info.nombres+' No tienes una firma en nuestro sitio por favor sigue el enlace o sube en la ventana emergente');
                setTimeout(function() {
                 $('#exampleModalLong').modal();
               }, 5000);
               }
             }else {
             }
             if (info.tip_respuesta == 'varios_usarios') {
                voz(info.respuesta_varios_usuarios);
                document.getElementById("text").innerHTML = info.salida_inter_general;
             }
             if (info.tip_respuesta == 'sin_resultados') {
                voz(info.respuesta_sinresultados);
                  document.getElementById("text").innerHTML = '';
             }
           }
         },
         error:function(error){
           console.log(error);
           }

         });
    },


    "Fernanda la clave": () => {
    $('.elaces').html('');
      $('#respuesta_escrita_asistente').html('');
      var busqueda = 'Fernanda la clave';
      var action = 'busqueda';
      $.ajax({
        url:'/home/jquery_asistente/asistente.php',
        type:'POST',
        async: true,
        data: {action:action,busqueda:busqueda},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
             if (info.parametro == 'clave_firma') {
               if (info.clave_firma != '') {
                 var texto = ''+info.nombres+' Ya tienes una clave dentro de nuestro sistema';
                 voz(''+info.nombres+' Ya tienes una clave dentro de nuestro sistema');
                   $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Editar firma Electrónica</a>');
                 var i = 0;
                 var agregarTexto = setInterval(function() {
                 document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                 i++;
                 if (i > texto.length) {
                   clearInterval(agregarTexto);
                 }
                 }, 50);
                 setTimeout(function() {
                  $('#modal_clave_firna').modal();
                }, 5000);
               }else {
                 var agregarTexto = ''+info.nombres+' No tienes una clave dentro de nuestro sistema';
                 $('.elaces').html('<a class="btn btn-info"  href="https://guibis.com">Agregar firma Electrónica</a>');
                 var agregarTexto = setInterval(function() {
                 document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                 i++;
                 if (i > texto.length) {
                   clearInterval(agregarTexto);
                 }
                 }, 50);
                voz(''+info.nombres+' No tienes una clave dentro nuestro sistema');
                setTimeout(function() {
                 $('#modal_clave_firna').modal();
               }, 5000);
               }
             }else {
             }
             if (info.tip_respuesta == 'varios_usarios') {
                voz(info.respuesta_varios_usuarios);
                document.getElementById("text").innerHTML = info.salida_inter_general;
             }
             if (info.tip_respuesta == 'sin_resultados') {
                voz(info.respuesta_sinresultados);
                  document.getElementById("text").innerHTML = '';
             }
           }
         },
         error:function(error){
           console.log(error);
           }

         });
    },


        "Fernanda el logo": () => {
        $('.elaces').html('');
          $('#respuesta_escrita_asistente').html('');
          var busqueda = 'Fernanda el logo';
          var action = 'busqueda';
          $.ajax({
            url:'/home/jquery_asistente/asistente.php',
            type:'POST',
            async: true,
            data: {action:action,busqueda:busqueda},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                 var info = JSON.parse(response);
                 if (info.parametro == 'img_logo') {
                   if (info.img_logo != '') {
                     var texto = ''+info.nombres+' Ya tienes un logo en guibis';
                     voz(''+info.nombres+' Ya tienes un logo en guibis');
                       $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Editar firma Electrónica</a>');
                     var i = 0;
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                     setTimeout(function() {
                      $('#modal_logo_empresa_asistente').modal();
                    }, 5000);
                   }else {
                     var agregarTexto = ''+info.nombres+' No tienes una logo agregar un logo siguiendo el enlace o en la sieguiente ventana';
                     $('.elaces').html('<a class="btn btn-info"  href="https://guibis.com">Agregar firma Electrónica</a>');
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                    voz(''+info.nombres+' No tienes una logo agregar un logo siguiendo el enlace o en la sieguiente ventana');
                    setTimeout(function() {
                     $('#modal_logo_empresa_asistente').modal();
                   }, 5000);
                   }
                 }else {
                 }
                 if (info.tip_respuesta == 'varios_usarios') {
                    voz(info.respuesta_varios_usuarios);
                    document.getElementById("text").innerHTML = info.salida_inter_general;
                 }
                 if (info.tip_respuesta == 'sin_resultados') {
                    voz(info.respuesta_sinresultados);
                      document.getElementById("text").innerHTML = '';
                 }
               }
             },
             error:function(error){
               console.log(error);
               }

             });
        },


        "Fernanda la dirección": () => {
        $('.elaces').html('');
          $('#respuesta_escrita_asistente').html('');
          var busqueda = 'Fernanda la dirección';
          var action = 'busqueda';
          $.ajax({
            url:'/home/jquery_asistente/asistente.php',
            type:'POST',
            async: true,
            data: {action:action,busqueda:busqueda},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                 var info = JSON.parse(response);
                 if (info.parametro == 'direccion') {
                   if (info.direccion != '') {

                     var texto = ''+info.nombres+' Ya tienes actualizada tu dirección en '+info.direccion+' puedes editarlo en la siguiente ventana';
                     voz(''+info.nombres+' Ya tienes actualizada tu dirección en '+info.direccion+' puedes editarlo en la siguiente ventana');
                       $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Editar firma Electrónica</a>');
                     var i = 0;
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                     setTimeout(function() {
                      $('#modal_direccion_asistente').modal();
                    }, 6000);

                   }else {
                     var agregarTexto = ''+info.nombres+' No tienes una dirección en nuestro sitio';
                     $('.elaces').html('<a class="btn btn-info"  href="https://guibis.com">Agregar firma Electrónica</a>');
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                    voz(''+info.nombres+' No tienes una dirección en nuestro sitio');
                    setTimeout(function() {
                     $('#modal_direccion_asistente').modal();
                   }, 5000);
                   }
                 }else {
                 }

               }
             },
             error:function(error){
               console.log(error);
               }

             });
        },



        "Fernanda subir un producto": () => {
        $('.elaces').html('');
          $('#respuesta_escrita_asistente').html('');
          var busqueda = 'Fernanda subir un producto';
          var action = 'busqueda';
          $.ajax({
            url:'/home/jquery_asistente/asistente.php',
            type:'POST',
            async: true,
            data: {action:action,busqueda:busqueda},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                 var info = JSON.parse(response);
                 if (info.parametro == 'subir_producto') {

                   if (info.existencia_proveedor == 'NO') {
                     var texto = ''+info.nombres+' para subir un producto se necesita primero subir un proveedor, ten en cuenta que cuando procesas materia tu eres tu propio proveedor';
                     voz(''+info.nombres+' para subir un producto se necesita primero subir un proveedor, ten en cuenta que cuando procesas materia tu eres tu propio proveedor');
                       $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Subir Proveedor</a>');
                     var i = 0;
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                     setTimeout(function() {
                       $('#modal_subir_proveedor_asistente').modal();
                    }, 6000);

                   }else {
                     var texto = ''+info.nombres+' sube tu producto en la siguiente ventana';
                     voz(''+info.nombres+' sube tu producto en la siguiente ventana');
                       $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Subir Producto</a>');
                     var i = 0;
                     var agregarTexto = setInterval(function() {
                     document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
                     i++;
                     if (i > texto.length) {
                       clearInterval(agregarTexto);
                     }
                     }, 50);
                     setTimeout(function() {
                          $('#modal_subir_producto_asistente').modal();

                    }, 4000);
                   }
                 }else {
                 }

               }
             },
             error:function(error){
               console.log(error);
               }

             });
        },





    "Fernanda subir un proveedor": () => {
      var busqueda = 'Fernanda subir un proveedor';
      var action = 'busqueda';
      $.ajax({
        url:'/home/jquery_asistente/asistente.php',
        type:'POST',
        async: true,
        data: {action:action,busqueda:busqueda},
         success: function(response){
           console.log(response);
           if (response != 'error') {
             var info = JSON.parse(response);
             var texto = ''+info.nombres+' sube un proveedor en la siguiente ventana';
             voz(''+info.nombres+' sube un proveedor en la siguiente ventanar');
               $('.elaces').html('<a class="btn btn-info" href="https://guibis.com">Subir Proveedor</a>');
             var i = 0;
             var agregarTexto = setInterval(function() {
             document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
             i++;
             if (i > texto.length) {
               clearInterval(agregarTexto);
             }
             }, 50);
             setTimeout(function() {
               $('#modal_subir_proveedor_asistente').modal();
            }, 5000);


           }
         },
         error:function(error){
           console.log(error);
           }

         });









    },

    "qué eres": () => {
        voz("Soy un asistente virtual, que ayuda a las personas a realizar comercio electronico, te enseña como utilizar nuestras herramientas y te da asesoramiento en comprar y vender por internet");
    },
    "Fernando qué eres": () => {
        voz("Soy un asistente virtual, que ayuda a las personas a realizar comercio electronico, te enseña como utilizar nuestras herramientas y te da asesoramiento en comprar y vender por internet");
    },

    "cuál es tu nombre": () => {
      voz("Mi nombre es Fernanda, soy la inteligencia artificial creada para la plataforma guibis.com");
      $('#respuesta_escrita_asistente').html('');
        $('.elaces').html('<a href="https://guibis.com">Guibis.com</a>');
      var texto = "Mi nombre es Fernanda, soy la inteligencia artificial creada para la plataforma guibis.com";
      var i = 0;
      var agregarTexto = setInterval(function() {
      document.getElementById("respuesta_escrita_asistente").innerHTML += texto.charAt(i);
      i++;
      if (i > texto.length) {
        clearInterval(agregarTexto);
      }
      }, 50);
    },

    "qué fecha es hoy": () => {
        var date = new Date;
        var mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"]
        voz("hoy es " + date.getDate() + " de "+ mes[date.getMonth()] + "del" + date.getFullYear());
    },
    "Fernando qué fecha es hoy": () => {
        var date = new Date;
        var mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"]
        voz("hoy es " + date.getDate() + " de "+ mes[date.getMonth()] + "del" + date.getFullYear());
    },


    "qué día es hoy": () => {
        var date = new Date;
        var dia = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"]
        voz("hoy es "+ dia[date.getDay()-1]);
    },
    "Fernando qué día es hoy": () => {
        var date = new Date;
        var dia = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"]
        voz("hoy es "+ dia[date.getDay()-1]);
    },
    "mundo": () => {

        voz("hoy es mundo ");
    },

    // ORDENES

    "cuéntame un chiste": () => {
        var chistes = ["¿Por qué las focas del circo miran siempre hacia arriba?, Porque es donde están los focos",
            "¡Estás obsesionado con la comida!, No sé a que te refieres croquetamente",
            "¿Por qué estás hablando con esas zapatillas?, Porque pone converse",
            "¿Sabes cómo se queda un mago después de comer?, magordito",
            "Me da un café con leche corto, Se me ha roto la máquina, cambio",
            "¡Camarero! Este filete tiene muchos nervios, Normal, es la primera vez que se lo comen",
            "Hola, ¿está Agustín?, No, estoy incomodín",
            "¿Cuál es la fruta más divertida?, la naranja ja ja"];

        var ran = Math.floor(Math.random() * chistes.length);
        voz(chistes[ran])
    },

    "reiniciate": () => {
        voz("entendido");
        location.reload();
    },

    "limpia la consola": () => {
        voz("entendido");
        console.clear();
    },

    "Fernando busca *busqueda": busqueda => {
        voz("ok, buscando " + busqueda +" para ti");
        window.open("https://www.google.com/search?q=" + busqueda)
    },

    "Fernando quiero escuchar *busqueda": busqueda => {
        voz("ok, buscando " + busqueda + "para ti");
        window.open("https://www.youtube.com/results?search_query=" + busqueda)
    },
    "Fernando todo sobre *busqueda": busqueda => {
        voz("ok, buscando" + busqueda);
        var busqueda = busqueda;
        var action = 'busqueda_empresa';
        $.ajax({
          url:'/home/jquery_asistente/asistente.php',
          type:'POST',
          async: true,
          data: {action:action,busqueda:busqueda},
           success: function(response){
             console.log(response);
             if (response != 'error') {
               var info = JSON.parse(response);
               if (info.tip_respuesta == 'unico_usuario') {
                 voz(info.respuesta_unico_usuario);

               }
               if (info.tip_respuesta == 'varios_usarios') {
                  voz(info.respuesta_varios_usuarios);
                  document.getElementById("text").innerHTML = info.salida_inter_general;

               }
               if (info.tip_respuesta == 'sin_resultados') {
                  voz(info.respuesta_sinresultados);
                    document.getElementById("text").innerHTML = '';

               }

             }
           },
           error:function(error){
             console.log(error);
             }

           });
    },



    "llama al *telefono": telefono => {
        voz("ok, con gusto llamando al" + telefono);
        window.open("tel:" + telefono)
    },

    "di *frase": frase => {
        voz(frase);
    },
    "Fernando escribe *dicto": dicto =>{
        document.getElementById("text").innerHTML = dicto;
    },
    // AMABILIDAD

    "gracias": () => {
        voz("Para servirte Alex");
    },
    "Fernando gracias": () => {
        voz("Para servirte Alex");
    },
    "gracias Fernando": () => {
        voz("Para servirte Alex");
    },
    "Gracias Fernando": () => {
        voz("Para servirte Alex");
    },

    "Cómo estás": () => {
        voz('mejor que ayer, espero que usted tambien lo esté.')
    },

    "Te presento a *nombre": nombre => {
        voz("Hola" + nombre +", mi nombre es Fernando, es un placer conocerte");
    },

    // LLAMADA A LA ACCIÓN

    "Fernando": () => {
        voz("aquí estoy, en que te puedo ayudar");
    },

    "Hey": () => {
        voz("aquí estoy, en que te puedo ayudar");
    },

    "Hola": () => {
        voz("aquí estoy, en que te puedo ayudar");
    },

    "Me puedes ayudar": () => {
        voz("claro que sí");
    },

    "Oye": () => {
        voz("aquí estoy, en que te puedo ayudar");
    },

    "Estás ahí": () => {
        voz("aquí estoy, en que te puedo ayudar");
    }

}

function voz(texto) {
    document.getElementById("all2").style.visibility = "hidden";
    var textoAEscuchar = texto;
    var mensaje = new SpeechSynthesisUtterance();
    mensaje.text = textoAEscuchar;
    mensaje.volume = 1;
    mensaje.rate = 0.9;
    mensaje.pitch = 1;
    // ¡Parla!
    document.getElementById("all").style.visibility = "visible";
    setTimeout(() => {
        document.getElementById("all").style.visibility = "hidden";
        document.getElementById("all2").style.visibility = "visible";
    }, 4000);
    speechSynthesis.speak(mensaje);
}
