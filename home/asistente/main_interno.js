document.getElementById("text").style.visibility = "hidden";
function start() {
    if (annyang) {
        annyang.setLanguage("es-CO")
        annyang.start({ autoRestart: true, continuous: false });
        console.log("Listening...")
        annyang.addCommands(comandos);
        annyang.debug()
        document.getElementById("btn").style.display = "none";
}
}
var nombre_usuario = document.getElementById('nombre_usuario').value;
var perfil_tienda_visitada = document.getElementById('perfil').value;
let bandera = false;
annyang.addCallback('soundstart', function () {
    if (!bandera){
        document.getElementById("all2").style.display="block"
        setTimeout(() => {
            voz('Bienvenido de nuevo '+nombre_usuario+'')
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
    "okey Fernanda": () => {
        voz('Bienvenido de nuevo '+nombre_usuario+' ');
    },

    "hey Fernanda": () => {
        voz('Bienvenido de nuevo '+nombre_usuario+'');
    },

    "Buenos días Fernanda": () => {
        voz('Benos dias '+nombre_usuario+', espero tengas un bonito dia, estoy para servirte en que te puedo ayudar.');
    },

    "Buenas tardes Fernanda": () => {
        voz('Buenas tardes '+nombre_usuario+', en que te puedo ayudar');
    },

    "Buenas noches Fernanda": () => {
        voz('Buenas noches '+nombre_usuario+', hoy a sido un gran dia !');
    },

    // DESPEDIDA

    "Hasta mañana Fernanda": () => {
        voz('Hasta mañana '+nombre_usuario +'');
        annyang.abort()
    },

    "Hasta luego Fernanda": () => {
        voz('Hasta luego '+nombre_usuario +'');
        annyang.abort()
    },

    "Adios Fernanda": () => {
        voz('Hasta luego  '+nombre_usuario +' ');
        annyang.abort()
    },

    "apágate": () => {
        voz('ok, hasta luego '+nombre_usuario +'')
        annyang.abort();
    },

        "Fernanda apágate": () => {
            voz('ok, hasta luego '+nombre_usuario +'')
            annyang.abort();
        },

    "apágate por *tiempo minutos": tiempo => {
        voz('ok, vuelvo en' + tiempo + 'minutos '+nombre_usuario +'');
        annyang.abort();
        setTimeout(() => {
            annyang.start();
            voz('Hola, '+nombre_usuario+' he vuelto, ¿me extrañaste?')
        }, tiempo * 60000);
    },
    "apaga te por *tiempo minutos": tiempo => {
        voz('ok, vuelvo en' + tiempo + 'minutos '+nombre_usuario +'');
        annyang.abort();
        setTimeout(() => {
            annyang.start();
            voz('Hola, '+nombre_usuario+' he vuelto, ¿me extrañaste?')
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

        voz('son las ' + strTime + nombre_usuario )
    },
    "Fernanda qué hora es": () => {
        var date = new Date;
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        voz('son las ' + strTime + nombre_usuario)
    },

    "quién te creo": () => {
        voz("Mi creador es  Alex Fernando Telenchana.");
    },
    "Fernanda quién te creo": () => {
        voz("Mi creador es  Alex Fernando Telenchana.");
    },

    "qué eres": () => {
        voz("Soy un asistente virtual, que ayuda a las personas a realizar comercio electronico, te enseña como utilizar nuestras herramientas y te da asesoramiento en comprar y vender por internet");
    },
    "Fernanda qué eres": () => {
        voz("Soy un asistente virtual, que ayuda a las personas a realizar comercio electronico, te enseña como utilizar nuestras herramientas y te da asesoramiento en comprar y vender por internet");
    },

    "cuál es tu nombre": () => {
        voz("Mi nombre es Fernanda");
    },

    "qué fecha es hoy": () => {
        var date = new Date;
        var mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"]
        voz("hoy es " + date.getDate() + " de "+ mes[date.getMonth()] + "del" + date.getFullYear());
    },
    "Fernanda qué fecha es hoy": () => {
        var date = new Date;
        var mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"]
        voz("hoy es " + date.getDate() + " de "+ mes[date.getMonth()] + "del" + date.getFullYear());
    },


    "qué día es hoy": () => {
        var date = new Date;
        var dia = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"]
        voz("hoy es "+ dia[date.getDay()-1]);
    },
    "Fernanda qué día es hoy": () => {
        var date = new Date;
        var dia = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"]
        voz("hoy es "+ dia[date.getDay()-1]);
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
        voz("entendido" + nombre_usuario);
        console.clear();
    },
    "Fernanda limpia la consola": () => {
        voz("entendido" + nombre_usuario);
        console.clear();
    },

    "Fernanda busca *busqueda": busqueda => {
        voz("ok, buscando " + busqueda +" para ti");
        window.open("https://www.google.com/search?q=" + busqueda  + nombre_usuario)
    },

    "Fernanda quiero escuchar *busqueda": busqueda => {
        voz("ok, buscando " + busqueda  + nombre_usuario);
        window.open("https://www.youtube.com/results?search_query=" + busqueda)
    },
    "Fernanda todo sobre *busqueda": busqueda => {
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
               voz(info.respuesta);

             }
           },
           error:function(error){
             console.log(error);
             }

           });
    },

    "Fernanda estado de esta tienda":() => {
        var perfil = perfil_tienda_visitada;
        var action = 'estado_tienda';
        $.ajax({
          url:'/home/jquery_asistente/asistente_interno.php',
          type:'POST',
          async: true,
          data: {action:action,perfil:perfil},
           success: function(response){
             console.log(response);
             if (response != 'error') {
               var info = JSON.parse(response);
               voz(info.respuesta);


             }
           },
           error:function(error){
             console.log(error);
             }

           });
    },
    "Fernanda el producto mas vendido":() => {
        var perfil = perfil_tienda_visitada;
        var action = 'producto_mas_vendido';
        $.ajax({
          url:'/home/jquery_asistente/asistente_interno.php',
          type:'POST',
          async: true,
          data: {action:action,perfil:perfil},
           success: function(response){
             console.log(response);
             if (response != 'error') {
               var info = JSON.parse(response);
               voz(info.respuesta);


             }
           },
           error:function(error){
             console.log(error);
             }

           });
    },



    "llama al *telefono": telefono => {
        voz('ok '+nombre_usuario+', con gusto llamando al' + telefono );
        window.open("tel:" + telefono)
    },

    "di *frase": frase => {
        voz(frase);
    },
    "Fernanda escribe *dicto": dicto =>{
        document.getElementById("text").style.visibility = "visible";
        document.getElementById("text").innerHTML = dicto;
    },

    // AMABILIDAD

    "gracias": () => {
        voz("Para servirte" +nombre_usuario);
    },
    "Fernanda gracias": () => {
        voz("Para servirte " +nombre_usuario);
    },
    "gracias Fernanda": () => {
        voz("Para servirte " +nombre_usuario);
    },
    "Gracias Fernanda": () => {
        voz("Para servirte" +nombre_usuario);
    },

    "Cómo estás": () => {
        voz('mejor que ayer, espero que usted tambien lo esté.')
    },

    "Te presento a *nombre": nombre => {
        voz("Hola" + nombre +", mi nombre es Fernanda, es un placer conocerte");
    },

    // LLAMADA A LA ACCIÓN

    "Fernanda": () => {
        voz('aquí estoy '+nombre_usuario+' , en que te puedo ayudar');
    },

    "Hey": () => {
        voz('aquí estoy '+nombre_usuario+', en que te puedo ayudar');
    },

    "Hola": () => {
        voz('aquí estoy '+nombre_usuario+', en que te puedo ayudar');
    },

    "Me puedes ayudar": () => {
        voz("claro que sí" +nombre_usuario);
    },

    "Oye": () => {
        voz("aquí estoy, en que te puedo ayudar" +nombre_usuario);
    },

    "Estás ahí": () => {
        voz("aquí estoy, en que te puedo ayudar" +nombre_usuario);
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
