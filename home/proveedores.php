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
<html lang="en">

    <head>
        <title>Proveedores</title>

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

if ($_SESSION['rol'] == 'Mesero') {
  require 'scripts_mesero/loader.php';
  require 'scripts_mesero/iconos.php';

}

if ($_SESSION['rol'] == 'Cocina') {
  require 'scripts_cocina/loader.php';
  require 'scripts_cocina/iconos.php';

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
                                                  <h5>Proveedores Creados</h5> <button type="button" class="btn btn-primary" id="boton_agregar_almacen" name="button">Agregar Proveedor</button>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Acciones</th>
                                                                <th>Razon Social</th>
                                                                <th>Dirección</th>
                                                                <th>Email</th>
                                                                <th>Celular</th>
                                                                <th>Descripción</th>
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




        <div class="modal fade" id="modal_agregar_almacen" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel">Agregar Proveedor</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body">

                <form action=""  id="add_proveedor" >
                  <div class="mb-3">
                      <label for="razon_social_proveedor" class="form-label">Razón Social del Proveedor</label>
                      <input type="text" class="form-control" name="razon_social_proveedor" required id="razon_social_proveedor" placeholder="Agrega la razón social del Proveedor">
                  </div>

                  <div class="mb-3">
                      <label for="identificacion_proveedor" class="form-label">Identificación del Proveedor</label>
                      <input type="number" class="form-control" id="identificacion_proveedor" name="identificacion_proveedor" placeholder="Identificación del Proveedor">
                  </div>
                  <div class="mb-3">
                      <label for="direccion_proveedro" class="form-label">Dirección del Proveedor</label>
                      <input type="text" class="form-control" id="direccion_proveedro" name="direccion_proveedro" placeholder="Dirección del Proveedor">
                  </div>
                  <div class="mb-3">
                      <label for="celular_proveedor" class="form-label">Celular del Proveedor</label>
                      <input type="text" class="form-control" id="celular_proveedor" name="celular_proveedor" placeholder="Celular del Proveedor">
                  </div>
                  <div class="mb-3">
                      <label for="email_proveedor" class="form-label">Email del Proveedor</label>
                      <input type="email" class="form-control" id="email_proveedor" name="email_proveedor" placeholder="Email del Proveedor">
                  </div>
                  <div class="mb-3">
                      <label for="foto" class="form-label">Imagen del Proveedor</label>
                      <input type="file" class="form-control" name="foto" id="foto">
                  </div>
                  <div class="mb-3">
                      <label for="descripcion_proveedor" class="form-label">Descripción</label>
                      <textarea class="form-control" name="descripcion_proveedor" id="descripcion_proveedor" rows="3"></textarea>
                  </div>



                    <div class="modal-footer">
                      <input type="hidden" name="action" value="agregar_proveedor">
                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                      <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
                    </div>
                    <div class="alerta_proveedor"></div>
                  </form>
              </div>
            </div>
          </div>
        </div>




                <div class="modal fade" id="modal_editar_almacen" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Editar Proveedor</h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="update_proveedor" >
                          <div class="mb-3">
                              <label for="razon_social_proveedor" class="form-label">Razón Social del Proveedor</label>
                              <input type="text" class="form-control" name="razon_social_proveedor" required id="razon_social_proveedor_upload" placeholder="Agrega la razón social del Proveedor">
                          </div>

                          <div class="mb-3">
                              <label for="identificacion_proveedor" class="form-label">Identificación del Proveedor</label>
                              <input type="number" class="form-control" id="identificacion_proveedor_upload" name="identificacion_proveedor" placeholder="Identificación del Proveedor">
                          </div>
                          <div class="mb-3">
                              <label for="direccion_proveedro" class="form-label">Dirección del Proveedor</label>
                              <input type="text" class="form-control" id="direccion_proveedro_upload" name="direccion_proveedro" placeholder="Dirección del Proveedor">
                          </div>
                          <div class="mb-3">
                              <label for="celular_proveedor" class="form-label">Celular del Proveedor</label>
                              <input type="text" class="form-control" id="celular_proveedo_uploadr" name="celular_proveedor" placeholder="Celular del Proveedor">
                          </div>
                          <div class="mb-3">
                              <label for="email_proveedor" class="form-label">Email del Proveedor</label>
                              <input type="email" class="form-control" id="email_proveedor_upload" name="email_proveedor" placeholder="Email del Proveedor">
                          </div>
                          <div class="mb-3">
                              <label for="foto" class="form-label">Imagen del Proveedor</label>
                              <input type="file" class="form-control" name="foto" id="foto">
                          </div>
                          <div class="mb-3">
                              <label for="descripcion_proveedor" class="form-label">Descripción</label>
                              <textarea class="form-control" name="descripcion_proveedor" id="descripcion_proveedor_upload" rows="3"></textarea>
                          </div>

                            <div class="modal-footer">
                              <input type="hidden" name="action" value="editar_proveedor">
                              <input type="hidden" name="id_proveedor" id="id_proveedor" value="">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Editar Proveedor</button>
                            </div>
                            <div class="alerta_editar_almacen"></div>
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
        <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="jquery_administrativo/proveedor.js"></script>



    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
