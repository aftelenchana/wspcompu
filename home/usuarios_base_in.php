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
        <title>Usuarios Base</title>

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
                                                  <h5>Usuarios Base</h5>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_usuarios_base" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Acciones</th>
                                                                <th>Nombres</th>
                                                                <th>Apellidos</th>
                                                                <th>Email</th>
                                                                <th>Empresa</th>
                                                                <th>Documentos Electrónicos</th>
                                                                <th>Fecha Máxima de Plan</th>
                                                                <th>Identificación</th>
                                                                <th>Imagen</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Las filas de datos se insertarán aquí automáticamente por DataTables -->
                                                        </tbody>
                                                    </table>
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








                <div class="modal fade" id="modal_editar_plan" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Editar Plan para de <span class="name_user"></span>  </h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="update_plan" >

                          <div class="notificacion_fecha_max"></div>

                          <div class="notificacion_cantidad_documen"></div>

                            <div class="mb-3">
                              <label for="nombre_producto" class="form-label">Ingrese la cantidad de Documentos</label>
                              <input type="number" name="cantid_docuent" class="form-control" id="cantid_docuent" placeholder="Ingrese la Cantidad de Documentos">
                            </div>

                            <div class="mb-3">
                              <label for="nombre_producto" class="form-label">Ingrese la Fecha Máxima</label>
                              <input type="date" maxlength="120" name="fecha_max_doc" class="form-control" id="fecha_max_doc" >
                            </div>


                            <div class="modal-footer">
                              <input type="hidden" name="action" value="editar_plan">
                              <input type="hidden" name="id_plan" id="id_plan" value="">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Editar Plan</button>
                            </div>
                            <div class="alerta_editar_plan"></div>
                          </form>
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
        <script type="text/javascript" src="usuarios_base/usuarios.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>




    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
