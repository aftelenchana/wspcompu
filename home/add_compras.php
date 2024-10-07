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
        <title>Agregar Compras</title>

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
                                      <div class="card-block" style="margin: 0 auto;">
                                          <div class="card product-detail-page">
                                            <div class="">
                                              <div class="card-block">
                                                <form method="post" name="solicitar_informacion_compra" id="solicitar_informacion_compra" onsubmit="event.preventDefault(); sendData_solciitar_ifnro_compras();">
                                              <div class="mb-3">
                                                  <label for="xml_compras" class="form-label">Agrega el XML de la factura de tu compra</label>
                                                  <input type="file" accept="application/xml" class="form-control" name="xml_compras" required id="xml_compras">
                                              </div>

                                              <div class="mb-3">
                                                  <label for="tipo_movimiento" class="form-label">Tipo Movimiento</label>
                                                  <select class="form-control" name="tipo_movimiento" id="tipo_movimiento">
                                                      <option value="Transferencia">Transferencia</option>
                                                      <option value="Efectivo">Efectivo</option>
                                                      <option value="Cheque">Cheque</option>
                                                  </select>
                                              </div>
                                              <div class="mb-3 elejir_banco_deposito" id="elejir_banco_deposito" >
                                                  <label for="banco_compra" class="form-label">Elige el Banco</label>
                                                  <select class="form-control" name="banco_compra" id="banco_compra">
                                                      <?php
                                                      $query_banco = mysqli_query($conection,"SELECT * FROM cuentas_bancarias_factu WHERE  cuentas_bancarias_factu.iduser= '$iduser'   AND cuentas_bancarias_factu.estatus = 1");
                                                      while ($bancos = mysqli_fetch_array($query_banco)) {
                                                          echo '<option value="'.$bancos['id'].'">'.$bancos['nombre_cuenta'].'/ '.$bancos['numero_cuenta'].'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                              </div>

                                              <div class="mb-3">
                                                  <label for="foto" class="form-label">Agrega la imagen del Boucher</label>
                                                  <input type="file" class="form-control" name="foto" accept="image/png, .jpeg, .jpg" id="foto">
                                              </div>
                                              <div class="mb-3">
                                                  <label for="descripcion_compra" class="form-label">Descripción de Compra</label>
                                                  <textarea class="form-control" name="descripcion_compra" id="descripcion_compra" rows="3"></textarea>
                                              </div>
                                              <input type="hidden" name="action" value="agregar_transportista">
                                              <button type="submit" class="btn btn-primary">Guardar Compra</button>
                                              <div class="notificacion_guardar_compra"></div>
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
        <script type="text/javascript" src="jquery_empresa/agregar_compras.js"></script>

        <script type="text/javascript">
        $(document).ready(function(){
            $("#tipo_movimiento").change(function(){
                var tipo_movimiento = $("#tipo_movimiento").val();
                console.log(tipo_movimiento);
                if (tipo_movimiento == 'Transferencia') {
                    $("#elejir_banco_deposito").css('display', 'block'); // Muestra el elemento
                } else {
                    $("#elejir_banco_deposito").css('display', 'none'); // Oculta el elemento
                }
            });
        });

        </script>

    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
