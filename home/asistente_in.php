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
        <title>Asistente Alex</title>

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
        <link href="asistente/style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://guibis.com/estilos/asistente.css">

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
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Asistente Alex</h5>
                                              </div>

                                          </div>



                                          <div class="contenedor_circulo_asistente">
                                            <div id="all">
                                            <div class="item item-1"></div>
                                            <div class="item item-2"></div>
                                            <div class="item item-3"></div>
                                            <div class="item item-4"></div>
                                            <div class="item item-5"></div>
                                            <div class="item item-6"></div>
                                            <div class="item item-7"></div>
                                            <div class="item item-8"></div>
                                            <div class="item item-9"></div>
                                            <div class="item item-10"></div>
                                            <div class="item item-11"></div>
                                            <div class="item item-12"></div>
                                            <div class="item item-13"></div>
                                            <div class="item item-14"></div>
                                            <div class="item item-15"></div>
                                            <div class="item item-16"></div>
                                            <div class="item item-17"></div>
                                            <div class="item item-18"></div>
                                            <div class="item item-19"></div>
                                            <div class="item item-20"></div>
                                            <div class="item item-21"></div>
                                            <div class="item item-22"></div>
                                            <div class="item item-23"></div>
                                            <div class="item item-24"></div>
                                            <div class="item item-25"></div>
                                            <div class="item item-26"></div>
                                            <div class="item item-27"></div>
                                            <div class="item item-28"></div>
                                            <div class="item item-29"></div>
                                            <div class="item item-30"></div>
                                            <div class="item item-31"></div>
                                            <div class="item item-32"></div>
                                            <div class="item item-33"></div>
                                            <div class="item item-34"></div>
                                            <div class="item item-35"></div>
                                            <div class="item item-36"></div>
                                            <div class="item item-37"></div>
                                            <div class="item item-38"></div>
                                            <div class="item item-39"></div>
                                            <div class="item item-40"></div>
                                            <div class="item item-41"></div>
                                            <div class="item item-42"></div>
                                            <div class="item item-43"></div>
                                            <div class="item item-44"></div>
                                            <div class="item item-45"></div>
                                            <div class="item item-46"></div>
                                            <div class="item item-47"></div>
                                            <div class="item item-48"></div>
                                            <div class="item item-49"></div>
                                            <div class="item item-50"></div>
                                            <div class="item item-51"></div>
                                            <div class="item item-52"></div>
                                            <div class="item item-53"></div>
                                            <div class="item item-54"></div>
                                            <div class="item item-55"></div>
                                            <div class="item item-56"></div>
                                            <div class="item item-57"></div>
                                            <div class="item item-58"></div>
                                            <div class="item item-59"></div>
                                            <div class="item item-60"></div>
                                            <div class="item item-61"></div>
                                            <div class="item item-62"></div>
                                            <div class="item item-63"></div>
                                            <div class="item item-64"></div>
                                            <div class="item item-65"></div>
                                            <div class="item item-66"></div>
                                            <div class="item item-67"></div>
                                            <div class="item item-68"></div>
                                            <div class="item item-69"></div>
                                            <div class="item item-70"></div>
                                            <div class="item item-71"></div>
                                            <div class="item item-72"></div>
                                            <div class="item item-73"></div>
                                            <div class="item item-74"></div>
                                            <div class="item item-75"></div>
                                            <div class="item item-76"></div>
                                            <div class="item item-77"></div>
                                            <div class="item item-78"></div>
                                            <div class="item item-79"></div>
                                            <div class="item item-80"></div>
                                            <div class="item item-81"></div>
                                            <div class="item item-82"></div>
                                            <div class="item item-83"></div>
                                            <div class="item item-84"></div>
                                            <div class="item item-85"></div>
                                            <div class="item item-86"></div>
                                            <div class="item item-87"></div>
                                            <div class="item item-88"></div>
                                            <div class="item item-89"></div>
                                            <div class="item item-90"></div>
                                            <div class="item item-91"></div>
                                            <div class="item item-92"></div>
                                            <div class="item item-93"></div>
                                            <div class="item item-94"></div>
                                            <div class="item item-95"></div>
                                            <div class="item item-96"></div>
                                            <div class="item item-97"></div>
                                            <div class="item item-98"></div>
                                            <div class="item item-99"></div>
                                            <div class="item item-100"></div>
                                            </div>

                                            <div id="all2" style="display: none;">
                                                <div class="item item-01"></div>
                                                <div class="item item-02"></div>
                                                <div class="item item-03"></div>
                                                <div class="item item-04"></div>
                                                <div class="item item-05"></div>
                                                <div class="item item-06"></div>
                                                <div class="item item-07"></div>
                                                <div class="item item-08"></div>
                                                <div class="item item-09"></div>
                                                <div class="item item-010"></div>
                                                <div class="item item-011"></div>
                                                <div class="item item-012"></div>
                                                <div class="item item-013"></div>
                                                <div class="item item-014"></div>
                                                <div class="item item-015"></div>
                                                <div class="item item-016"></div>
                                                <div class="item item-017"></div>
                                                <div class="item item-018"></div>
                                                <div class="item item-019"></div>
                                                <div class="item item-020"></div>
                                                <div class="item item-021"></div>
                                                <div class="item item-022"></div>
                                                <div class="item item-023"></div>
                                                <div class="item item-024"></div>
                                                <div class="item item-025"></div>
                                                <div class="item item-026"></div>
                                                <div class="item item-027"></div>
                                                <div class="item item-028"></div>
                                                <div class="item item-029"></div>
                                                <div class="item item-030"></div>
                                                <div class="item item-031"></div>
                                                <div class="item item-032"></div>
                                                <div class="item item-033"></div>
                                                <div class="item item-034"></div>
                                                <div class="item item-035"></div>
                                                <div class="item item-036"></div>
                                                <div class="item item-037"></div>
                                                <div class="item item-038"></div>
                                                <div class="item item-039"></div>
                                                <div class="item item-040"></div>
                                                <div class="item item-041"></div>
                                                <div class="item item-042"></div>
                                                <div class="item item-043"></div>
                                                <div class="item item-044"></div>
                                                <div class="item item-045"></div>
                                                <div class="item item-046"></div>
                                                <div class="item item-047"></div>
                                                <div class="item item-048"></div>
                                                <div class="item item-049"></div>
                                                <div class="item item-050"></div>
                                                <div class="item item-051"></div>
                                                <div class="item item-052"></div>
                                                <div class="item item-053"></div>
                                                <div class="item item-054"></div>
                                                <div class="item item-055"></div>
                                                <div class="item item-056"></div>
                                                <div class="item item-057"></div>
                                                <div class="item item-058"></div>
                                                <div class="item item-059"></div>
                                                <div class="item item-060"></div>
                                                <div class="item item-061"></div>
                                                <div class="item item-062"></div>
                                                <div class="item item-063"></div>
                                                <div class="item item-064"></div>
                                                <div class="item item-065"></div>
                                                <div class="item item-066"></div>
                                                <div class="item item-067"></div>
                                                <div class="item item-068"></div>
                                                <div class="item item-069"></div>
                                                <div class="item item-070"></div>
                                                <div class="item item-071"></div>
                                                <div class="item item-072"></div>
                                                <div class="item item-073"></div>
                                                <div class="item item-074"></div>
                                                <div class="item item-075"></div>
                                                <div class="item item-076"></div>
                                                <div class="item item-077"></div>
                                                <div class="item item-078"></div>
                                                <div class="item item-079"></div>
                                                <div class="item item-080"></div>
                                                <div class="item item-081"></div>
                                                <div class="item item-082"></div>
                                                <div class="item item-083"></div>
                                                <div class="item item-084"></div>
                                                <div class="item item-085"></div>
                                                <div class="item item-086"></div>
                                                <div class="item item-087"></div>
                                                <div class="item item-088"></div>
                                                <div class="item item-089"></div>
                                                <div class="item item-090"></div>
                                                <div class="item item-091"></div>
                                                <div class="item item-092"></div>
                                                <div class="item item-093"></div>
                                                <div class="item item-094"></div>
                                                <div class="item item-095"></div>
                                                <div class="item item-096"></div>
                                                <div class="item item-097"></div>
                                                <div class="item item-098"></div>
                                                <div class="item item-099"></div>
                                                <div class="item item-0100"></div>
                                                </div>
                                          </div>






                                          <center>
                                              <div>
                                                  <button class="btn btn-info" type="button" onclick="start()" id="btn">Empezar Con el Asistente Virtual</button>
                                              </div>
                                          </center>
                                          <div class="" id="text"></div>
                                          <br />
                                          <br />
                                          <div class="card card-warning contendedor_respuesta_asistente">
                                              <div class="card-header">
                                                  <h3 class="card-title">Respuestas</h3>
                                              </div>
                                              <div class="container-fluid">
                                                  <div class="row">
                                                      <div class="col-12">
                                                          <div class="overflow-auto conte_gene_respuesta" id="respuesta_escrita_asistente"></div>
                                                          <div class="elaces"></div>
                                                      </div>
                                                  </div>
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

        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
<script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>



        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="asistente/annyang.min.js"></script>
        <script src="asistente/main.js"></script>




    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
