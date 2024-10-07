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
      <title>Entrar </title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="#" />
      <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
      <meta name="author" content="#" />
      <link rel="icon" href="<?php echo $img_sistema ?>">

      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="home/files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="home/files/assets/icon/themify-icons/themify-icons.css" />
      <link rel="stylesheet" type="text/css" href="home/files/assets/icon/icofont/css/icofont.css" />
      <link rel="stylesheet" type="text/css" href="home/files/assets/css/style.css" />
      <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
      <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">

        <link rel="manifest" href="/manifest.json">

      <link rel="stylesheet" href="estilos/login.css?v=2">
      <link rel="stylesheet" href="./soporte/estilos.css?v=2">
    </head>
    <body>
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

        <div id="pcoded" class="pcoded load-height">
            <div class="pcoded-overlay-box"></div>
      </div>

            <style>
         .boton_contendedot_install {
           text-align: center;
         }
         #btnInstall {
           background-color: #007BFF;
           color: #ffffff;
           border: none;
           padding: 10px 20px;
           font-size: 16px;
           cursor: pointer;
           transition: background-color 0.3s, transform 0.2s;
           animation: vibrate 0.3s linear infinite;
           margin: 0 auto;
           opacity: 0.6; /* 80% de opacidad */
         }
         #btnInstall:hover {
           background-color: #45a049;
             opacity: 0.9; /* 80% de opacidad */

         }
         @keyframes vibrate {
           0% { transform: translateX(0); }
           25% { transform: translateX(-2px); }
           50% { transform: translateX(2px); }
           75% { transform: translateX(-2px); }
           100% { transform: translateX(2px); }
         }
       </style>

       <section class="login-block">
           <div class="container">
               <div class="row">
                   <div class="col-sm-12">
                       <form class="md-float-material form-material" method="post" name="login_usuarios" id="login_usuarios" onsubmit="event.preventDefault(); sendData_login_usuarios();">
                           <div class="text-center">
                               <a href="/"><img src="<?php echo $img_sistema ?>" width="90px;" alt="logo.png" /></a>
                           </div>
                           <div class="auth-box card">
                               <div class="card-block">
                                   <div class="row m-b-20">
                                       <div class="col-md-12">
                                           <h3 class="text-center resultado_nombres_users">Buscar Cuenta</h3>
                                       </div>


                                       <div class="boton_contendedot_install" style="margin: 0 auto;">
                                               <button type="button" id="btnInstall" class="btn btn-primary">Instalar Aplicación</button>
                                       </div>
                                   </div>

                                   <div class="row g-3 " id="resultado_usuarios_cuenta_empresa">
                                       <!-- Tarjeta de usuario 1 -->
                                   </div>
                                   <div class="" id="contendedor_elementos_desaparecer">
                                     <div class="form-group form-primary">
                                         <input type="text" name="mail_user" class="form-control" required placeholder="Ingresa tu Email" />
                                         <span class="form-bar"></span>
                                     </div>
                                     <div class="row m-t-25 text-left">
                                         <div class="col-12">
                                             <div class="forgot-phone text-right f-right">
                                                 <a href="recuperar_password" class="text-right f-w-600">Olvide mi Contraseña?</a>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row m-t-30">
                                         <div class="col-md-12">
                                             <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Buscar Cuenta</button>
                                             <input type="hidden" name="action" value="buscar_usuarios_existentes">
                                         </div>
                                     </div>
                                 </div>

                                   <hr />
                                   <div class="row">
                                       <div class="col-md-10">
                                           <p class="text-inverse text-left m-b-0">Gracias.</p>
                                           <p class="text-inverse text-left">
                                               <a href="/"><b class="f-w-600">Regresar al Inicio</b></a>
                                           </p>
                                           <p class="text-inverse text-left">
                                               <a href="regist"><b class="f-w-600">No tienes una cuenta ? Registrate</b></a>
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
        </div>


        <div class="modal fade" id="modal_acceder_cuentas_iniciadas" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Contenido del modal -->
              <div class="modal-body text-center">

                <div class="row g-3 " id="resultado_cookies_existentes">
                    <!-- Tarjeta de usuario 1 -->
                </div>
                <div class="alerta_ingreso_sistema_rapido">

                </div>

              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

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
        <script type="text/javascript" src="home/files/assets/js/script.js"></script>
        <script src="java/login_usuario.js?v=5"></script>
        <script src="java/cookies.js?v=2"></script>
        <script src="./soporte/mensajes.js"></script>

        <script>
        const btnInstall = document.getElementById('btnInstall');
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
        // Prevenir que el navegador muestre el prompt de instalación
        e.preventDefault();
        // Guardar el evento para poder activarlo más tarde
        deferredPrompt = e;
        // Mostrar el botón de instalación
        btnInstall.style.display = 'block';
        });

        btnInstall.addEventListener('click', (e) => {
        if (deferredPrompt) {
        // Mostrar el prompt de instalación
        deferredPrompt.prompt();
        // Esperar a que el usuario responda al prompt
        deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
        console.log('El usuario aceptó la instalación');
        } else {
        console.log('El usuario rechazó la instalación');
        }
        deferredPrompt = null;
        // Ocultar el botón de instalación
        btnInstall.style.display = 'none';
        });
        }
        });
</script>


    </body>

</html>
