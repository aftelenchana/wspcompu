<?php
ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar

  session_start();
  if (!empty($_SESSION['active'])) {
    header('location:home/');
  }




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
        <title>Registrame en <?php echo $empresa_sistema ?> </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="<?php echo $img_sistema ?>" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="home/files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="home/files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="home/files/assets/icon/icofont/css/icofont.css" />
        <link rel="stylesheet" type="text/css" href="home/files/assets/css/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="./soporte/estilos.css?v=2">
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="md-float-material form-material" method="post" name="registrar_usuario_at" id="registrar_usuario_at" onsubmit="event.preventDefault(); sendData_registrar_usuario_at();">
                            <div class="text-center">
                              <a href="/"><img src="<?php echo $img_sistema ?>" width="90px;" alt="logo.png" /></a>

                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center txt-primary">Registrate</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="nombres" class="form-control" required placeholder="Ingresa tus Nombres"
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="apellidos" class="form-control" required placeholder="Ingresa tus Apellidos" />
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="celular" class="form-control" required placeholder="Ingresa tu número Celular" />
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="mail_user" class="form-control" required placeholder="Ingresa tu Email" />
                                        <span class="form-bar"></span>
                                    </div>

                                            <div class="form-group form-primary">
                                                <input type="password" name="password1" class="form-control" required placeholder="Contraseña" />
                                                <span class="form-bar"></span>
                                            </div>

                                    <div class="row m-t-25 text-left">
                                        <div class="col-md-12">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="checkbox" name="checkbox" value="" />
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Acepto  <a href="#">los Terminos y Condiciones.</a></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"  id="registroBtn" disabled  class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Registrarme</button>
                                        </div>
                                    </div>

                                    <div class="alerta_registro_usuario_ast" style="text-align: center;">

                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-10">
                                          <p class="text-inverse text-left m-b-0">Gracias por ser parte de nosotros.</p>
                                          <p class="text-inverse text-left">
                                              <a href="/"><b class="f-w-600">Regresar al Inicio</b></a>
                                            </p>
                                            <p class="text-inverse text-left">
                                                <a href="login"><b class="f-w-600">Ya tienes una cuenta ? Inicia sesión</b></a>
                                              </p>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="<?php echo $img_sistema ?>" width="60px" alt="small-logo.png" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
        require "soporte/modal.php";

         ?>

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
        <script src="java/registrar_usuario.js"></script>
        <script src="./soporte/mensajes.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
  const checkbox = document.querySelector('input[name="checkbox"]');
  const registroBtn = document.getElementById('registroBtn');

  checkbox.addEventListener('change', function() {
    if (checkbox.checked) {
      registroBtn.disabled = false;
    } else {
      registroBtn.disabled = true;
    }
  });
});
</script>




    </body>

</html>
