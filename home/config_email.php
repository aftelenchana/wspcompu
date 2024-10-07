<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }

       $iduser= $_SESSION['id'];


  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Configuración Email</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">

    </head>

    <body>

     <?php
     require 'scripts/loader.php';


                  require 'scripts/iconos.php';

                  $host_envio               = $result['host_envio'];
                  $puerto_email_envio       = $result['puerto_email_envio'];
                  $email_user_name_envio    = $result['email_user_name_envio'];
                  $password_envio_email     = $result['password_envio_email'];
                  $descripcion_envio_email  = $result['descripcion_envio_email'];

                  //CODIGO PARA SACAR LA INFOMACION DEL USUARIO

                  if (empty($host_envio)) {
                    $query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$user_in");
                    $result=mysqli_fetch_array($query);
                    $nombres           = $result['nombres'];
                    $firma_electronica = $result['firma_electronica'];
                    $direccion         = $result['direccion'];
                    $codigo_sri        = $result['codigo_sri'];
                    $host_envio               = $result['host_envio'];
                    $puerto_email_envio       = $result['puerto_email_envio'];
                    $email_user_name_envio    = $result['email_user_name_envio'];
                    $password_envio_email     = $result['password_envio_email'];
                    $descripcion_envio_email  = $result['descripcion_envio_email'];

                    if (empty($host_envio)) {
                      $host_envio = 'mail.guibis.com';
                      $serv = 'Servidor Local';
                    }else {
                      $serv = 'Cuenta Usuario Base';
                    }
                    if (empty($puerto_email_envio)) {
                      $puerto_email_envio = '465';
                    }
                    if (empty($password_envio_email)) {
                      $password_envio_email = '';
                    }
                    if (empty($email_user_name_envio)) {
                      $email_user_name_envio = 'prueba_registro@guibis.com';
                    }
                    if (empty($descripcion_envio_email)) {
                      $descripcion_envio_email = 'Hola mundo';
                    }
                  }else {
                    $host_envio               = $result['host_envio'];
                    $puerto_email_envio       = $result['puerto_email_envio'];
                    $email_user_name_envio    = $result['email_user_name_envio'];
                    $password_envio_email     = $result['password_envio_email'];
                    $descripcion_envio_email  = $result['descripcion_envio_email'];

                    $serv = 'Cuenta Usuario';
                  }






              ?>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h4>Configurar Correo Electrónico de Envio <strong><?php echo $serv ?></strong> </h4>
                                              </div>
                                              <div class="card-block">
                                              <form action="" method="post" name="agregar_email_host" id="agregar_email_host" onsubmit="event.preventDefault(); sendDataedit_nuevo_producto();">
                                                  <div class="mb-3">
                                                      <label for="direccion" class="form-label">Ingrese el Host</label>
                                                      <input type="text" class="form-control" required id="direccion" value="<?php echo $host_envio ?>" name="host" placeholder="Ingrese el Host">
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="direccion" class="form-label">Ingrese el Puerto</label>
                                                      <input type="number" class="form-control" required id="puerto" value="<?php echo $puerto_email_envio ?>" name="puerto" placeholder="Ingrese el Puerto">
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="direccion" class="form-label">Ingrese el Usarname Correo Electrónico</label>
                                                      <input type="email" class="form-control" required id="email" name="email_user_name_envio" value="<?php echo $email_user_name_envio ?>" placeholder="Ingrese el Email">
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="direccion" class="form-label">Ingrese la Contraseña</label>
                                                      <input type="text" class="form-control" required id="password" name="password" placeholder="Ingrese la Contraseña">
                                                  </div>
                                                  <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Ingrese un mensaje </label>
                                                    <textarea class="form-control" maxlength="120" required name="descripcion" id="mensaje" rows="3"><?php echo $descripcion_envio_email ?></textarea>
                                                  </div>

                                                  <div class="mb-3">
                                                      <label for="direccion" class="form-label">Ingrese el correo de Recepción</label>
                                                      <input type="email" class="form-control" value="<?php echo $email_user ?>" required id="correo_prueba" name="correo_prueba" placeholder="Ingrese un Email de Recepción">
                                                  </div>

                                                  <input type="hidden" name="action" value="verificar_guardar_email">
                                                  <button type="submit" class="btn btn-primary">Verificar y Guardar</button>
                                                  <br>
                                                  <div class="alerta_agregar_email"></div>
                                                </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                    <div class="col">
                                      <iframe width="90%" height="315" src="https://www.youtube.com/embed/KQKJaEY_EiU?si=JQfH47SUJBWN8xFa" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                                    </div>

                                  </div>



                              </div>
                          </div>
                      </div>
                  </div>

                  <div id="styleSelector"></div>
              </div>

                </div>
            </div>
        </div>

        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>



        <script type="text/javascript" src="files/bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>


        <script type="text/javascript" src="files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

        <script type="text/javascript" src="files/bower_components/chart.js/dist/Chart.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/amcharts.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/serial.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/light.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/custom-dashboard.min.js"></script>
        <script src="files/assets/js/pcoded.min.js"></script>
        <script src="files/assets/js/horizontal-layout.min.js"></script>
        <script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="files/assets/js/script.js"></script>


        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="jquery_administrativo/configurar_email.js"></script>
          <script src="area_facturacion/busqueda_secuencia.js"></script>




    </body>

</html>
