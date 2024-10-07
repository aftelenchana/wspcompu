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
        <title>Agregar Almacen</title>

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

        <link rel="stylesheet" href="files/bower_components/select2/dist/css/select2.min.css" />

        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/multiselect/css/multi-select.css" />



        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
    </head>

    <body>

     <?php
     require 'scripts/loader.php';


                  require 'scripts/iconos.php';


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
                                                <form action="" method="post" name="add_almacen" id="add_almacen" onsubmit="event.preventDefault(); sendData_almacen();">

                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="mb-3">
                                                        <label for="nombre_producto" class="form-label">Nombre del Almacen</label>
                                                        <input type="text" maxlength="120" name="nombre_almacen" class="form-control" id="nombre_almacen" placeholder="Nombre del Almacen">
                                                      </div>

                                                    </div>
                                                    <div class="col">
                                                      <div class="mb-3">
                                                        <label for="nombre_producto" class="form-label">Responsable</label>
                                                        <input type="text" maxlength="120" name="responsable" class="form-control" id="responsable" placeholder="Nombre del Responsable">
                                                      </div>
                                                    </div>
                                                  </div>


                                                    <div class="mb-3">
                                                      <label for="nombre_producto" class="form-label">Dirección del Alacen</label>
                                                      <input type="text" maxlength="120" name="direccion_almacen" class="form-control" id="direccion_almacen" placeholder="Dirección del Almacen">
                                                    </div>
                                            




                                                  <div class="mb-3">
                                                        <label for="proveedor" class="form-label">Elija la sucursal si no tienes  <a href="add_sucrusales">Agrega una sucursal</a></label>
                                                      <select class="form-control" name="sucursal" id="sucursal">
                                                        <?php
                                                        $query_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.iduser= '$iduser'   AND sucursales.estatus = 1");
                                                        while ($data_sucursal = mysqli_fetch_array($query_sucursal)) {
                                                          echo '<option  value="' . $data_sucursal['id'].'">' . $data_sucursal['direccion_sucursal'] .'</option>';
                                                        }
                                                        ?>
                                                      </select>
                                                  </div>




                                                    <div class="mb-3">
                                                      <label for="descripcion" class="form-label">Agregue una Descripción</label>
                                                      <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion" rows="3"></textarea>
                                                    </div>
                                                    <input type="hidden" name="action" value="agregar_almacen">
                                                    <button type="submit" class="btn btn-primary">Agregar Almacen</button>
                                                    <div class="alerta_almacen"></div>
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

        <!-- Inicio Código para sacar el select  -->
        <script type="text/javascript" src="files/bower_components/select2/dist/js/select2.full.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js">  </script>
        <script type="text/javascript" src="files/bower_components/multiselect/js/jquery.multi-select.js"></script>
        <script type="text/javascript" src="files/assets/js/jquery.quicksearch.js"></script>
        <script type="text/javascript" src="files/assets/pages/advance-elements/select2-custom.js"></script>
       <!-- Final  Código para sacar el select  -->

        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/amcharts.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/serial.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/light.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/custom-dashboard.min.js"></script>
        <script src="files/assets/js/pcoded.min.js"></script>
        <script src="files/assets/js/horizontal-layout.min.js"></script>
        <script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="files/assets/js/script.js"></script>
        <script type="text/javascript" src="jquery_producto/subir_nuevo_productoat.js"></script>

        <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>


    </body>

</html>
