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

       $ususario = $_GET['ususario'];

       $query_usuario_venta = mysqli_query($conection, "SELECT * FROM usuarios_punto_venta    WHERE usuarios_punto_venta.id =$ususario");
       $data_usuario_venta =mysqli_fetch_array($query_usuario_venta);
       $nombres_usuarios_punto_venta    = $data_usuario_venta['nombres'];
       $direccion_usuario_venta         = $data_usuario_venta['direccion'];
       $mail_usuario_venta              = $data_usuario_venta['mail'];
       $iduser                     =     $data_usuario_venta['iduser'];
       $cambio_password_usuarios_punto_venta   = $data_usuario_venta['cambio_password'];
       $foto_usuarios_punto_venta       = $data_usuario_venta['foto'];
       $fecha_registro_usuario_venta    = $data_usuario_venta['fecha'];
       $url_img_upload_usuario_venta    = $data_usuario_venta['url_img_upload'];
       $identificacion_usuario_venta    = $data_usuario_venta['identificacion'];
       $foto_usuario_venta              = $data_usuario_venta['foto'];
       $ciudad_usuario_venta            = $data_usuario_venta['ciudad'];
       $telefono_usuario_venta          = $data_usuario_venta['telefono'];
       $celular_usuario_venta           = $data_usuario_venta['celular'];





  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Permisos para el Usuario <?php echo $nombres_usuarios_punto_venta ?></title>

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

        $rol_salida = 'cuenta_usuario_venta';


              ?>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>
                            <input type="hidden" name="codigo_usuario" id="codigo_usuario" value="<?php echo $ususario ?>">
                            <input type="hidden" name="rol" id="rol" value="<?php echo $rol_salida ?>">


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Permisos de Usuario <?php echo $nombres_cliente ?> </h5>
                                              </div>

                                              <div class="container mt-4">
                                                    <form id="permisosForm">

                                                      <div class="container mt-4">
                                                          <form id="permisosForm">
                                                              <div class="row row-cols-1 row-cols-md-3 g-4" style="padding: 10px;">
                                                                  <!-- Área de Clientes -->
                                                                  <div class="col">
                                                                    <div class="card h-100 shadow">
                                                                        <div class="card-header">
                                                                            Área de Clientes
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" checked type="checkbox" id="clientes_ver">
                                                                                <label class="form-check-label" for="clientes_ver">Ver</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" checked type="checkbox" id="clientes_editar">
                                                                                <label class="form-check-label" for="clientes_editar">Editar</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" checked type="checkbox" id="clientes_eliminar">
                                                                                <label class="form-check-label" for="clientes_eliminar">Eliminar</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" checked type="checkbox" id="clientes_agregar">
                                                                                <label class="form-check-label" for="clientes_agregar">Agregar</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col">
                                                                  <div class="card h-100 shadow">
                                                                      <div class="card-header">
                                                                          Área de Productos
                                                                      </div>
                                                                      <div class="card-body">
                                                                          <div class="form-check">
                                                                              <input class="form-check-input" checked type="checkbox" id="productos_ver">
                                                                              <label class="form-check-label" for="productos_ver">Ver</label>
                                                                          </div>
                                                                          <div class="form-check">
                                                                              <input class="form-check-input" checked type="checkbox" id="productos_editar">
                                                                              <label class="form-check-label" for="productos_editar">Editar</label>
                                                                          </div>
                                                                          <div class="form-check">
                                                                              <input class="form-check-input" checked type="checkbox" id="productos_eliminar">
                                                                              <label class="form-check-label" for="productos_eliminar">Eliminar</label>
                                                                          </div>
                                                                          <div class="form-check">
                                                                              <input class="form-check-input" checked type="checkbox" id="productos_agregar">
                                                                              <label class="form-check-label" for="productos_agregar">Agregar</label>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>


                                                              <div class="col">
                                                                <div class="card h-100 shadow">
                                                                    <div class="card-header">
                                                                        Área de Facturación
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" checked type="checkbox" id="facturacion">
                                                                            <label class="form-check-label" for="facturacion">Facturación</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" checked type="checkbox" id="tiket_venta">
                                                                            <label class="form-check-label" for="tiket_venta">Ticket de Venta</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" checked type="checkbox" id="nota_venta">
                                                                            <label class="form-check-label" for="nota_venta">Nota de Venta</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" checked type="checkbox" id="proforma">
                                                                            <label class="form-check-label" for="proforma">Proforma</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                <style media="screen">
                                                                .custom-shadow {
                                                                        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                                                                      }

                                                                </style>



                                                                  <!-- Más áreas... -->
                                                              </div>
                                                          </form>
                                                      </div>

                                                        <!-- Más áreas... -->
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

        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="permisos/usuarios_punto_venta.js"></script>
        <script src="permisos/permisos_accion.js"></script>




    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
