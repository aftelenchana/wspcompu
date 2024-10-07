<?php

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


  session_start();
  if (!empty($_SESSION['active'])) {
    header('location:home/');
  }


if (isset($_COOKIE['session_token'])) {
    $sessionToken = $_COOKIE['session_token'];

} else {
  $sessionToken = bin2hex(random_bytes(32));
  setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
}

 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

 //INFORMACION DE CONFIGURACION
  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];

  function getRealIP() {
      if (isset($_SERVER["HTTP_CLIENT_IP"])) {
          return $_SERVER["HTTP_CLIENT_IP"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
          return $_SERVER["HTTP_X_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
          return $_SERVER["HTTP_X_FORWARDED"];
      } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
          return $_SERVER["HTTP_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
          return $_SERVER["HTTP_FORWARDED"];
      } else {
          return $_SERVER["REMOTE_ADDR"];
      }
  }


  if ($ambito_area == 'prueba') {
      $direccion_ip = '186.42.9.232';
  } elseif ($ambito_area == 'produccion') {
      $direccion_ip = getRealIP();
  }

  //codigo para verificar la existencia de la direccion ip
  $query_insert_busqueda=mysqli_query($conection,"INSERT INTO vivitas_generales(direccion_ip)
                       VALUES('$direccion_ip') ");


                       // Asumimos que la sesión está activa y tenemos la información del dominio
                       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
                       $domain = $_SERVER['HTTP_HOST'];

                       $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
                       $result_documentos = mysqli_fetch_array($query_doccumentos);

                       if ($result_documentos) {
                           $url_img_upload = $result_documentos['url_img_upload'];
                           $img_facturacion = $result_documentos['img_facturacion'];
                           $nombre_empresa = $result_documentos['nombre_empresa'];
                           $celular        = $result_documentos['celular'];
                           $email        = $result_documentos['email'];
                           $facebook                = $result_documentos['facebook'];
                           $instagram           = $result_documentos['instagram'];
                           $whatsapp             = $result_documentos['whatsapp'];

                           // Asegúrate de que esta ruta sea correcta y corresponda con la estructura de tu sistema de archivos
                           $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;
                       } else {
                           // Si no hay resultados, tal vez quieras definir una imagen por defecto
                         $img_sistema = '/img/guibis.png';
                       }


 ?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Emergencia <?php echo $nombre_empresa ?></title>

  <!-- Site Metas -->
  <meta property="og:locale" content="es_ES" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo $nombre_empresa ?>" />
  <meta property="og:description" content="<?php echo $nombre_empresa ?> Bienvenido a Rezeta, la plataforma revolucionaria diseñada para simplificar y optimizar la gestión médica. En Rezeta, nos dedicamos a proporcionar a
  los profesionales de la salud una solución integral que facilita la administración de pacientes, la gestión de recetas y la coordinación de tratamientos." />
  <meta property="og:image" content="<?php echo $img_sistema ?>">
  <meta property="og:url" content="<?php echo $url ?>" />
  <link rel="icon" href="<?php echo $img_sistema ?>">
  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin="" />
</head>
<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <div class="top_contact-container">
          <div class="tel_container">
            <a href="">
              <img src="images/telephone-symbol-button.png" alt=""> Contacto : <?php echo $celular ?>
            </a>
          </div>
          <div class="social-container">
            <a target="_blank" href="<?php echo $facebook ?>">
              <img src="images/fb.png"  alt="" class="s-1">
            </a>
            <a target="_blank" href="<?php echo $instagram ?>">
              <img src="images/instagram.png" alt="" class="s-3">
            </a>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="/">
            <img src="<?php echo $img_sistema ?>" alt="">
            <span>
              REZETA
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex  flex-column flex-lg-row align-items-center w-100 justify-content-between">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="emergencia"> Emergencia </a>
                </li>
              </ul>

              <div class="login_btn-contanier ml-0 ml-lg-5">
                <a href="login">
                  <img src="images/user.png" alt="">
                  <span>
                    Entrar
                  </span>
                </a>
              </div>
            </div>
          </div>

        </nav>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="images/medicine.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Bienvenido a  <br>
                      <span>
                        <?php echo $nombre_empresa ?>
                      </span>

                    </h1>
                    <p>
                    La plataforma revolucionaria diseñada para simplificar y optimizar la gestión médica. En Rezeta, nos dedicamos a proporcionar a los profesionales de la salud una solución integral que facilita la administración de pacientes, la gestión de recetas y la coordinación de tratamientos.
                    </p>
                    <div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="images/medicine.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Bienvenido a  <br>
                      <span>
                        Rezeta
                      </span>

                    </h1>
                    <p>
                    En <?php echo $nombre_empresa ?>, estamos comprometidos con la innovación y la calidad en la atención médica. Nuestra plataforma está diseñada para adaptarse a tus necesidades y mejorar la gestión de tu práctica médica. Únete a nosotros y experimenta una nueva forma de trabajar con Rezeta.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="sr-only">Next</span>
        </a>
      </div>


    </section>
    <!-- end slider section -->
  </div>



  <section class="contact_section">
    <div class="container">
      <div class="row">
        <div class="custom_heading-container ">
          <h2>
            Emergencia
          </h2>
        </div>
      </div>
    </div>
    <div class="container layout_padding2">
      <div class="row">
        <div class="col-md-5">
          <div class="form_contaier">
            <form method="post" name="contactanos" id="contactanos" onsubmit="event.preventDefault(); sendData_contactanos();">
              <div class="form-group">
                <label for="exampleInputEmail1">Identificación </label>
                <input type="text" name="identificacion" class="form-control ocupar_api_sacar_informacion" id="exampleInputEmail1">
              </div>
              <div class="form-group">
                <label for="exampleInputName1">Nombres</label>
                <input type="text" required name="nombres" class="form-control resultado_nombres_consumo_api" id="exampleInputName1">
              </div>
              <div class="form-group">
                <label for="exampleInputNumber1">Celular</label>
                <input type="text" name="celular" class="form-control" id="exampleInputNumber1">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Email </label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1">
              </div>

              <div class="form-group">
                <label for="exampleInputMessage">Descripción</label>
                <input type="text" required name="mensaje" class="form-control" id="exampleInputMessage">
              </div>
              <input type="hidden" name="latitud" id="latitud" value="">
              <input type="hidden" name="longitud" id="longitud" value="">
              <input type="hidden" name="action" value="ingreso_emegergencia">
              <button type="submit" class="">Enviar</button>

              <div class="notificacion_contactanos">

              </div>
            </form>
          </div>
        </div>
        <div class="col-md-7">
          <div class="detail-box">
            <h3>
              Rezeta
            </h3>
            <p>
              <div class="container mt-5">
                 <button id="activateLocation" class="btn btn-primary btn-lg">
                     <i class="fas fa-map-marker-alt"></i> Activar Ubicación
                 </button>
             </div>

             <div class="resultado_cuando_la_ubicacion_si">

             </div>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $fechaActual = time();
$anio = date("Y", $fechaActual);
   ?>
  <section class="container-fluid footer_section">
    <p>
      &copy; <?php echo $anio ?> Todos los derechos reservados. Desarrollado por
      <a href="https://guibis.com">guibis.com</a>
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
  </script>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
    integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
    crossorigin=""></script>
    <script src="home/apis/api_sri.js?v=4"></script>

  <script type="text/javascript">
  function sendData_contactanos(){
     $('.notificacion_contactanos').html('<div class="proceso">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
     '</div>');
    var parametros = new FormData($('#contactanos')[0]);

    $.ajax({
      data: parametros,
      url: 'java/contactanos.php',
      type: 'POST',
      contentType: false,
      processData: false,
      beforesend: function(){

      },
      success: function(response){
        console.log(response);

        if (response =='error') {
          $('.notificacion_contactanos').html('<p class="alerta_negativa">Error al insertar el producto</p>')
        }else {
        var info = JSON.parse(response);
        if (info.resp_emergencia == 'positiva') {
          $('.notificacion_contactanos').html('<div class="alert alert-success" role="alert">Emergencia Registrada Correctamente!</div>');

        }
        if (info.resp_emergencia == 'error_insertar') {
          $('.notificacion_contactanos').html('<div class="alert alert-danger" role="alert">Error en el servidor,Intenta mas tarde!</div>');

        }

        }

      }

    });

  }

  $(document).ready(function() {
    // Agrega un evento click al botón
    $("#activateLocation").click(function() {
        // Insertar el contenedor del mapa debajo del botón
        $(".resultado_cuando_la_ubicacion_si").html('<div id="myMap" style="height:300px"><div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
            '</div>  </div>');

        // Verificar si la geolocalización está disponible
        if (navigator.geolocation) {
            console.log('Si se está obteniendo la ubicación');
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.log("Tu navegador no es compatible con la geolocalización.");
        }
    });

    function showPosition(position){
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;

        $("#latitud").val(latitud);
        $("#longitud").val(longitud);

        console.log("Posición obtenida: Latitud = " + latitud + ", Longitud = " + longitud);

        // Inicializar el mapa
        console.log('Posicionando el mapa');
        window.myMap = L.map('myMap').setView([latitud, longitud], 18);

        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(myMap);

        myMap.panTo(new L.LatLng(latitud, longitud));
        L.marker([latitud, longitud]).addTo(myMap);
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                console.log("El usuario denegó la solicitud de geolocalización.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("La información de ubicación no está disponible.");
                break;
            case error.TIMEOUT:
                console.log("La solicitud para obtener la ubicación ha caducado.");
                break;
            case error.UNKNOWN_ERROR:
                console.log("Ocurrió un error desconocido.");
                break;
        }
    }
});

  </script>
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
  <script type="text/javascript">
    $(".owl-2").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,

      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
</body>

</html>
