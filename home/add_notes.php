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
        <title>Agregar Notas</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
    </head>

    <body>

     <?php
          if ($_SESSION['rol'] == 'cuenta_empresa') {
       require 'scripts/loader.php';
       require 'scripts/iconos.php';

     }


     if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
       require 'scripts_usuario_venta/loader.php';
       require 'scripts_usuario_venta/iconos.php';

     }
              ?>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">

                              <div class="page-body">
                                  <div class="row">
                                      <div class="card-block">
                                          <div class="card product-detail-page">
                                            <div class="">
                                              <div class="card-block">
                                                <form  class="" method="post" name="agregar_nota" id="agregar_nota" onsubmit="event.preventDefault(); sendData_agregar_nota();">
                                                    <div class="mb-3">
                                                  <label for="exampleFormControlTextarea1">Agrega Una nota</label>
                                                      <textarea class="form-control"  name="nota" required id="nota" rows="8"></textarea>
                                                    </div>

                                                    <input type="hidden" name="action" value="agregar_nota" required>
                                                    <button type="submit" class="btn btn-primary">Agregar Nota</button>
                                                    <div class="noticia_agregar_nota">

                                                    </div>
                                                  </form>


                                              </div>
                                            </div>

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
        </div>


        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
  <script src="jquery_comprar/agregar_nota.js"></script>
    <script src="area_facturacion/busqueda_secuencia.js"></script>
    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
